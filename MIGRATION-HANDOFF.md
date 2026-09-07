# Runtime extraction handoff

Change set: KUMWE-CS-2026-027. Migration: KUMWE-MIG-2026-027. Non-roadmap: NRM-2026-027.

## Exact source and target

`resources/migration/source-map.json` records all 33 moved public types, their old and new fully qualified names, source repository commit, source file SHA-256 and target path. No App/SDK consumer is modified by this branch. Package types are canonical candidates until independently released and adopted; no aliases or runtime fallback are supplied.

## Intentional adaptation

Namespaces follow the canonical package catalog. JSON-taking constructors and factories accept an explicit `CanonicalEncoder`; immutable transitions retain that same encoder. Declaration validation preserves the SDK no-float, 32-depth, 512-member profile before generic encoding. The generic encoder implementation remains external. Automation's private declaration validator is an internal policy boundary, not an exported second canonical encoder. Contribution and context references point to their canonical dependency namespaces.

## Retained authority

Transactions, transport delivery, dispatch, webhook signing/egress, authorization, extension activation and retention enforcement remain App-owned.

## Evidence and remaining gates

`composer check` validates the Composer manifest, parses runtime PHP, checks token-level architecture boundaries, compares all public methods/constants and ports, and executes package-owned behavior tests. `composer clean-consumer` verifies archive loading of every public type and reruns those behavior tests outside the source checkout. Source provenance is not an assertion that App behavior tests or host infrastructure tests have moved.

This is a source extraction PR, not a release attestation. Publication is blocked pending independently verified immutable dependencies, including CanonicalEncoder in kumwe/canonical-json >=0.1.1, plus this extraction of kumwe/automation. Current development consumers use explicitly identified local source snapshots; they do not establish registry availability, security-audit completeness or host adoption. App wiring must remain unchanged until dependency publication, exact release verification and separately reviewed adoption. Do not merge, tag or publish as part of this work.
