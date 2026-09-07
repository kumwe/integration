<?php

declare(strict_types=1);

use Kumwe\Integration\ConfigProvider;
use Kumwe\Integration\EventConsumerDefinition;
use Kumwe\Integration\PayloadSchemaValidator;

require dirname(__DIR__) . '/vendor/autoload.php';

$consumer = new EventConsumerDefinition('acme.search', 'acme.record.changed', [1], '1.0.0');
$validator = new PayloadSchemaValidator();
$validator->assertPayload([
    'type' => 'object',
    'required' => ['record_id'],
    'properties' => ['record_id' => ['type' => 'string', 'minLength' => 1]],
    'additionalProperties' => false,
], ['record_id' => 'record-7']);
$config = (new ConfigProvider())();
if ($config['kumwe']['integration'] !== ['schemas' => [], 'consumers' => []]) {
    throw new RuntimeException('Unexpected integration catalog defaults.');
}
echo $consumer->identifier() . "\n";
