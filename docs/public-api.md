# Public runtime API

Constructors and factories validate source invariants. JSON-taking entry points require an explicit `CanonicalEncoder`. No service provider installs these types into a host. The machine-readable manifest records exact public methods, parameters, return types, constants and interfaces.

| Symbol | Kind | Public members declared here |
| --- | --- | --- |
| `Kumwe\Integration\ConsumerIdempotency` | enum | `cases()`, `from()`, `tryFrom()` |
| `Kumwe\Integration\DomainEvent` | interface |  |
| `Kumwe\Integration\DomainListenerDeclaration` | class | `accepts()`, `eventType()`, `fromManifest()`, `identifier()`, `schemaVersions()`, `sensitivityCeiling()`, `toArray()` |
| `Kumwe\Integration\DomainListenerDefinition` | class | `__construct()`, `accepts()`, `eventType()`, `fromArray()`, `handlerVersion()`, `identifier()`, `priority()`, `schemaVersions()`, `sensitivityCeiling()`, `toArray()` |
| `Kumwe\Integration\EventConsumerDeclaration` | class | `accepts()`, `eventType()`, `fromManifest()`, `identifier()`, `schemaVersions()`, `sensitivityCeiling()`, `toArray()` |
| `Kumwe\Integration\EventConsumerDefinition` | class | `__construct()`, `acceptsVersion()`, `aggregateOrdered()`, `eventType()`, `fromArray()`, `handlerVersion()`, `idempotency()`, `identifier()`, `maximumAttempts()`, `queue()`, `schemaVersions()`, `sensitivityCeiling()`, `toArray()` |
| `Kumwe\Integration\EventContractRegistry` | class | `__construct()`, `assertEvent()`, `consumer()`, `consumersFor()`, `replace()`, `schema()` |
| `Kumwe\Integration\EventEnvelope` | interface | `actorId()`, `aggregateId()`, `aggregateType()`, `aggregateVersion()`, `causationId()`, `correlationId()`, `eventId()`, `eventType()`, `occurredAt()`, `organizationId()`, `payload()`, `schemaVersion()`, `sensitivity()`, `siteIdentifier()`, `systemIdentity()` |
| `Kumwe\Integration\EventSchemaDefinition` | class | `__construct()`, `eventType()`, `fromArray()`, `identifier()`, `maximumBytes()`, `payloadSchema()`, `schemaVersion()`, `sensitivity()`, `toArray()` |
| `Kumwe\Integration\EventSensitivity` | enum | `allowedBy()`, `cases()`, `from()`, `tryFrom()` |
| `Kumwe\Integration\InboxClaimResult` | class | `__construct()` |
| `Kumwe\Integration\InboxDisposition` | enum | `cases()`, `from()`, `tryFrom()` |
| `Kumwe\Integration\InboxLease` | class | `__construct()` |
| `Kumwe\Integration\InboxStore` | interface | `complete()`, `fail()`, `receive()`, `recent()`, `renew()` |
| `Kumwe\Integration\IntegrationContract` | interface | `identifier()`, `toArray()` |
| `Kumwe\Integration\IntegrationContractValidator` | class | `boolean()`, `identifier()`, `identifiers()`, `integer()`, `keys()`, `listField()`, `object()`, `objectField()`, `string()`, `token()` |
| `Kumwe\Integration\IntegrationEvent` | interface |  |
| `Kumwe\Integration\OutboxLease` | class | `__construct()` |
| `Kumwe\Integration\OutboxStore` | interface | `append()`, `claim()`, `complete()`, `defer()`, `fail()`, `purgeExpired()`, `recent()`, `renew()`, `replay()` |
| `Kumwe\Integration\PayloadSchemaValidator` | class | `assertPayload()`, `assertSchema()` |
| `Kumwe\Integration\ProcessInstance` | class | `__construct()`, `actorId()`, `cancel()`, `cancellationBy()`, `cancellationNote()`, `correlationId()`, `createdAt()`, `id()`, `organizationId()`, `processType()`, `siteIdentifier()`, `state()`, `status()`, `systemIdentity()`, `transition()`, `updatedAt()`, `version()` |
| `Kumwe\Integration\ProcessManagerHandler` | interface | `apply()`, `correlationId()`, `processType()`, `start()` |
| `Kumwe\Integration\ProcessManagerStore` | interface | `claimWork()`, `completeWork()`, `create()`, `failWork()`, `findByCorrelation()`, `load()`, `recent()`, `renewWork()`, `save()`, `work()` |
| `Kumwe\Integration\ProcessStatus` | enum | `cases()`, `from()`, `tryFrom()` |
| `Kumwe\Integration\ProcessTransition` | class | `__construct()`, `state()`, `status()`, `work()` |
| `Kumwe\Integration\ProcessWorkItem` | class | `__construct()`, `dueAt()`, `id()`, `kind()`, `maximumAttempts()`, `name()`, `payload()` |
| `Kumwe\Integration\ProcessWorkKind` | enum | `cases()`, `from()`, `tryFrom()` |
| `Kumwe\Integration\ProcessWorkLease` | class | `__construct()` |
| `Kumwe\Integration\RecordedDomainEvent` | class |  |
| `Kumwe\Integration\RecordedEventEnvelope` | class | `__construct()`, `actorId()`, `aggregateId()`, `aggregateType()`, `aggregateVersion()`, `causationId()`, `correlationId()`, `document()`, `eventId()`, `eventType()`, `fromArray()`, `occurredAt()`, `organizationId()`, `payload()`, `schemaVersion()`, `sensitivity()`, `siteIdentifier()`, `systemIdentity()`, `toArray()` |
| `Kumwe\Integration\RecordedIntegrationEvent` | class | `fromDomain()` |
| `Kumwe\Integration\WebhookContributionDefinition` | class | `__construct()`, `accepts()`, `eventTypes()`, `fromArray()`, `handlerVersion()`, `idempotency()`, `identifier()`, `maximumAttempts()`, `queue()`, `schemaVersions()`, `sensitivityCeiling()`, `toArray()` |
| `Kumwe\Integration\WebhookDeclaration` | class | `accepts()`, `eventTypes()`, `fromManifest()`, `identifier()`, `schemaVersions()`, `sensitivityCeiling()`, `toArray()` |
