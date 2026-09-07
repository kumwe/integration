<?php
declare(strict_types=1);

use Kumwe\CanonicalJson\CanonicalEncoder;
use Kumwe\Integration\ConfigProvider;
use Kumwe\Integration\Container\EventContractRegistryFactory;
use Kumwe\Integration\EventContractRegistry;
use Laminas\ServiceManager\ServiceManager;

$configuration=(new ConfigProvider())();
check($configuration===(new ConfigProvider())(),'Provider configuration is deterministic');
check($configuration['dependencies']['factories'][EventContractRegistry::class]===EventContractRegistryFactory::class,'Registry uses explicit EventContractRegistryFactory');
$configuration['kumwe']['integration']=['schemas'=>[$schema],'consumers'=>[$consumer]];
$configuration['dependencies']['services']=['config'=>$configuration,CanonicalEncoder::class=>$encoder];
$services=new ServiceManager($configuration['dependencies']);
$composed=$services->get(EventContractRegistry::class);
check($composed===$services->get(EventContractRegistry::class),'Event registry is shared');
check($composed->schema('business.record.changed',1)===$schema,'Factory retains exact configured schema');
check($composed->consumer('acme.search-index')===$consumer,'Factory retains exact configured consumer');
foreach ([['schemas'=>[new stdClass()]],['consumers'=>[null]],['schemas'=>'invalid'],['unknown'=>true]] as $bad) {
 $services=new ServiceManager(['services'=>['config'=>['kumwe'=>['integration'=>$bad]],CanonicalEncoder::class=>$encoder]]);
 rejects(fn()=>(new EventContractRegistryFactory())($services));
}
$services=new ServiceManager(['services'=>[CanonicalEncoder::class=>new stdClass()]]);
rejects(fn()=>(new EventContractRegistryFactory())($services));
