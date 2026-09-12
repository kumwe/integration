# Integration ownership charter

Integration owns portable versioned event, consumer, envelope, process, transition and neutral store
contracts under the canonical namespace `Kumwe\Integration`.

## Host responsibilities

Core and other hosts own database transactions, transports, dispatch workers, webhook security,
retention and authorization. Production package code never imports Kumwe App.

## Package contract

The package owns portable behavior, boundary and conformance tests, API manifests, archive verification
and consumer examples. [The release contract record](docs/release-record.md) preserves exact source
provenance, symbol mappings and compatibility requirements.

Consumers select independently verified immutable releases and retain host integration tests when
changing an exact package pin. Publication does not establish consumer integration. Each portable symbol
has one canonical owner; namespace aliases, copied vendor implementations and silent runtime fallbacks
are prohibited.
