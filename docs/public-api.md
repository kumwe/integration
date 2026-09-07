# Public API

Generated from the package's canonical PHP types and method contracts. Runtime services are composed explicitly with ConfigProvider; value objects are constructed directly. No package service captures host authorization, tenant or transaction state.

## `Kumwe\Integration\ConfigProvider`

Deterministic optional Laminas/Mezzio wiring for the portable event contract registry. */


### `__invoke`

```php
__invoke(): array
```

@return array<string, mixed> Shared registry and empty declarative catalog defaults.

## `Kumwe\Integration\ConsumerIdempotency`

Durable duplicate key a consumer or outbound adapter promises to honour.

@since  0.1.0

- Constant `EVENT_ID`
- Constant `AGGREGATE_VERSION`
- Property `string $name` (readonly)
- Property `string $value` (readonly)

### `cases`

```php
static cases(): array
```



### `from`

```php
static from(string|int $value): static
```



### `tryFrom`

```php
static tryFrom(string|int $value): ?static
```



## `Kumwe\Integration\Container\EventContractRegistryFactory`

Builds one registry from explicitly supplied immutable declarations and canonical encoder. */


### `__invoke`

```php
__invoke(Psr\Container\ContainerInterface $container): Kumwe\Integration\EventContractRegistry
```

@param ContainerInterface $container Supplies config and CanonicalEncoder.
@return EventContractRegistry Shared mutable catalog; host controls atomic replacement.
@throws InvalidArgumentException On malformed config, declarations or encoder dependency.

## `Kumwe\Integration\DomainEvent`

Transaction-local event delivered synchronously. @since 0.2.0 */


## `Kumwe\Integration\DomainListenerDeclaration`

Immutable typed view of one validated manifest domain-listener declaration. @since 0.2.0 */


### `fromManifest`

```php
static fromManifest(array $data): Kumwe\Integration\DomainListenerDeclaration
```

@param array<string, mixed> $data @since 0.2.0 */

### `identifier`

```php
identifier(): string
```

@since 0.2.0 */

### `eventType`

```php
eventType(): string
```

@since 0.2.0 */

### `schemaVersions`

```php
schemaVersions(): array
```

@return list<int> @since 0.2.0 */

### `sensitivityCeiling`

```php
sensitivityCeiling(): Kumwe\Integration\EventSensitivity
```

@since 0.2.0 */

### `accepts`

```php
accepts(Kumwe\Integration\EventEnvelope $event): bool
```

@param EventEnvelope $event Delivered event checked against declared type, schema version, and sensitivity ceiling. @since 0.2.0 */

### `toArray`

```php
toArray(): array
```

@return array<string, mixed> @since 0.2.0 */

## `Kumwe\Integration\DomainListenerDefinition`

Synchronous domain-listener declaration compiled into the trusted runtime generation.

A listener executes inside the authoritative transaction and therefore has no retry contract of
its own: throwing aborts the mutation. Remote calls and other fallible side effects belong in a
durable consumer or job instead.

@since  0.2.0


### `__construct`

```php
__construct(string $listenerId, string $eventType, array $schemaVersions, string $handlerVersion, int $priority = 0, Kumwe\Integration\EventSensitivity $sensitivityCeiling = Kumwe\Integration\EventSensitivity::INTERNAL)
```

Declare one synchronous listener.

@param   string            $listenerId          Globally namespaced listener identity.
@param   string            $eventType           Event contract listened to.
@param   array<array-key, mixed>         $schemaVersions      Explicitly accepted schema revisions.
@param   string            $handlerVersion      Immutable executable revision.
@param   int               $priority            Deterministic order, from -1000 through 1000.
@param   EventSensitivity  $sensitivityCeiling  Most sensitive event this listener accepts.

@throws  InvalidArgumentException  When a declaration field is invalid.

@since   0.2.0

### `identifier`

```php
identifier(): string
```

Return the stable identifier for the domain listener definition.

@return  string  Namespaced listener identity.

@since   0.2.0

### `eventType`

```php
eventType(): string
```

Return the versioned event type accepted by this contract.

@return  string  Event type.

@since   0.2.0

### `schemaVersions`

```php
schemaVersions(): array
```

Return the exact event schema versions accepted by this contribution.

@return  list<int>  Accepted schema revisions.

@since   0.2.0

### `handlerVersion`

```php
handlerVersion(): string
```

Return the handler implementation version used for compatibility checks.

@return  string  Executable revision.

@since   0.2.0

### `priority`

```php
priority(): int
```

Return the priority carried by this domain listener definition.

@return  int  Deterministic dispatch priority.

@since   0.2.0

### `sensitivityCeiling`

```php
sensitivityCeiling(): Kumwe\Integration\EventSensitivity
```

Return the highest event sensitivity this contribution may receive.

@return  EventSensitivity  Disclosure ceiling.

@since   0.2.0

### `accepts`

```php
accepts(string $eventType, int $schemaVersion, Kumwe\Integration\EventSensitivity $sensitivity): bool
```

Determine whether this contribution accepts the supplied event contract.

@param   string            $eventType      Stable namespaced type of the event.
@param   int               $schemaVersion  Exact payload schema version to test.
@param   EventSensitivity  $sensitivity    Event sensitivity level to compare with the ceiling.

@return  bool  Whether this listener accepts the exact event contract revision.

@since   0.2.0

### `toArray`

```php
toArray(): array
```

Serialize the domain listener definition for durable storage or inspection.

@return  array<string, mixed>  Canonical publication representation.

@since   0.2.0

### `fromArray`

```php
static fromArray(array $data): Kumwe\Integration\DomainListenerDefinition
```

Rehydrate one strict manifest declaration.

@param   array<string, mixed>  $data  Exact canonical declaration.

@return  self  Validated listener definition.

@since   0.2.0

## `Kumwe\Integration\EventConsumerDeclaration`

Immutable typed view of one validated manifest durable-consumer declaration. @since 0.2.0 */


### `fromManifest`

```php
static fromManifest(array $data): Kumwe\Integration\EventConsumerDeclaration
```

@param array<string, mixed> $data @since 0.2.0 */

### `identifier`

```php
identifier(): string
```

@since 0.2.0 */

### `eventType`

```php
eventType(): string
```

@since 0.2.0 */

### `schemaVersions`

```php
schemaVersions(): array
```

@return list<int> @since 0.2.0 */

### `sensitivityCeiling`

```php
sensitivityCeiling(): Kumwe\Integration\EventSensitivity
```

@since 0.2.0 */

### `accepts`

```php
accepts(Kumwe\Integration\EventEnvelope $event): bool
```

@param EventEnvelope $event Delivered event checked against declared type, schema version, and sensitivity ceiling. @since 0.2.0 */

### `toArray`

```php
toArray(): array
```

@return array<string, mixed> @since 0.2.0 */

## `Kumwe\Integration\EventConsumerDefinition`

Durable consumer declaration, including versions, ordering and retry semantics.

@since  0.2.0


### `__construct`

```php
__construct(string $consumerId, string $eventType, array $schemaVersions, string $handlerVersion, string $queue = 'default', bool $aggregateOrdered = true, Kumwe\Integration\ConsumerIdempotency $idempotency = Kumwe\Integration\ConsumerIdempotency::EVENT_ID, int $maximumAttempts = 10, Kumwe\Integration\EventSensitivity $sensitivityCeiling = Kumwe\Integration\EventSensitivity::INTERNAL)
```

Declare one durable idempotent consumer.

@param   string               $consumerId          Globally unique namespaced consumer identity.
@param   string               $eventType           Event contract consumed.
@param   array<array-key, mixed>            $schemaVersions      Explicitly accepted schema revisions.
@param   string               $handlerVersion      Immutable executable handler revision.
@param   string               $queue               Logical delivery queue.
@param   bool                 $aggregateOrdered    Whether aggregate versions are processed in order.
@param   ConsumerIdempotency  $idempotency         Durable duplicate-key contract.
@param   int                  $maximumAttempts     Attempt budget before poison quarantine.
@param   EventSensitivity     $sensitivityCeiling  Most sensitive message accepted by this consumer.

@throws  InvalidArgumentException  When a declaration value is invalid.

@since   0.2.0

### `identifier`

```php
identifier(): string
```

Return the stable identifier for the event consumer definition.

@return  string  Consumer identity.

@since   0.2.0

### `eventType`

```php
eventType(): string
```

Return the versioned event type accepted by this contract.

@return  string  Event type.

@since   0.2.0

### `schemaVersions`

```php
schemaVersions(): array
```

Return the exact event schema versions accepted by this contribution.

@return  list<int>  Accepted schema versions.

@since   0.2.0

### `handlerVersion`

```php
handlerVersion(): string
```

Return the handler implementation version used for compatibility checks.

@return  string  Handler revision.

@since   0.2.0

### `queue`

```php
queue(): string
```

Return the declared durable queue identifier.

@return  string  Delivery queue.

@since   0.2.0

### `aggregateOrdered`

```php
aggregateOrdered(): bool
```

Determine whether delivery must preserve aggregate version order.

@return  bool  Whether aggregate sequence is enforced.

@since   0.2.0

### `idempotency`

```php
idempotency(): Kumwe\Integration\ConsumerIdempotency
```

Return the idempotency strategy required by this consumer.

@return  ConsumerIdempotency  Durable duplicate-key contract.

@since   0.2.0

### `maximumAttempts`

```php
maximumAttempts(): int
```

Return the maximum number of delivery attempts.

@return  int  Attempt budget.

@since   0.2.0

### `sensitivityCeiling`

```php
sensitivityCeiling(): Kumwe\Integration\EventSensitivity
```

Return the highest event sensitivity this contribution may receive.

@return  EventSensitivity  Consumer disclosure ceiling.

@since   0.2.0

### `acceptsVersion`

```php
acceptsVersion(int $version): bool
```

Determine whether the consumer accepts the supplied schema version.

@param   int  $version  Exact schema or optimistic-lock version to test.

@return  bool  Whether this exact schema revision is accepted.

@since   0.2.0

### `toArray`

```php
toArray(): array
```

Serialize the event consumer definition for durable storage or inspection.

@return  array<string, mixed>  Canonical publication representation.

@since   0.2.0

### `fromArray`

```php
static fromArray(array $data): Kumwe\Integration\EventConsumerDefinition
```

Parse the closed manifest representation of a durable consumer.

@param   array<string, mixed>  $data  Manifest contribution object.

@return  self  Validated consumer definition.

@since   0.2.0

## `Kumwe\Integration\EventContractRegistry`

Immutable runtime catalog for exactly the event schemas and consumers in one trusted generation.

@since  2.0.0


### `__construct`

```php
__construct(Kumwe\CanonicalJson\CanonicalEncoder $canonicalJson, iterable $schemas, iterable $consumers, Kumwe\Integration\PayloadSchemaValidator $validator = \Kumwe\Integration\PayloadSchemaValidator::__set_state(array(
)))
```

Compile data-only declarations into a collision-free runtime catalog.

@param   iterable<EventSchemaDefinition>    $schemas    Active event schemas.
@param   iterable<EventConsumerDefinition>  $consumers  Active durable consumers.
@param   PayloadSchemaValidator             $validator  Validates schemas and event payloads.

@throws  InvalidArgumentException  When identifiers collide or a consumer names an absent contract.

@since   2.0.0

### `replace`

```php
replace(iterable $schemas, iterable $consumers): void
```

Atomically replace the catalog after the trusted contribution phase has completed.

The container creates this shared instance before providers so extension handlers can depend on
services which themselves publish events. Once every signed provider has reconciled, the active set
replaces the provisional core-only catalog. Existing publishers and stores retain this object and
therefore observe the exact completed runtime generation without service-location or a second graph.

@param   iterable<EventSchemaDefinition>    $schemas    Complete active event schema set.
@param   iterable<EventConsumerDefinition>  $consumers  Complete active durable consumer set.

@return  void

@throws  InvalidArgumentException  When identifiers collide or a consumer names an absent contract.

@since   2.0.0

### `schema`

```php
schema(string $eventType, int $schemaVersion): Kumwe\Integration\EventSchemaDefinition
```

Resolve one exact event contract.

@param   string  $eventType      Stable event type.
@param   int     $schemaVersion  Exact payload revision.

@return  EventSchemaDefinition  Registered definition.

@throws  InvalidArgumentException  When the exact revision is unavailable.

@since   2.0.0

### `assertEvent`

```php
assertEvent(Kumwe\Integration\EventEnvelope $event): void
```

Validate metadata, disclosure and payload against the exact registered schema.

@param   EventEnvelope  $event  Event entering dispatch or durable storage.

@return  void

@throws  InvalidArgumentException  When the event violates its declared contract.

@since   2.0.0

### `consumer`

```php
consumer(string $consumerId): Kumwe\Integration\EventConsumerDefinition
```

Return the consumer carried by this event contract registry.

@param   string  $consumerId  Stable consumer identifier used to scope receipt history.

@return  EventConsumerDefinition  Registered consumer.

@since   2.0.0

### `consumersFor`

```php
consumersFor(Kumwe\Integration\EventEnvelope $event): array
```

Return the consumers for carried by this event contract registry.

@param   EventEnvelope  $event  Versioned event being validated or processed.

@return  list<EventConsumerDefinition>  Consumers accepting this exact event revision.

@since   2.0.0

## `Kumwe\Integration\EventEnvelope`

Read-only, host-neutral view of a validated business event.

@since  0.2.0


### `eventType`

```php
eventType(): string
```

@since 0.2.0 */

### `schemaVersion`

```php
schemaVersion(): int
```

@since 0.2.0 */

### `eventId`

```php
eventId(): string
```

@since 0.2.0 */

### `occurredAt`

```php
occurredAt(): DateTimeImmutable
```

@since 0.2.0 */

### `actorId`

```php
actorId(): ?string
```

@since 0.2.0 */

### `systemIdentity`

```php
systemIdentity(): ?string
```

@since 0.2.0 */

### `siteIdentifier`

```php
siteIdentifier(): string
```

@since 0.2.0 */

### `organizationId`

```php
organizationId(): ?string
```

@since 0.2.0 */

### `aggregateType`

```php
aggregateType(): string
```

@since 0.2.0 */

### `aggregateId`

```php
aggregateId(): string
```

@since 0.2.0 */

### `aggregateVersion`

```php
aggregateVersion(): int
```

@since 0.2.0 */

### `correlationId`

```php
correlationId(): string
```

@since 0.2.0 */

### `causationId`

```php
causationId(): string
```

@since 0.2.0 */

### `sensitivity`

```php
sensitivity(): Kumwe\Integration\EventSensitivity
```

@since 0.2.0 */

### `payload`

```php
payload(): array
```

@return array<string, mixed> @since 0.2.0 */

## `Kumwe\Integration\EventSchemaDefinition`

Versioned, data-only event payload contract compiled into a trusted runtime generation.

@since  2.0.0


### `__construct`

```php
__construct(Kumwe\CanonicalJson\CanonicalEncoder $canonicalJson, string $eventType, int $schemaVersion, Kumwe\Integration\EventSensitivity $sensitivity, array $payloadSchema, int $maximumBytes = Kumwe\Integration\RecordedEventEnvelope::MAX_PAYLOAD_BYTES)
```

Define one immutable event schema revision.

@param   string                $eventType      Stable namespaced event identifier.
@param   int                   $schemaVersion  Contract revision.
@param   EventSensitivity      $sensitivity    Minimum sensitivity of messages under this contract.
@param   array<string, mixed>  $payloadSchema  Declarative JSON Schema subset for payload validation.
@param   int                   $maximumBytes   Per-contract payload ceiling, no higher than the envelope.

@throws  InvalidArgumentException  When an identifier, version, schema or size is invalid.

@since   2.0.0

### `eventType`

```php
eventType(): string
```

Return the versioned event type accepted by this contract.

@return  string  Event type.

@since   2.0.0

### `schemaVersion`

```php
schemaVersion(): int
```

Return the event payload schema version.

@return  int  Schema revision.

@since   2.0.0

### `sensitivity`

```php
sensitivity(): Kumwe\Integration\EventSensitivity
```

Return the sensitivity carried by this event schema definition.

@return  EventSensitivity  Required sensitivity.

@since   2.0.0

### `payloadSchema`

```php
payloadSchema(): array
```

Return the bounded JSON schema governing the payload.

@return  array<string, mixed>  JSON Schema subset.

@since   2.0.0

### `maximumBytes`

```php
maximumBytes(): int
```

Return the maximum bytes carried by this event schema definition.

@return  int  Maximum payload bytes.

@since   2.0.0

### `identifier`

```php
identifier(): string
```

Return the stable identifier for the event schema definition.

@return  string  Type and revision registry key.

@since   2.0.0

### `toArray`

```php
toArray(): array
```

Serialize the event schema definition for durable storage or inspection.

@return  array<string, mixed>  Canonical publication representation.

@since   2.0.0

### `fromArray`

```php
static fromArray(Kumwe\CanonicalJson\CanonicalEncoder $canonicalJson, array $data): Kumwe\Integration\EventSchemaDefinition
```

Parse the closed manifest representation of an event schema.

@param   array<string, mixed>  $data  Manifest contribution object.

@return  self  Validated event schema definition.

@since   2.0.0

## `Kumwe\Integration\EventSensitivity`

Disclosure class carried by every durable business event.

@since  0.1.0

- Constant `PUBLIC`
- Constant `INTERNAL`
- Constant `RESTRICTED`
- Constant `SECRET`
- Property `string $name` (readonly)
- Property `string $value` (readonly)

### `allowedBy`

```php
allowedBy(Kumwe\Integration\EventSensitivity $ceiling): bool
```

Report whether this class may be delivered through a boundary with the supplied ceiling.

@param   self  $ceiling  Most sensitive class the boundary accepts.

@return  bool  True when this value is no more sensitive than the ceiling.

@since   0.1.0

### `cases`

```php
static cases(): array
```



### `from`

```php
static from(string|int $value): static
```



### `tryFrom`

```php
static tryFrom(string|int $value): ?static
```



## `Kumwe\Integration\InboxClaimResult`

Inbox disposition paired with a lease exactly when delivery was claimed.

@since  2.0.0

- Property `Kumwe\Integration\InboxDisposition $disposition` (readonly)
- Property `?Kumwe\Integration\InboxLease $lease` (readonly)

### `__construct`

```php
__construct(Kumwe\Integration\InboxDisposition $disposition, ?Kumwe\Integration\InboxLease $lease = NULL)
```

Build a consistent claim result.

@param   InboxDisposition  $disposition  Explicit delivery outcome.
@param   ?InboxLease       $lease        Fenced claim only for `CLAIMED`.

@throws  InvalidArgumentException  When disposition and lease disagree.

@since   2.0.0

## `Kumwe\Integration\InboxDisposition`

Explicit outcome of offering an event to a durable consumer inbox.

@since  2.0.0

- Constant `CLAIMED`
- Constant `DUPLICATE`
- Constant `REORDERED`
- Constant `BUSY`
- Constant `POISON`
- Constant `UNAVAILABLE`
- Property `string $name` (readonly)
- Property `string $value` (readonly)

### `cases`

```php
static cases(): array
```



### `from`

```php
static from(string|int $value): static
```



### `tryFrom`

```php
static tryFrom(string|int $value): ?static
```



## `Kumwe\Integration\InboxLease`

Consumer delivery reserved under an expiring token and exact runtime generation.

@since  2.0.0

- Property `Kumwe\Integration\EventConsumerDefinition $consumer` (readonly)
- Property `Kumwe\Integration\IntegrationEvent $event` (readonly)
- Property `int $attempts` (readonly)
- Property `string $workerId` (readonly)
- Property `string $leaseToken` (readonly)
- Property `string $runtimeGeneration` (readonly)

### `__construct`

```php
__construct(Kumwe\Integration\EventConsumerDefinition $consumer, Kumwe\Integration\IntegrationEvent $event, int $attempts, string $workerId, string $leaseToken, string $runtimeGeneration)
```

Capture the delivery and proof of its current ownership.

@param   EventConsumerDefinition  $consumer           Consumer contract.
@param   IntegrationEvent         $event              Durable event.
@param   int                      $attempts           Attempts including this claim.
@param   string                   $workerId           Lease owner.
@param   string                   $leaseToken         Fencing token.
@param   string                   $runtimeGeneration  Pinned trusted generation.

@throws  InvalidArgumentException  When lease metadata is malformed.

@since   2.0.0

## `Kumwe\Integration\InboxStore`

Durable per-consumer deduplication, ordering and poison-message ledger.

@since  2.0.0


### `receive`

```php
receive(Kumwe\Integration\EventConsumerDefinition $consumer, Kumwe\Integration\IntegrationEvent $event, string $workerId, string $runtimeGeneration, int $leaseSeconds): Kumwe\Integration\InboxClaimResult
```

Claim or deduplicate an event for the declared consumer.

@param   EventConsumerDefinition  $consumer           Signed consumer contract governing the receipt.
@param   IntegrationEvent         $event              Versioned event being validated or processed.
@param   string                   $workerId           Stable identity of the claiming worker.
@param   string                   $runtimeGeneration  Trusted runtime generation that owns the lease.
@param   int                      $leaseSeconds       Number of seconds before the worker lease expires.

@return  InboxClaimResult

@since   2.0.0

### `renew`

```php
renew(Kumwe\Integration\InboxLease $lease, int $leaseSeconds): void
```

Renew the supplied durable-processing lease.

@param   InboxLease  $lease         Fenced lease proving ownership of the durable item.
@param   int         $leaseSeconds  Number of seconds before the worker lease expires.

@return  void

@since   2.0.0

### `complete`

```php
complete(Kumwe\Integration\InboxLease $lease): void
```

Mark the supplied durable-processing lease complete.

@param   InboxLease  $lease  Fenced lease proving ownership of the durable item.

@return  void

@since   2.0.0

### `fail`

```php
fail(Kumwe\Integration\InboxLease $lease, Kumwe\Automation\FailureClassification $classification, Throwable $failure, ?DateTimeImmutable $retryAt): void
```

Record a failed durable delivery and its retry decision.

@param   InboxLease             $lease           Fenced lease proving ownership of the durable item.
@param   FailureClassification  $classification  Failure class controlling retry or quarantine behavior.
@param   Throwable              $failure         Failure whose retry classification is being recorded.
@param   ?DateTimeImmutable     $retryAt         Next eligible attempt timestamp, or null for quarantine.

@return  void

@since   2.0.0

### `recent`

```php
recent(string $consumerId, int $limit = 100): array
```

Return the most recent operator-visible records.

@param   string  $consumerId  Stable consumer identifier used to scope receipt history.
@param   int     $limit       Maximum number of records the operation may return or change.

@return  list<array<string, mixed>>  Operator-visible delivery rows.

@since   2.0.0

## `Kumwe\Integration\IntegrationContract`

Data-only declaration that may be compiled into a trusted runtime generation.

@since  0.1.0


### `identifier`

```php
identifier(): string
```

Return the stable identifier for the integration contract.

@return  string  Stable identifier used for ownership and collision checks.

@since   0.1.0

### `toArray`

```php
toArray(): array
```

Serialize the integration contract for durable storage or inspection.

@return  array<string, mixed>  Canonical publication representation.

@since   0.1.0

## `Kumwe\Integration\IntegrationContractValidator`

Shared syntax and bounded-JSON checks for trusted integration declarations.

@since  0.2.0


### `keys`

```php
static keys(array $data, array $required, string $label): void
```

Reject unknown or missing keys before a manifest array becomes a definition.

@param   array<string, mixed>  $data      Definition representation.
@param   list<string>          $required  Complete allowed and required key set.
@param   string                $label     Diagnostic definition name.

@return  void

@throws  InvalidArgumentException  When keys differ from the declared closed shape.

@since   0.2.0

### `string`

```php
static string(array $data, string $key): string
```

Read a required string from the supplied data.

@param   array<string, mixed>  $data  Validated contribution data from which the named member is read.
@param   string                $key   Array or row key whose value is being read.

@return  string  Required string stored under the requested key.

@since   0.2.0

### `integer`

```php
static integer(array $data, string $key): int
```

Read and validate an integer value.

@param   array<string, mixed>  $data  Validated contribution data from which the named member is read.
@param   string                $key   Array or row key whose value is being read.

@return  int  Integer stored under the requested key.

@since   0.2.0

### `boolean`

```php
static boolean(array $data, string $key): bool
```

Read and validate a boolean value.

@param   array<string, mixed>  $data  Validated contribution data from which the named member is read.
@param   string                $key   Array or row key whose value is being read.

@return  bool  Boolean stored under the requested key.

@since   0.2.0

### `objectField`

```php
static objectField(array $data, string $key): array
```

Read an object-valued field from the supplied contract.

@param   array<string, mixed>  $data  Validated contribution data from which the named member is read.
@param   string                $key   Array or row key whose value is being read.

@return  array<string, mixed>

@since   0.2.0

### `listField`

```php
static listField(array $data, string $key): array
```

Read a list-valued field from the supplied contract.

@param   array<string, mixed>  $data  Validated contribution data from which the named member is read.
@param   string                $key   Array or row key whose value is being read.

@return  list<mixed>

@since   0.2.0

### `identifier`

```php
static identifier(string $value, string $label): void
```

Require a namespaced contribution identifier.

@param   string  $value  Identifier to check.
@param   string  $label  Diagnostic field name.

@return  void

@throws  InvalidArgumentException  When the identifier is unsafe or not namespaced.

@since   0.2.0

### `token`

```php
static token(string $value, string $label, int $limit = 191): void
```

Require a short safe token, optionally without a namespace.

@param   string  $value  Token to check.
@param   string  $label  Diagnostic field name.
@param   int     $limit  Maximum byte length.

@return  void

@throws  InvalidArgumentException  When the token is empty or contains unsafe bytes.

@since   0.2.0

### `object`

```php
static object(Kumwe\CanonicalJson\CanonicalEncoder $canonicalJson, array $value, string $label, int $limit = 32768): void
```

Prove a JSON object is canonical and within its declaration limit.

@param   array<string, mixed>  $value  JSON object to validate.
@param   string                $label  Diagnostic field name.
@param   int                   $limit  Maximum encoded bytes.

@return  void

@throws  InvalidArgumentException  When the value is a list, not canonical JSON, or too large.

@since   0.2.0

### `identifiers`

```php
static identifiers(array $values, string $label): array
```

Normalize and validate a non-empty unique list of namespaced identifiers.

@param   list<string>  $values  Identifiers to normalize.
@param   string        $label   Diagnostic field name.

@return  list<string>  Sorted unique identifiers.

@throws  InvalidArgumentException  When the list is empty or contains an invalid value.

@since   0.2.0

## `Kumwe\Integration\IntegrationEvent`

Durable event delivered at least once. @since 0.2.0 */


## `Kumwe\Integration\OutboxLease`

One integration event reserved under a worker-, token- and generation-fenced lease.

@since  2.0.0

- Property `Kumwe\Integration\IntegrationEvent $event` (readonly)
- Property `int $attempts` (readonly)
- Property `int $maximumAttempts` (readonly)
- Property `string $workerId` (readonly)
- Property `string $leaseToken` (readonly)
- Property `string $runtimeGeneration` (readonly)

### `__construct`

```php
__construct(Kumwe\Integration\IntegrationEvent $event, int $attempts, int $maximumAttempts, string $workerId, string $leaseToken, string $runtimeGeneration)
```

Capture the durable event and proof of its active reservation.

@param   IntegrationEvent  $event              Reserved event.
@param   int               $attempts           Claims including this attempt.
@param   int               $maximumAttempts    Total attempt budget.
@param   string            $workerId           Lease owner.
@param   string            $leaseToken         Unforgeable fencing token.
@param   string            $runtimeGeneration  Exact trusted generation selecting the dispatcher.

@throws  InvalidArgumentException  When lease metadata is malformed.

@since   2.0.0

## `Kumwe\Integration\OutboxStore`

Transactional event store and fenced dispatch queue.

@since  2.0.0


### `append`

```php
append(Kumwe\Integration\IntegrationEvent $event, int $maximumAttempts = 10, ?DateTimeImmutable $availableAt = NULL): void
```

Append the supplied item to durable storage.

@param   IntegrationEvent    $event            Versioned event being validated or processed.
@param   int                 $maximumAttempts  Delivery-attempt ceiling before quarantine.
@param   ?DateTimeImmutable  $availableAt      Earliest timestamp at which the event may be claimed.

@return  void

@since   2.0.0

### `claim`

```php
claim(string $workerId, string $runtimeGeneration, int $leaseSeconds): ?Kumwe\Integration\OutboxLease
```

Claim the next eligible item for the named worker.

@param   string  $workerId           Stable identity of the claiming worker.
@param   string  $runtimeGeneration  Trusted runtime generation that owns the lease.
@param   int     $leaseSeconds       Number of seconds before the worker lease expires.

@return  ?OutboxLease

@since   2.0.0

### `renew`

```php
renew(Kumwe\Integration\OutboxLease $lease, int $leaseSeconds): void
```

Renew the supplied durable-processing lease.

@param   OutboxLease  $lease         Fenced lease proving ownership of the durable item.
@param   int          $leaseSeconds  Number of seconds before the worker lease expires.

@return  void

@since   2.0.0

### `complete`

```php
complete(Kumwe\Integration\OutboxLease $lease): void
```

Mark the supplied durable-processing lease complete.

@param   OutboxLease  $lease  Fenced lease proving ownership of the durable item.

@return  void

@since   2.0.0

### `defer`

```php
defer(Kumwe\Integration\OutboxLease $lease, int $delaySeconds = 5): void
```

Release a fenced lease after normal downstream backpressure without consuming an attempt.

@param   OutboxLease  $lease         Fenced lease proving ownership of the durable item.
@param   int          $delaySeconds  Bounded delay before another fan-out attempt may claim it.

@return  void

@since   2.0.0

### `fail`

```php
fail(Kumwe\Integration\OutboxLease $lease, Kumwe\Automation\FailureClassification $classification, Throwable $failure, ?DateTimeImmutable $retryAt): void
```

Record a failed durable delivery and its retry decision.

@param   OutboxLease            $lease           Fenced lease proving ownership of the durable item.
@param   FailureClassification  $classification  Failure class controlling retry or quarantine behavior.
@param   Throwable              $failure         Failure whose retry classification is being recorded.
@param   ?DateTimeImmutable     $retryAt         Next eligible attempt timestamp, or null for quarantine.

@return  void

@since   2.0.0

### `replay`

```php
replay(string $eventId, string $operatorId, ?DateTimeImmutable $availableAt = NULL): void
```

Make an operator-authorized event eligible for replay.

@param   string              $eventId      Immutable identifier of the event to replay.
@param   string              $operatorId   Authenticated operator authorizing the replay.
@param   ?DateTimeImmutable  $availableAt  Earliest timestamp at which the event may be claimed.

@return  void

@since   2.0.0

### `purgeExpired`

```php
purgeExpired(DateTimeImmutable $now, int $limit = 1000): int
```

Purge an operator-bounded batch of expired records.

@param   DateTimeImmutable  $now    Authoritative timestamp for the state transition.
@param   int                $limit  Maximum number of records the operation may return or change.

@return  int  Number of retained terminal rows removed.

@since   2.0.0

### `recent`

```php
recent(int $limit = 100): array
```

Return the most recent operator-visible records.

@param   int  $limit  Maximum number of records the operation may return or change.

@return  list<array<string, mixed>>  Operator-visible rows.

@since   2.0.0

## `Kumwe\Integration\PayloadSchemaValidator`

Deterministic validator for the bounded JSON Schema subset integration contributions may publish.

The subset covers object properties, required members, arrays, scalar types, enums and common scalar
bounds. References, combinators and remote schemas are deliberately absent, keeping validation local,
finite and independent of extension code or network access.

@since  2.0.0


### `assertSchema`

```php
assertSchema(array $schema): void
```

Validate a schema itself before it joins a runtime registry.

@param   array<string, mixed>  $schema  Declarative schema object.

@return  void

@throws  InvalidArgumentException  When the schema uses unsupported or malformed declarations.

@since   2.0.0

### `assertPayload`

```php
assertPayload(array $schema, array $payload): void
```

Validate one payload against a previously accepted schema.

@param   array<string, mixed>  $schema   Declarative schema object.
@param   array<string, mixed>  $payload  Event or job payload.

@return  void

@throws  InvalidArgumentException  When the payload violates the contract.

@since   2.0.0

## `Kumwe\Integration\ProcessInstance`

Immutable optimistic state of one generic long-running process.

@since  2.0.0


### `__construct`

```php
__construct(Kumwe\CanonicalJson\CanonicalEncoder $canonicalJson, string $id, string $processType, string $correlationId, string $siteIdentifier, ?string $organizationId, ?string $actorId, ?string $systemIdentity, int $version, Kumwe\Integration\ProcessStatus $status, array $state, DateTimeImmutable $createdAt, DateTimeImmutable $updatedAt, ?string $cancellationBy = NULL, ?string $cancellationNote = NULL)
```

Build a complete persisted process snapshot.

@param   string                $id                Canonical process UUID.
@param   string                $processType       Namespaced process contract.
@param   string                $correlationId     Unique correlation within the process type.
@param   string                $siteIdentifier    Owning site.
@param   ?string               $organizationId    Owning organization when applicable.
@param   ?string               $actorId           Starting human actor.
@param   ?string               $systemIdentity    Starting system actor.
@param   int                   $version           Optimistic state version.
@param   ProcessStatus         $status            Current lifecycle state.
@param   array<string, mixed>  $state             Bounded process-defined JSON object.
@param   DateTimeImmutable     $createdAt         Start instant.
@param   DateTimeImmutable     $updatedAt         Last transition instant.
@param   ?string               $cancellationBy    Operator identity that cancelled it.
@param   ?string               $cancellationNote  Bounded cancellation rationale.

@throws  InvalidArgumentException  When state or metadata violates an invariant.

@since   2.0.0

### `id`

```php
id(): string
```

Return the ID carried by this process instance.

@return  string  Process UUID.

@since   2.0.0

### `processType`

```php
processType(): string
```

Return the stable process-manager type.

@return  string  Process contract.

@since   2.0.0

### `correlationId`

```php
correlationId(): string
```

Derive the process correlation identifier from the event.

@return  string  Process correlation identity.

@since   2.0.0

### `siteIdentifier`

```php
siteIdentifier(): string
```

Return the site identifier carried by this process instance.

@return  string  Owning site.

@since   2.0.0

### `organizationId`

```php
organizationId(): ?string
```

Return the organization ID carried by this process instance.

@return  ?string  Owning organization.

@since   2.0.0

### `actorId`

```php
actorId(): ?string
```

Return the actor ID carried by this process instance.

@return  ?string  Starting human actor.

@since   2.0.0

### `systemIdentity`

```php
systemIdentity(): ?string
```

Return the system identity carried by this process instance.

@return  ?string  Starting system actor.

@since   2.0.0

### `version`

```php
version(): int
```

Return the version carried by this process instance.

@return  int  Optimistic state version.

@since   2.0.0

### `status`

```php
status(): Kumwe\Integration\ProcessStatus
```

Return the status carried by this process instance.

@return  ProcessStatus  Current lifecycle state.

@since   2.0.0

### `state`

```php
state(): array
```

Return the state carried by this process instance.

@return  array<string, mixed>  Process-defined state.

@since   2.0.0

### `createdAt`

```php
createdAt(): DateTimeImmutable
```

Return the created at carried by this process instance.

@return  DateTimeImmutable  Start instant.

@since   2.0.0

### `updatedAt`

```php
updatedAt(): DateTimeImmutable
```

Return the updated at carried by this process instance.

@return  DateTimeImmutable  Last transition instant.

@since   2.0.0

### `cancellationBy`

```php
cancellationBy(): ?string
```

Return the cancellation by carried by this process instance.

@return  ?string  Cancelling operator identity.

@since   2.0.0

### `cancellationNote`

```php
cancellationNote(): ?string
```

Return the cancellation note carried by this process instance.

@return  ?string  Cancellation rationale.

@since   2.0.0

### `transition`

```php
transition(array $state, Kumwe\Integration\ProcessStatus $status, DateTimeImmutable $updatedAt): Kumwe\Integration\ProcessInstance
```

Advance the process by exactly one optimistic version.

@param   array<string, mixed>  $state      Replacement process-defined state.
@param   ProcessStatus         $status     New lifecycle state.
@param   DateTimeImmutable     $updatedAt  Transition instant.

@return  self  Next immutable snapshot.

@since   2.0.0

### `cancel`

```php
cancel(string $operatorId, string $note, DateTimeImmutable $updatedAt): Kumwe\Integration\ProcessInstance
```

Cancel a running process while retaining its last state for operator inspection.

@param   string             $operatorId  Cancelling operator identity.
@param   string             $note        Bounded rationale.
@param   DateTimeImmutable  $updatedAt   Cancellation instant.

@return  self  Cancelled next snapshot.

@since   2.0.0

## `Kumwe\Integration\ProcessManagerHandler`

Pure decision handler for one generic process-manager type.

@since  2.0.0


### `processType`

```php
processType(): string
```

Return the stable process-manager type.

@return  string  Namespaced process type.

@since   2.0.0

### `correlationId`

```php
correlationId(Kumwe\Integration\IntegrationEvent $event): string
```

Derive the process correlation identifier from the event.

@param   IntegrationEvent  $event  Versioned event being validated or processed.

@return  string  Correlation key selecting one process instance.

@since   2.0.0

### `start`

```php
start(Kumwe\Integration\IntegrationEvent $event): Kumwe\Integration\ProcessTransition
```

Create the initial transition for the supplied event.

@param   IntegrationEvent  $event  Versioned event being validated or processed.

@return  ProcessTransition  Initial state and requested durable effects.

@since   2.0.0

### `apply`

```php
apply(Kumwe\Integration\ProcessInstance $process, Kumwe\Integration\IntegrationEvent $event): Kumwe\Integration\ProcessTransition
```

Apply the supplied event to the current process state.

@param   ProcessInstance   $process  Current process instance being read or transitioned.
@param   IntegrationEvent  $event    Versioned event being validated or processed.

@return  ProcessTransition  Next state and requested durable effects.

@since   2.0.0

## `Kumwe\Integration\ProcessManagerStore`

Durable optimistic process state and leased work repository.

@since  2.0.0


### `create`

```php
create(Kumwe\Integration\ProcessInstance $process, iterable $work = array (
)): void
```

Persist a new process instance and its initial work.

@param   ProcessInstance            $process  Current process instance being read or transitioned.
@param   iterable<ProcessWorkItem>  $work     Process work emitted by the transition.

@return  void

@since   2.0.0

### `load`

```php
load(string $processId): ?Kumwe\Integration\ProcessInstance
```

Load the requested durable record when it exists.

@param   string  $processId  Stable identifier of the process instance.

@return  ?ProcessInstance

@since   2.0.0

### `findByCorrelation`

```php
findByCorrelation(string $processType, string $siteIdentifier, string $correlationId): ?Kumwe\Integration\ProcessInstance
```

Find the process instance matching the supplied correlation key.

@param   string  $processType     Stable process-manager type used to scope correlation.
@param   string  $siteIdentifier  Owning site that isolates the correlation namespace.
@param   string  $correlationId   Stable correlation key joining related process events.

@return  ?ProcessInstance

@since   2.0.0

### `save`

```php
save(Kumwe\Integration\ProcessInstance $process, int $expectedVersion, iterable $work = array (
)): void
```

Persist the supplied state with optimistic concurrency protection.

@param   ProcessInstance            $process          Current process instance being read or transitioned.
@param   int                        $expectedVersion  Version required for optimistic concurrency.
@param   iterable<ProcessWorkItem>  $work             Process work emitted by the transition.

@return  void

@since   2.0.0

### `claimWork`

```php
claimWork(string $workerId, string $runtimeGeneration, int $leaseSeconds): ?Kumwe\Integration\ProcessWorkLease
```

Claim the next eligible process work item for the named worker.

@param   string  $workerId           Stable identity of the claiming worker.
@param   string  $runtimeGeneration  Trusted runtime generation that owns the lease.
@param   int     $leaseSeconds       Number of seconds before the worker lease expires.

@return  ?ProcessWorkLease

@since   2.0.0

### `renewWork`

```php
renewWork(Kumwe\Integration\ProcessWorkLease $lease, int $leaseSeconds): void
```

Renew the supplied process-work lease.

@param   ProcessWorkLease  $lease         Fenced lease proving ownership of the durable item.
@param   int               $leaseSeconds  Number of seconds before the worker lease expires.

@return  void

@since   2.0.0

### `completeWork`

```php
completeWork(Kumwe\Integration\ProcessWorkLease $lease): void
```

Mark the supplied process-work lease complete.

@param   ProcessWorkLease  $lease  Fenced lease proving ownership of the durable item.

@return  void

@since   2.0.0

### `failWork`

```php
failWork(Kumwe\Integration\ProcessWorkLease $lease, Kumwe\Automation\FailureClassification $classification, Throwable $failure, ?DateTimeImmutable $retryAt): void
```

Record failed process work and its retry decision.

@param   ProcessWorkLease       $lease           Fenced lease proving ownership of the durable item.
@param   FailureClassification  $classification  Failure class controlling retry or quarantine behavior.
@param   Throwable              $failure         Failure whose retry classification is being recorded.
@param   ?DateTimeImmutable     $retryAt         Next eligible attempt timestamp, or null for quarantine.

@return  void

@since   2.0.0

### `recent`

```php
recent(int $limit = 100): array
```

Return the most recent operator-visible records.

@param   int  $limit  Maximum number of records the operation may return or change.

@return  list<array<string, mixed>>  Operator-visible process snapshots.

@since   2.0.0

### `work`

```php
work(string $processId, int $limit = 100): array
```

Return operator-visible work for the requested process.

@param   string  $processId  Stable identifier of the process instance.
@param   int     $limit      Maximum number of records the operation may return or change.

@return  list<array<string, mixed>>  Operator-visible work for one process.

@since   2.0.0

## `Kumwe\Integration\ProcessStatus`

Durable lifecycle of a generic process-manager instance.

@since  2.0.0

- Constant `RUNNING`
- Constant `COMPLETED`
- Constant `CANCELLED`
- Constant `FAILED`
- Property `string $name` (readonly)
- Property `string $value` (readonly)

### `cases`

```php
static cases(): array
```



### `from`

```php
static from(string|int $value): static
```



### `tryFrom`

```php
static tryFrom(string|int $value): ?static
```



## `Kumwe\Integration\ProcessTransition`

Pure process decision: replacement state, lifecycle and durable requested effects.

@since  2.0.0


### `__construct`

```php
__construct(Kumwe\CanonicalJson\CanonicalEncoder $canonicalJson, array $state, Kumwe\Integration\ProcessStatus $status, iterable $work = array (
))
```

Capture one deterministic process decision.

@param   array<string, mixed>       $state   Replacement state object.
@param   ProcessStatus              $status  Resulting lifecycle.
@param   iterable<ProcessWorkItem>  $work    Durable effects requested with the transition.

@throws  InvalidArgumentException  When work identifiers repeat.

@since   2.0.0

### `state`

```php
state(): array
```

Return the state carried by this process transition.

@return  array<string, mixed>  Replacement process state.

@since   2.0.0

### `status`

```php
status(): Kumwe\Integration\ProcessStatus
```

Return the status carried by this process transition.

@return  ProcessStatus  Resulting lifecycle state.

@since   2.0.0

### `work`

```php
work(): array
```

Return operator-visible work for the requested process.

@return  list<ProcessWorkItem>  Durable requested effects.

@since   2.0.0

## `Kumwe\Integration\ProcessWorkItem`

Immutable timer, command or compensation request emitted by one process transition.

@since  2.0.0


### `__construct`

```php
__construct(Kumwe\CanonicalJson\CanonicalEncoder $canonicalJson, string $id, Kumwe\Integration\ProcessWorkKind $kind, string $name, array $payload, DateTimeImmutable $dueAt, int $maximumAttempts = 10)
```

Define a durable process effect.

@param   string                $id               Canonical work UUID and idempotency key.
@param   ProcessWorkKind       $kind             Timer, command or compensation.
@param   string                $name             Namespaced handler contract.
@param   array<string, mixed>  $payload          Bounded JSON object.
@param   DateTimeImmutable     $dueAt            Earliest execution instant.
@param   int                   $maximumAttempts  Attempt budget.

@throws  InvalidArgumentException  When identity, payload or attempt budget is invalid.

@since   2.0.0

### `id`

```php
id(): string
```

Return the ID carried by this process work item.

@return  string  Work UUID.

@since   2.0.0

### `kind`

```php
kind(): Kumwe\Integration\ProcessWorkKind
```

Return the kind carried by this process work item.

@return  ProcessWorkKind  Work classification.

@since   2.0.0

### `name`

```php
name(): string
```

Return the handler or job name carried by this work item.

@return  string  Handler contract name.

@since   2.0.0

### `payload`

```php
payload(): array
```

Return the validated payload.

@return  array<string, mixed>  Handler payload.

@since   2.0.0

### `dueAt`

```php
dueAt(): DateTimeImmutable
```

Return the due at carried by this process work item.

@return  DateTimeImmutable  Earliest execution instant.

@since   2.0.0

### `maximumAttempts`

```php
maximumAttempts(): int
```

Return the maximum number of delivery attempts.

@return  int  Attempt budget.

@since   2.0.0

## `Kumwe\Integration\ProcessWorkKind`

Explicit durable effect requested by a process transition.

@since  2.0.0

- Constant `TIMER`
- Constant `COMMAND`
- Constant `COMPENSATION`
- Property `string $name` (readonly)
- Property `string $value` (readonly)

### `cases`

```php
static cases(): array
```



### `from`

```php
static from(string|int $value): static
```



### `tryFrom`

```php
static tryFrom(string|int $value): ?static
```



## `Kumwe\Integration\ProcessWorkLease`

Process timer, command or compensation reserved under a fenced generation-pinned lease.

@since  2.0.0

- Property `string $processId` (readonly)
- Property `int $processVersion` (readonly)
- Property `string $siteIdentifier` (readonly)
- Property `?string $organizationId` (readonly)
- Property `Kumwe\Integration\ProcessWorkItem $work` (readonly)
- Property `int $attempts` (readonly)
- Property `string $workerId` (readonly)
- Property `string $leaseToken` (readonly)
- Property `string $runtimeGeneration` (readonly)
- Property `?string $correlationId` (readonly)

### `__construct`

```php
__construct(string $processId, int $processVersion, string $siteIdentifier, ?string $organizationId, Kumwe\Integration\ProcessWorkItem $work, int $attempts, string $workerId, string $leaseToken, string $runtimeGeneration, ?string $correlationId = NULL)
```

Capture process work and proof of its current reservation.

@param   string           $processId          Parent process UUID.
@param   int              $processVersion     Transition version that emitted the work.
@param   string           $siteIdentifier     Normalized site that owns the parent process.
@param   ?string          $organizationId     Normalized organization partition, when present.
@param   ProcessWorkItem  $work               Requested effect.
@param   int              $attempts           Attempts including this claim.
@param   string           $workerId           Lease owner.
@param   string           $leaseToken         Fencing token.
@param   string           $runtimeGeneration  Exact runtime generation selecting the handler.
@param   ?string          $correlationId      End-to-end identifier the parent process was opened
         under, carried so a work item's log lines join the business operation that started it
         without a query against the process table; null when the store did not supply one.

@throws  InvalidArgumentException  When lease metadata is malformed.

@since   2.0.0

## `Kumwe\Integration\RecordedDomainEvent`

Transaction-local fact dispatched synchronously to deterministic domain listeners.

@since  2.0.0


## `Kumwe\Integration\RecordedEventEnvelope`

Immutable, versioned metadata and bounded payload shared by every business event.

Human and system attribution are mutually exclusive. Site and aggregate identity are always present,
while organization is nullable for installation- or site-wide facts. The payload is a JSON object whose
canonical encoding, depth and member count are bounded before it can reach persistence or a handler.

@since  2.0.0

- Constant `MAX_PAYLOAD_BYTES`
- Constant `MAX_PAYLOAD_DEPTH`
- Constant `MAX_PAYLOAD_NODES`

### `__construct`

```php
__construct(Kumwe\CanonicalJson\CanonicalEncoder $canonicalJson, string $eventType, int $schemaVersion, string $eventId, DateTimeImmutable $occurredAt, ?string $actorId, ?string $systemIdentity, string $siteIdentifier, ?string $organizationId, string $aggregateType, string $aggregateId, int $aggregateVersion, string $correlationId, string $causationId, Kumwe\Integration\EventSensitivity $sensitivity, array $payload)
```

Build a complete event envelope.

@param   string                $eventType         Stable namespaced event contract identifier.
@param   int                   $schemaVersion     Payload contract revision, starting at one.
@param   string                $eventId           Canonical UUID identifying this fact across retries.
@param   DateTimeImmutable     $occurredAt        Instant the authoritative mutation recorded the fact.
@param   ?string               $actorId           Human actor identifier, null for a system action.
@param   ?string               $systemIdentity    System identity, null for a human action.
@param   string                $siteIdentifier    Site in which the fact occurred.
@param   ?string               $organizationId    Owning organization, when the fact is organization scoped.
@param   string                $aggregateType     Stable aggregate or entity type.
@param   string                $aggregateId       Aggregate or entity identity.
@param   int                   $aggregateVersion  Authoritative version after the mutation.
@param   string                $correlationId     Identifier shared by the end-to-end operation.
@param   string                $causationId       Event, command or request that directly caused this fact.
@param   EventSensitivity      $sensitivity       Disclosure classification for the complete event.
@param   array<string, mixed>  $payload           Bounded JSON object defined by the event schema.

@throws  InvalidArgumentException  When metadata or payload violates an event invariant.

@since   2.0.0

### `eventType`

```php
eventType(): string
```

Return the versioned event type accepted by this contract.

@return  string  Stable event contract identifier.

@since   2.0.0

### `schemaVersion`

```php
schemaVersion(): int
```

Return the event payload schema version.

@return  int  Payload contract revision.

@since   2.0.0

### `eventId`

```php
eventId(): string
```

Return the event ID carried by this event envelope.

@return  string  Canonical event UUID.

@since   2.0.0

### `occurredAt`

```php
occurredAt(): DateTimeImmutable
```

Return the occurred at carried by this event envelope.

@return  DateTimeImmutable  Occurrence instant.

@since   2.0.0

### `actorId`

```php
actorId(): ?string
```

Return the actor ID carried by this event envelope.

@return  ?string  Human actor identity.

@since   2.0.0

### `systemIdentity`

```php
systemIdentity(): ?string
```

Return the system identity carried by this event envelope.

@return  ?string  System actor identity.

@since   2.0.0

### `siteIdentifier`

```php
siteIdentifier(): string
```

Return the site identifier carried by this event envelope.

@return  string  Owning site identity.

@since   2.0.0

### `organizationId`

```php
organizationId(): ?string
```

Return the organization ID carried by this event envelope.

@return  ?string  Owning organization identity.

@since   2.0.0

### `aggregateType`

```php
aggregateType(): string
```

Return the aggregate type carried by this event envelope.

@return  string  Aggregate type.

@since   2.0.0

### `aggregateId`

```php
aggregateId(): string
```

Return the aggregate ID carried by this event envelope.

@return  string  Aggregate identity.

@since   2.0.0

### `aggregateVersion`

```php
aggregateVersion(): int
```

Return the aggregate version carried by this event envelope.

@return  int  Aggregate version after the mutation.

@since   2.0.0

### `correlationId`

```php
correlationId(): string
```

Derive the process correlation identifier from the event.

@return  string  End-to-end correlation identity.

@since   2.0.0

### `causationId`

```php
causationId(): string
```

Return the causation ID carried by this event envelope.

@return  string  Direct cause identity.

@since   2.0.0

### `sensitivity`

```php
sensitivity(): Kumwe\Integration\EventSensitivity
```

Return the sensitivity carried by this event envelope.

@return  EventSensitivity  Disclosure classification.

@since   2.0.0

### `payload`

```php
payload(): array
```

Return the validated payload.

@return  array<string, mixed>  Validated payload object.

@since   2.0.0

### `toArray`

```php
toArray(): array
```

Export the envelope into its durable transport representation.

@return  array<string, mixed>  Complete metadata and payload.

@since   2.0.0

### `document`

```php
static document(Kumwe\Integration\EventEnvelope $event): array
```

Export any canonical SDK envelope into the App's exact durable representation.

@param   EventEnvelope  $event  Canonical envelope entering App-owned persistence.

@return  array<string, mixed>  Complete metadata and payload.

@since   2.0.0

### `fromArray`

```php
static fromArray(Kumwe\CanonicalJson\CanonicalEncoder $canonicalJson, array $data): static
```

Rehydrate the concrete event class from a durable representation.

@param   array<string, mixed>  $data  Complete envelope representation.

@return  static  Validated event of the class the factory was called on.

@throws  InvalidArgumentException  When a required value is absent or malformed.

@since   2.0.0

## `Kumwe\Integration\RecordedIntegrationEvent`

Durable fact written to the transactional outbox for at-least-once delivery.

@since  2.0.0


### `fromDomain`

```php
static fromDomain(Kumwe\CanonicalJson\CanonicalEncoder $canonicalJson, Kumwe\Integration\DomainEvent $event): Kumwe\Integration\RecordedIntegrationEvent
```

Copy a domain fact into the durable integration-event type without changing its identity.

@param   DomainEvent  $event  Transaction-local fact approved for durable publication.

@return  self  Integration event carrying the same envelope and payload.

@since   2.0.0

## `Kumwe\Integration\WebhookContributionDefinition`

Outbound-adapter declaration without credentials, URLs, or executable request configuration.

The adapter identity resolves trusted code and deployment-owned configuration at runtime. Keeping
destinations and secrets out of the signed manifest avoids turning declarative contributions into
an SSRF or credential-disclosure surface.

@since  0.2.0


### `__construct`

```php
__construct(string $adapterId, array $eventTypes, array $schemaVersions, string $handlerVersion, string $queue, Kumwe\Integration\ConsumerIdempotency $idempotency = Kumwe\Integration\ConsumerIdempotency::EVENT_ID, int $maximumAttempts = 10, Kumwe\Integration\EventSensitivity $sensitivityCeiling = Kumwe\Integration\EventSensitivity::INTERNAL)
```

Declare one durable outbound adapter.

@param   string               $adapterId           Namespaced outbound adapter identity.
@param   list<string>         $eventTypes          Non-empty event type allowlist.
@param   array<array-key, mixed>            $schemaVersions      Exact accepted schema revisions.
@param   string               $handlerVersion      Immutable executable revision.
@param   string               $queue               Declared logical delivery queue.
@param   ConsumerIdempotency  $idempotency         Receipt strategy required before the outbound effect runs.
@param   int                  $maximumAttempts     Attempt budget before quarantine.
@param   EventSensitivity     $sensitivityCeiling  Most sensitive event accepted by the boundary.

@throws  InvalidArgumentException  When a declaration value is invalid.

@since   0.2.0

### `identifier`

```php
identifier(): string
```

Return the stable identifier for the webhook contribution definition.

@return  string  Namespaced outbound adapter identity.

@since   0.2.0

### `eventTypes`

```php
eventTypes(): array
```

Return the event types carried by this webhook contribution definition.

@return  list<string>  Routed event types.

@since   0.2.0

### `schemaVersions`

```php
schemaVersions(): array
```

Return the exact event schema versions accepted by this contribution.

@return  list<int>  Exact accepted schema revisions.

@since   0.2.0

### `accepts`

```php
accepts(string $eventType, int $schemaVersion): bool
```

Determine whether this contribution accepts the supplied event contract.

@param   string  $eventType      Stable namespaced type of the event.
@param   int     $schemaVersion  Exact payload schema version to test.

@return  bool  Whether this adapter accepts an exact event contract.

@since   0.2.0

### `handlerVersion`

```php
handlerVersion(): string
```

Return the handler implementation version used for compatibility checks.

@return  string  Handler revision.

@since   0.2.0

### `queue`

```php
queue(): string
```

Return the declared durable queue identifier.

@return  string  Logical queue identity.

@since   0.2.0

### `maximumAttempts`

```php
maximumAttempts(): int
```

Return the maximum number of delivery attempts.

@return  int  Attempt budget.

@since   0.2.0

### `idempotency`

```php
idempotency(): Kumwe\Integration\ConsumerIdempotency
```

Return the idempotency strategy required by this consumer.

@return  ConsumerIdempotency  Required durable duplicate behavior.

@since   0.2.0

### `sensitivityCeiling`

```php
sensitivityCeiling(): Kumwe\Integration\EventSensitivity
```

Return the highest event sensitivity this contribution may receive.

@return  EventSensitivity  Disclosure ceiling.

@since   0.2.0

### `toArray`

```php
toArray(): array
```

Serialize the webhook contribution definition for durable storage or inspection.

@return  array<string, mixed>  Canonical publication representation.

@since   0.2.0

### `fromArray`

```php
static fromArray(array $data): Kumwe\Integration\WebhookContributionDefinition
```

Reconstitute the webhook contribution definition from validated array data.

@param   array<string, mixed>  $data  Validated contribution data from which the named member is read.

@return  self  Validated adapter declaration.

@since   0.2.0

## `Kumwe\Integration\WebhookDeclaration`

Immutable typed view of one validated manifest webhook declaration. @since 0.2.0 */


### `fromManifest`

```php
static fromManifest(array $data): Kumwe\Integration\WebhookDeclaration
```

@param array<string, mixed> $data @since 0.2.0 */

### `identifier`

```php
identifier(): string
```

@since 0.2.0 */

### `eventTypes`

```php
eventTypes(): array
```

@return list<string> @since 0.2.0 */

### `schemaVersions`

```php
schemaVersions(): array
```

@return list<int> @since 0.2.0 */

### `sensitivityCeiling`

```php
sensitivityCeiling(): Kumwe\Integration\EventSensitivity
```

@since 0.2.0 */

### `accepts`

```php
accepts(Kumwe\Integration\IntegrationEvent $event): bool
```

@param IntegrationEvent $event Candidate event checked against this declaration's type, version, and sensitivity filters. @since 0.2.0 */

### `toArray`

```php
toArray(): array
```

@return array<string, mixed> @since 0.2.0 */
