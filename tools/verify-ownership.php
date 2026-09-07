<?php
declare(strict_types=1);
$root=dirname(__DIR__);
$read=static fn(string $path):array=>json_decode(file_get_contents($root.'/'.$path),true,flags:JSON_THROW_ON_ERROR);
$api=$read('resources/public-api/v1.json')['symbols'];
$source=$read('resources/migration/source-map.json');
$ownership=$read('resources/migration/test-ownership.json');
$consumers=$read('resources/migration/consumer-inventory.json');
$names=array_keys($api);sort($names);
foreach([array_column($source,'new_fqcn'),array_column($ownership,'symbol'),array_column($consumers,'new_fqcn')] as $mapped){sort($mapped);if($mapped!==$names)throw new RuntimeException('Source/test/consumer closure differs from public API.');}
foreach($source as $entry){if(!is_file($root.'/'.$entry['target_path'])||preg_match('/^[a-f0-9]{64}$/D',$entry['source_sha256'])!==1||preg_match('/^[a-f0-9]{40}$/D',$entry['source_commit'])!==1)throw new RuntimeException('Missing exact source evidence.');}
foreach($ownership as $entry){
 if($entry['kind']!=='interface'&&$entry['portable_tests']===[])throw new RuntimeException('Concrete runtime symbol has no behavior owner.');
 foreach($entry['portable_tests'] as $test){if(!is_file($root.'/'.$test))throw new RuntimeException('Missing package behavior test.');$short=substr($entry['symbol'],strrpos($entry['symbol'],'\\')+1);if(!str_contains(file_get_contents($root.'/'.$test),$short))throw new RuntimeException('Behavior owner does not reference '.$entry['symbol']);}
}
echo 'Source, behavior-owner and consumer inventories cover '.count($names)." public symbols\n";
