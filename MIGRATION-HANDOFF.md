# Runtime extraction handoff

Change set: KUMWE-CS-2026-027. Migration: KUMWE-MIG-2026-027. Non-roadmap: NRM-2026-027.

## Exact source and target

`resources/migration/source-map.json` records all 33 moved public types, their old and new fully qualified names, source repository commit, source file SHA-256 and target path. No App/SDK consumer is modified by this branch. Package types are canonical candidates until independently released and adopted; no aliases or runtime fallback are supplied.

## Intentional adaptation

Namespaces follow the canonical package catalog. JSON-taking constructors and factories accept an explicit `CanonicalEncoder`; immutable transitions retain that same encoder. Declaration validation preserves the SDK no-float, 32-depth, 512-member profile before generic encoding. The generic encoder implementation remains external. Automation's private declaration validator is an internal policy boundary, not an exported second canonical encoder. Contribution and context references point to their canonical dependency namespaces.

## Retained authority

Transactions, transport delivery, dispatch, webhook signing/egress, authorization, extension activation and retention enforcement remain App-owned.

## Evidence and remaining gates

`composer check` validates the Composer manifest, parses runtime PHP, checks token-level architecture boundaries, compares all public methods/constants and ports, and executes package-owned behavior tests, maximum PHPStan and PSR-12 checks. `composer clean-consumer` verifies archive loading of every public type and reruns those behavior tests outside the source checkout. `resources/migration/test-ownership.json` maps each concrete type to package behavior tests and records host tests retained at source. Neutral interfaces are covered by the API and archive gates. `resources/migration/consumer-inventory.json` records exact fully qualified source consumers and explicitly flags same-namespace/dynamic references for adoption review. Source provenance is not an assertion that App behavior tests or host infrastructure tests have moved.

The package now requires published Automation 0.1.0, Canonical JSON 0.1.1, Contribution 0.1.0 and Access Context 0.1.0. Automation v0.1.0 was published from commit 88e62d37e5c7e79ba6daf85e05faad641d6aaf3c on September 7, 2026. Normal publication follows a human rebase merge and the shared package gate; the publisher verifies exact stable dependency tags against Composer source and dist commits. Optional repository hardening and external attestations do not block publication. Actual release publication and independent App adoption verification remain separate evidence stages.

## Package CI and release

The reusable `Integration CI` installs the declared stable dependencies, executes the complete package source gate and validates a fresh authoritative archive consumer. `Package gate` also requires the shared release and dependency-identity regressions. The release workflow reruns that same gate on the actual merged commit and publishes the recorded 0.1.0 version. See `docs/package-release-standard.md`; no App integration is included.
