<?php
declare(strict_types=1);
$root=dirname(__DIR__);
$autoload=getenv('KUMWE_TEST_AUTOLOAD')?:$root.'/vendor/autoload.php';
$loader=require $autoload;
$package=json_decode(file_get_contents($root.'/composer.json'),true,flags:JSON_THROW_ON_ERROR);
foreach($package['autoload']['psr-4'] as $prefix=>$path)$loader->setPsr4($prefix,[$root.'/'.$path]);
