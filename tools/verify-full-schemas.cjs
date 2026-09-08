const fs = require('node:fs');
const path = require('node:path');
const Ajv = require('./governance/node_modules/ajv/dist/2020').default;
const YAML = require('./governance/node_modules/yaml');
const root = path.resolve(__dirname, '..');
const ajv = new Ajv({strict: false, allErrors: true});
const names = ['public-api', 'capabilities', 'service-map', 'handoff'];
const validators = {};
const documents = {};

function frontMatter(text) {
    const match = /^---\r?\n([\s\S]*?)\r?\n---(?:\r?\n|$)/.exec(text);
    if (!match) throw new Error('A complete YAML front matter block is required.');
    return YAML.parse(match[1], {uniqueKeys: true});
}

for (const name of names) {
    const schema = name === 'handoff' ? 'migration-handoff.v2' : `package-${name}.v1`;
    validators[name] = ajv.compile(JSON.parse(fs.readFileSync(path.join(__dirname, 'schemas', `${schema}.schema.json`))));
    documents[name] = name === 'handoff'
        ? frontMatter(fs.readFileSync(path.join(root, 'MIGRATION-HANDOFF.md'), 'utf8'))
        : JSON.parse(fs.readFileSync(path.join(root, 'resources', name, 'v1.json')));
    if (!validators[name](documents[name])) {
        throw new Error(`${name}: ${ajv.errorsText(validators[name].errors, {separator: '; '})}`);
    }
}

let refusals = 0;
function mustRefuse(label, fn) {
    try { fn(); } catch { refusals++; return; }
    throw new Error(`Schema regression was admitted: ${label}`);
}
function invalid(name, change) {
    const copy = structuredClone(documents[name]);
    change(copy);
    if (!validators[name](copy)) throw new Error('Expected refusal');
}
mustRefuse('unterminated YAML quote', () => frontMatter('---\nblockers:\n  - "unterminated\n---\n'));
mustRefuse('missing YAML closing delimiter', () => frontMatter('---\nschema: missing-end\n'));
mustRefuse('duplicate YAML keys', () => frontMatter('---\nschema: one\nschema: two\n---\n'));
mustRefuse('invalid native requirement array', () => invalid('capabilities', x => { x.native_requirements = []; }));
mustRefuse('missing canonical API owner', () => invalid('public-api', x => { delete x.package; }));
mustRefuse('unknown service-map field', () => invalid('service-map', x => { x.unknown = true; }));
mustRefuse('abbreviated source commit', () => invalid('handoff', x => { x.source.app.baseline_commit = 'abcdef'; }));
mustRefuse('invalid handoff replacement value', () => invalid('handoff', x => { x.next_task.namespace_or_api_replacements = [{}]; }));
console.log(`All four complete authoritative schemas and ${refusals} refusal regressions passed.`);
