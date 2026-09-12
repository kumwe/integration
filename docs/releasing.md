# Release and dependency policy

CHANGELOG.md selects the next SemVer release. A maintainer merges the reviewed PR; the default-branch release workflow reruns the complete package gate at the actual merged SHA, then creates or verifies its stable tag and GitHub release. Existing tags and releases are never replaced. No source branch is a release coordinate.

All pre-1.0 Kumwe dependencies use exact observed stable versions. A dependency update is an explicit reviewed change with Composer resolution, behavior/conformance and archive-consumer checks. Do not use latest, dev-main or broad ranges to hide incompatible release tuples. Third-party dependencies retain their documented compatible constraints.

Publication is distinct from release verification. Before App adoption, verify source/tag/archive identity, the clean no-dev consumer, API/capability/service manifests and independent RELEASE-ATTESTATION.yaml. This package never asserts App integration or roadmap acceptance from package tests. Follow docs/package-release-standard.md for immutable release transition and recovery rules.

The direct Kumwe dependency tuple is Automation 0.2.2, Canonical JSON 0.1.1, Contribution 0.1.1 and
Access Context 0.1.2. The [release contract record](release-record.md) preserves consumer requirements.
Independent artifact verification and affected Core tests govern adoption of a successor release.
