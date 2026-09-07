# Architecture and ownership

Integration owns event/schema/consumer declarations, bounded payload validation, deterministic catalog composition, process transitions and neutral inbox/outbox/process store contracts. Canonical JSON remains the sole generic serialization owner; Automation remains the retry/scheduling contract owner. There is no transport, queue worker, database adapter, transactional event bus or authorization engine here.

PayloadSchemaValidator validates the schema before evaluating a payload. Empty arrays used as object values remain subject to required properties. Unknown, null, contradictory or non-finite schema bounds fail closed. Every payload branch is bounded to 16 levels and 2048 members per collection, including unconstrained properties; objects, resources, non-finite numbers and invalid UTF-8 are refused. Arrays and object shapes use the explicit schema type to resolve empty-array ambiguity.

EventContractRegistry validates a complete replacement in temporary maps before replacing either live map. Its instance is intentionally mutable and shared; replacement is synchronous and atomic within one PHP operation, not a distributed transaction. A host must provide process synchronization when its runtime shares state across concurrent execution.

The 33 extracted public types retain source ownership. ConfigProvider and Container/EventContractRegistryFactory add package composition without an App dependency. The host supplies the canonical encoder and exact declaration objects, selects the trusted generation and controls authority. App retains durable transaction-plus-outbox, inbox contention, replay, egress/security and worker lifecycle tests.
