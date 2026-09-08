# kumwe/integration

Versioned event envelopes and schemas, validated consumer/webhook declarations, atomic contract catalog replacement, immutable process state/work, and neutral inbox/outbox/process store ports.

The package contains 33 extracted portable public types plus two explicit composition types. Transactions, transport delivery, dispatch, webhook signing/egress, authorization, extension activation and retention enforcement remain App-owned.

JSON-dependent constructors and factories require `Kumwe\CanonicalJson\CanonicalEncoder` explicitly. The host supplies its encoder; this package contains no executor. Declaration inputs still reject floats, objects, resources, depth over 32 and collections over 512 before calling the generic encoder. The generic job payload and event-envelope profiles retain their distinct source behavior and limits.

Run `composer install` then `composer check`. `composer clean-consumer` builds a ZIP, installs it into a fresh Composer consumer and runs behavior tests against classes loaded only from that archive. During development, `KUMWE_TEST_AUTOLOAD` can identify a separate consumer's autoloader, and `KUMWE_CONSUMER_CONFIG` can provide explicit development repositories and dependency aliases. These development checks are not publication evidence.

The optional final ConfigProvider and Container factories support explicit Laminas/Mezzio composition. See [host composition](docs/integration.md), [architecture](docs/architecture.md), [complete public API](docs/public-api.md), and [release policy](docs/releasing.md).

See [MIGRATION-HANDOFF.md](MIGRATION-HANDOFF.md) for exact source mapping, intentional signature changes, ownership boundaries and release blockers. Public signatures and neutral ports are checked against `resources/public-api/v1.json` and `resources/service-map/v1.json`.

The shipped example supports source-checkout execution (`php examples/consumer.php`) and installed CLI execution from a consumer root (`php vendor/kumwe/integration/examples/consumer.php vendor/autoload.php`). A consumer may also include it after loading its own Composer autoloader; no nested vendor directory is required.
