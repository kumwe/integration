<?php

declare(strict_types=1);

namespace Kumwe\Integration;

use Kumwe\CanonicalJson\CanonicalEncoder;
use Kumwe\Integration\DomainEvent;
use Kumwe\Integration\IntegrationEvent;

/**
 * Durable fact written to the transactional outbox for at-least-once delivery.
 *
 * @since  2.0.0
 */
final readonly class RecordedIntegrationEvent extends RecordedEventEnvelope implements IntegrationEvent
{
    /**
     * Copy a domain fact into the durable integration-event type without changing its identity.
     *
     * @param   DomainEvent  $event  Transaction-local fact approved for durable publication.
     *
     * @return  self  Integration event carrying the same envelope and payload.
     *
     * @since   2.0.0
     */
    public static function fromDomain(CanonicalEncoder $canonicalJson, DomainEvent $event): self
    {
        return self::fromArray($canonicalJson, RecordedEventEnvelope::document($event));
    }
}
