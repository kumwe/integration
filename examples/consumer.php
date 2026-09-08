<?php

declare(strict_types=1);

use Kumwe\Integration\ConfigProvider;
use Kumwe\Integration\EventConsumerDefinition;
use Kumwe\Integration\PayloadSchemaValidator;

$autoload = $argv[1] ?? dirname(__DIR__) . '/vendor/autoload.php';
if (isset($argv[1]) || !class_exists(EventConsumerDefinition::class)) {
    if (!is_file($autoload) || !is_readable($autoload)) {
        throw new RuntimeException('Composer autoload file is missing or unreadable: ' . $autoload);
    }
    require_once $autoload;
}

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
