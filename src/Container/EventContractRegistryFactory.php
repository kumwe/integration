<?php

declare(strict_types=1);

namespace Kumwe\Integration\Container;

use InvalidArgumentException;
use Kumwe\CanonicalJson\CanonicalEncoder;
use Kumwe\Integration\EventConsumerDefinition;
use Kumwe\Integration\EventContractRegistry;
use Kumwe\Integration\EventSchemaDefinition;
use Psr\Container\ContainerInterface;

/** Builds one registry from explicitly supplied immutable declarations and canonical encoder. */
final class EventContractRegistryFactory
{
    /**
     * @param ContainerInterface $container Supplies config and CanonicalEncoder.
     * @return EventContractRegistry Shared mutable catalog; host controls atomic replacement.
     * @throws InvalidArgumentException On malformed config, declarations or encoder dependency.
     */
    public function __invoke(ContainerInterface $container): EventContractRegistry
    {
        $config = $container->has('config') ? $container->get('config') : [];
        if (!is_array($config)) {
            throw new InvalidArgumentException('Container config must be an array.');
        }
        $kumwe = $config['kumwe'] ?? [];
        if (!is_array($kumwe)) {
            throw new InvalidArgumentException('kumwe config must be an array.');
        }
        $options = $kumwe['integration'] ?? [];
        if (!is_array($options) || array_diff(array_keys($options), ['schemas', 'consumers']) !== []) {
            throw new InvalidArgumentException('Invalid kumwe.integration configuration.');
        }
        $schemas = $options['schemas'] ?? [];
        $consumers = $options['consumers'] ?? [];
        if (
            !is_array($schemas) || !array_is_list($schemas)
            || !is_array($consumers) || !array_is_list($consumers)
        ) {
            throw new InvalidArgumentException('Integration schemas and consumers must be lists.');
        }
        foreach ($schemas as $schema) {
            if (!$schema instanceof EventSchemaDefinition) {
                throw new InvalidArgumentException('Integration schemas must contain EventSchemaDefinition values.');
            }
        }
        foreach ($consumers as $consumer) {
            if (!$consumer instanceof EventConsumerDefinition) {
                throw new InvalidArgumentException(
                    'Integration consumers must contain EventConsumerDefinition values.',
                );
            }
        }
        $encoder = $container->get(CanonicalEncoder::class);
        if (!$encoder instanceof CanonicalEncoder) {
            throw new InvalidArgumentException('Integration requires a CanonicalEncoder service.');
        }
        return new EventContractRegistry($encoder, $schemas, $consumers);
    }
}
