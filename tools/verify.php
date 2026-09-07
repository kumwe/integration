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
 $forbiddenCalls=['file_get_contents','file_put_contents','fopen','curl_exec','fsockopen','getenv','putenv','exec','shell_exec','system','passthru','pcntl_alarm','pcntl_signal','class_alias'];
 foreach($files as $file)foreach(token_get_all(file_get_contents($file)) as $token){
  if(!is_array($token))continue;
  if(in_array($token[0],[T_INCLUDE,T_INCLUDE_ONCE,T_REQUIRE,T_REQUIRE_ONCE,T_EVAL],true))throw new RuntimeException('Runtime loading is forbidden: '.$file);
  if($token[0]===T_STRING && in_array(strtolower($token[1]),$forbiddenCalls,true))throw new RuntimeException('Host operation in '.$file.': '.$token[1]);
  if(in_array($token[0],[T_NAME_QUALIFIED,T_NAME_FULLY_QUALIFIED],true)){
   $name=ltrim($token[1],'\\');if(!str_contains($name,'\\'))continue;
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
  $params=[];foreach($method->getParameters() as $p)$params[]=['name'=>$p->getName(),'type'=>(string)$p->getType(),'optional'=>$p->isOptional(),'variadic'=>$p->isVariadic(),'reference'=>$p->isPassedByReference()];
  $methods[$method->getName()]=['static'=>$method->isStatic(),'parameters'=>$params,'return'=>(string)$method->getReturnType()];
 }ksort($methods);
 $constants=[];foreach($type->getReflectionConstants(ReflectionClassConstant::IS_PUBLIC) as $c){if($c->getDeclaringClass()->getName()!==$name)continue;$v=$c->getValue();$constants[$c->getName()]=$v instanceof BackedEnum?$v->value:($v instanceof UnitEnum?$v->name:$v);}ksort($constants);
 $api[$name]=['kind'=>$type->isInterface()?'interface':($type->isEnum()?'enum':'class'),'final'=>$type->isFinal(),'readonly'=>$type->isReadOnly(),'parent'=>($type->getParentClass() ?: null)?->getName(),'interfaces'=>$type->getInterfaceNames(),'constants'=>$constants,'methods'=>$methods];
 if($type->isInterface())$ports[]=$name;
}
ksort($api);sort($ports);
$documents=['resources/public-api/v1.json'=>['package'=>$composer['name'],'symbols'=>$api],'resources/service-map/v1.json'=>['package'=>$composer['name'],'ports'=>$ports,'bindings'=>[],'composition'=>'Host supplies explicit constructor dependencies and implements ports. This package performs no automatic registration.']];
foreach($documents as $path=>$data){$bytes=json_encode($data,JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_THROW_ON_ERROR)."\n";if(in_array('--write',$argv,true)){file_put_contents($root.'/'.$path,$bytes);}elseif(!is_file($root.'/'.$path)||file_get_contents($root.'/'.$path)!==$bytes)throw new RuntimeException('Manifest drift: '.$path);}
echo 'Public API and service map: '.count($api)." symbols verified\n";
