# Kumwe Integration

[![Latest version][version-badge]][package]
[![Integration CI][ci-badge]][ci]
[![PHP requirement][php-badge]][package]
[![License][license-badge]](LICENSE)

Versioned event envelopes and schemas, validated consumer and webhook declarations, atomic catalog
replacement, immutable process state and work, and neutral inbox, outbox and process-store ports.

## Installation

```bash
composer require kumwe/integration:0.2.3
```

Requires PHP `^8.5`, `ext-mbstring` and the dependencies in [composer.json](composer.json).
Pre-1.0 Kumwe dependencies and consumer installations use independently verified exact version pins.

```php
use Kumwe\Integration\PayloadSchemaValidator;

(new PayloadSchemaValidator())->assertPayload([
    'type' => 'object',
    'required' => ['record_id'],
    'properties' => ['record_id' => ['type' => 'string', 'minLength' => 1]],
    'additionalProperties' => false,
], ['record_id' => 'record-7']);
```

Run [the standalone example](examples/consumer.php) with `composer examples`. An installed consumer can run
`php vendor/kumwe/integration/examples/consumer.php vendor/autoload.php` from its root, or include the
example after loading its own Composer autoloader.

## Contract with Kumwe Core

Integration owns event and consumer declarations, bounded payload validation, deterministic catalogs,
process transitions and neutral persistence ports. Core owns transactions, transport delivery, dispatch,
webhook signing and egress policy, authorization, extension activation and retention enforcement.

JSON-dependent constructors and factories require `Kumwe\CanonicalJson\CanonicalEncoder` explicitly.
Core supplies that encoder. Declaration inputs reject floats, objects, resources, depth over 32 and
collections over 512 before invoking it. Payload and event-envelope profiles keep their own documented
bounds; see [architecture](docs/architecture.md).

The optional `ConfigProvider` and explicit container factory support Laminas/Mezzio composition.
Core supplies admitted declarations and the encoder, controls generation transitions, and synchronizes
shared mutable catalogs when its runtime permits concurrent execution. The factory discovers no
extensions and registers no storage, transport or authorization implementation.

## API and development

See [host composition](docs/integration.md), [public API](docs/public-api.md), [charter](CHARTER.md)
and [release contract record](docs/release-record.md). The record preserves source provenance, symbol
mappings, manifest digests and consumer verification requirements.

```bash
npm ci --prefix tools/governance --ignore-scripts
composer install
composer check
```

The full gate verifies schemas and rejection cases, PHP source and API drift, static analysis, style,
behavior, test ownership, examples, security and release automation. `composer clean-consumer` builds
and installs the actual ZIP into a fresh Composer consumer, then tests installed classes and examples
through its authoritative autoloader. Node.js and schema dependencies are development tooling only.

## Releases and license

Live badges identify the published package and actual default-branch CI status. Publication and passing
package tests do not establish Core adoption or independent release verification.
[Release policy](docs/releasing.md) defines immutable artifact identity, exact pins and consumer evidence.

Licensed under [Apache-2.0](LICENSE).

[version-badge]: https://img.shields.io/packagist/v/kumwe/integration
[package]: https://packagist.org/packages/kumwe/integration
[ci-badge]: https://github.com/kumwe/integration/actions/workflows/ci.yml/badge.svg?branch=main
[ci]: https://github.com/kumwe/integration/actions/workflows/ci.yml
[php-badge]: https://img.shields.io/packagist/dependency-v/kumwe/integration/php
[license-badge]: https://img.shields.io/packagist/l/kumwe/integration
