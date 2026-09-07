<?php
declare(strict_types=1);
$root=dirname(__DIR__);
$composer=json_decode(file_get_contents($root.'/composer.json'),true,flags:JSON_THROW_ON_ERROR);
$prefix=array_key_first($composer['autoload']['psr-4']);
$files=[];
foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root.'/src')) as $file) if($file->isFile()&&$file->getExtension()==='php')$files[]=$file->getPathname();sort($files);
if(in_array('--lint',$argv,true)) {foreach($files as $file){passthru(escapeshellarg(PHP_BINARY).' -l '.escapeshellarg($file),$status);if($status!==0)exit($status);}exit(0);}
if(in_array('--architecture',$argv,true)) {
 $allowed=[$prefix,'Kumwe\\CanonicalJson\\','Kumwe\\Contribution\\','Kumwe\\Context\\','Psr\\Clock\\'];
 if($composer['name']==='kumwe/integration')$allowed=[...$allowed,'Kumwe\\Automation\\','Ramsey\\Uuid\\'];
 $forbiddenCalls=['file_get_contents','file_put_contents','fopen','curl_exec','fsockopen','getenv','putenv','exec','shell_exec','system','passthru','call_user_func','call_user_func_array','pcntl_alarm','pcntl_signal','class_alias'];
 foreach($files as $file)foreach(token_get_all(file_get_contents($file)) as $token){
  if(!is_array($token))continue;
  if(in_array($token[0],[T_INCLUDE,T_INCLUDE_ONCE,T_REQUIRE,T_REQUIRE_ONCE,T_EVAL],true))throw new RuntimeException('Runtime loading is forbidden: '.$file);
  if(in_array($token[0],[T_STRING,T_NAME_FULLY_QUALIFIED],true) && in_array(strtolower(ltrim($token[1],'\\')),$forbiddenCalls,true))throw new RuntimeException('Host operation in '.$file.': '.$token[1]);
  if(in_array($token[0],[T_NAME_QUALIFIED,T_NAME_FULLY_QUALIFIED],true)){
   $name=ltrim($token[1],'\\');if(!str_contains($name,'\\'))continue;
   if(str_starts_with($name, 'Psr\\Container\\') && str_contains($file, '/Container/')) continue;
   if(!array_any($allowed,static fn(string $p):bool=>str_starts_with($name,$p) || $name === rtrim($p,'\\')))throw new RuntimeException('Undeclared dependency '.$name.' in '.$file);
  }
 }
 echo 'Architecture boundary passed for '.count($files)." files\n";exit(0);
}
$autoload=getenv('KUMWE_TEST_AUTOLOAD')?:$root.'/vendor/autoload.php';
if(!is_file($autoload))throw new RuntimeException('Install dependencies or set KUMWE_TEST_AUTOLOAD.');require $autoload;
spl_autoload_register(static function(string $name)use($prefix,$root):void{if(str_starts_with($name,$prefix)){ $file=$root.'/src/'.str_replace('\\','/',substr($name,strlen($prefix))).'.php';if(is_file($file))require $file;}},true,true);
$api=[];$ports=[];
foreach($files as $file){
 $name=$prefix.str_replace('/','\\',substr($file,strlen($root.'/src/'),-4));$type=new ReflectionClass($name);
 if(str_contains($name,'\\Internal\\'))continue;
 $methods=[];foreach($type->getMethods(ReflectionMethod::IS_PUBLIC) as $method){
  if($method->getDeclaringClass()->getName()!==$name)continue;
  $params=[];foreach($method->getParameters() as $p)$params[]=['name'=>$p->getName(),'type'=>(string)$p->getType(),'optional'=>$p->isOptional(),'variadic'=>$p->isVariadic(),'reference'=>$p->isPassedByReference(),'default'=>$p->isDefaultValueAvailable()?$p->getDefaultValue():null];
  $methods[$method->getName()]=['static'=>$method->isStatic(),'parameters'=>$params,'return'=>(string)$method->getReturnType()];
 }ksort($methods);
 $constants=[];foreach($type->getReflectionConstants(ReflectionClassConstant::IS_PUBLIC) as $c){if($c->getDeclaringClass()->getName()!==$name)continue;$v=$c->getValue();$constants[$c->getName()]=$v instanceof BackedEnum?$v->value:($v instanceof UnitEnum?$v->name:$v);}ksort($constants);
 $properties=[];foreach($type->getProperties(ReflectionProperty::IS_PUBLIC) as $property){if($property->getDeclaringClass()->getName()!==$name)continue;$properties[$property->getName()]=['type'=>(string)$property->getType(),'readonly'=>$property->isReadOnly(),'static'=>$property->isStatic()];}ksort($properties);
 $api[$name]=['kind'=>$type->isInterface()?'interface':($type->isEnum()?'enum':'class'),'final'=>$type->isFinal(),'readonly'=>$type->isReadOnly(),'parent'=>($type->getParentClass() ?: null)?->getName(),'interfaces'=>$type->getInterfaceNames(),'constants'=>$constants,'properties'=>$properties,'methods'=>$methods];
 if($type->isInterface())$ports[]=$name;
}
ksort($api);sort($ports);
require __DIR__.'/manifest-profile.php';
$profile=packageProfile($api,$composer,$root);
$documents=['resources/public-api/v1.json'=>$profile]+packageSupportProfiles($profile,$composer);
foreach($documents as $path=>$data){$bytes=json_encode($data,JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_THROW_ON_ERROR)."\n";if(in_array('--write',$argv,true)){file_put_contents($root.'/'.$path,$bytes);}elseif(!is_file($root.'/'.$path)||file_get_contents($root.'/'.$path)!==$bytes)throw new RuntimeException('Manifest drift: '.$path);}
echo 'Public API and service map: '.count($api)." symbols verified\n";

$documentation="# Public API\n\nGenerated from the package's canonical PHP types and method contracts. Runtime services are composed explicitly with ConfigProvider; value objects are constructed directly. No package service captures host authorization, tenant or transaction state.\n\n";
foreach($api as $name=>$definition) {
 $type=new ReflectionClass($name);
 $documentation.='## `'.$name."`\n\n";
 $comment=preg_replace('/^\s*\*\/? ?/m','',substr($type->getDocComment()?:'',3));
 $documentation.=trim($comment)."\n\n";
 foreach($type->getReflectionConstants(ReflectionClassConstant::IS_PUBLIC) as $constant) {
  if($constant->getDeclaringClass()->getName()===$name)$documentation.='- Constant `'.$constant->getName()."`\n";
 }
 foreach($type->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
  if($property->getDeclaringClass()->getName()===$name)$documentation.='- Property `'.(string)$property->getType().' $'.$property->getName().'`'.($property->isReadOnly()?' (readonly)':'')."\n";
 }
 $documentation.="\n";
 foreach($type->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
  if($method->getDeclaringClass()->getName()!==$name)continue;
  $parameters=[];
  foreach($method->getParameters() as $parameter) {
   $part=(string)$parameter->getType().' '.($parameter->isVariadic()?'...':'').'$'.$parameter->getName();
   if($parameter->isDefaultValueAvailable())$part.=' = '.($parameter->isDefaultValueConstant()?$parameter->getDefaultValueConstantName():var_export($parameter->getDefaultValue(),true));
   $parameters[]=$part;
  }
  $documentation.='### `'.$method->getName()."`\n\n```php\n".($method->isStatic()?'static ':'').$method->getName().'('.implode(', ',$parameters).')'.($method->hasReturnType()?': '.(string)$method->getReturnType():'')."\n```\n\n";
  $comment=preg_replace('/^\s*\*\/? ?/m','',substr($method->getDocComment()?:'',3));
  $documentation.=trim($comment)."\n\n";
 }
}
$documentation=rtrim($documentation)."\n";
$docPath=$root.'/docs/public-api.md';
if(in_array('--write',$argv,true))file_put_contents($docPath,$documentation);
elseif(!is_file($docPath)||file_get_contents($docPath)!==$documentation)throw new RuntimeException('Public API documentation drift; run composer manifests:record.');
