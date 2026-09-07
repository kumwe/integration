<?php

declare(strict_types=1);

namespace Kumwe\Integration;

use Kumwe\Integration\Container\EventContractRegistryFactory;

/** Deterministic optional Laminas/Mezzio wiring for the portable event contract registry. */
final class ConfigProvider
{
    /**
     * @return array<string, mixed> Shared registry and empty declarative catalog defaults.
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => [
                'factories' => [EventContractRegistry::class => EventContractRegistryFactory::class],
                'shared' => [EventContractRegistry::class => true],
            ],
            'kumwe' => ['integration' => ['schemas' => [], 'consumers' => []]],
        ];
    }
}
