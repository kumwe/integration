<?php
declare(strict_types=1);
$root=dirname(__DIR__);$package=json_decode(file_get_contents($root.'/composer.json'),true,flags:JSON_THROW_ON_ERROR);
$configFile=getenv('KUMWE_CONSUMER_CONFIG');$config=$configFile?json_decode(file_get_contents($configFile),true,flags:JSON_THROW_ON_ERROR):[];
$directory=sys_get_temp_dir().'/kumwe-consumer-'.bin2hex(random_bytes(8));mkdir($directory,0700,true);
function run(array $command,string $cwd,?array $env=null):void{$process=proc_open($command,[STDIN,STDOUT,STDERR],$pipes,$cwd,$env);if(!is_resource($process)||proc_close($process)!==0)throw new RuntimeException('Consumer command failed: '.implode(' ',$command));}
run(['composer','archive','--format=zip','--file=package','--dir='.$directory,'--no-interaction'],$root);
$archive=$directory.'/package.zip';
$metadata=$package;unset($metadata['autoload-dev'],$metadata['scripts'],$metadata['require-dev'],$metadata['archive']);
$metadata['version']='dev-candidate';$metadata['dist']=['type'=>'zip','url'=>'file://'.$archive];
$requires=[$package['name']=>'dev-candidate'];foreach(($config['require']??[]) as $name=>$version)if(isset($package['require'][$name]))$requires[$name]=$version;
$repositories=[['type'=>'package','package'=>$metadata]];
foreach(($config['repositories']??[]) as $repository){if(isset($repository['options']['versions'][$package['name']]))continue;$repositories[]=$repository;}
$consumer=['name'=>'kumwe-test/archive-consumer','require'=>$requires,'repositories'=>$repositories,'minimum-stability'=>$config?'dev':'stable','prefer-stable'=>true,'config'=>['allow-plugins'=>false]];
file_put_contents($directory.'/composer.json',json_encode($consumer,JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_THROW_ON_ERROR));
run(['composer','update','--no-dev','--no-scripts','--no-plugins','--prefer-dist','--no-interaction'],$directory);
require $directory.'/vendor/autoload.php';
$prefix=realpath($directory.'/vendor/'.$package['name'].'/src').DIRECTORY_SEPARATOR;
$api=json_decode(file_get_contents($root.'/resources/public-api/v1.json'),true,flags:JSON_THROW_ON_ERROR);
foreach(array_keys($api['symbols']) as $name){$type=new ReflectionClass($name);if(!str_starts_with(realpath($type->getFileName()),$prefix))throw new RuntimeException('Consumer escaped archive: '.$name);}
$env=getenv();$env['KUMWE_TEST_AUTOLOAD']=$directory.'/vendor/autoload.php';run([PHP_BINARY,$root.'/tests/run.php'],$directory,$env);
echo 'Archive consumer passed: '.count($api['symbols']).' types; sha256='.hash_file('sha256',$archive)."\n";
echo ($config?'Development dependency coordinates were explicitly supplied; this is not immutable release verification.':'Only declared stable dependency constraints were used.')."\n";
echo 'Evidence directory: '.$directory."\n";
