# integration ownership charter

Change set: KUMWE-CS-2026-027. Migration: KUMWE-MIG-2026-027.
Non-roadmap reference: NRM-2026-027; extraction is an enabling refactor.

## Responsibility

Portable versioned event, consumer, envelope, process, transition, and neutral store contracts under the canonical namespace `Kumwe\Integration`.

## Retained host responsibilities

Database transactions, transport implementations, dispatch workers, webhook security, retention and authorization authority remain outside this package. Production code never imports Kumwe App.

## Delivery boundary

This branch owns Phase 1 package implementation and its behavior, boundary, conformance, public API, archive, and consumer tests. The source closure and exact old-to-new mapping are recorded in the migration handoff. App remains unchanged until separately verified immutable releases permit adoption. Dependencies that have not passed independent release verification are explicit publication blockers.

Package publication and consumer adoption require the reviewed release protocol; this branch does not merge, tag, or publish artifacts. Each portable symbol has one eventual canonical owner. Namespace aliases, copied vendor implementations, and silent runtime fallbacks are prohibited.
