<?php
declare(strict_types=1);
$autoload = getenv('KUMWE_TEST_AUTOLOAD') ?: dirname(__DIR__) . '/vendor/autoload.php';
if (!is_file($autoload)) { throw new RuntimeException('Install declared dependencies or set KUMWE_TEST_AUTOLOAD to an isolated consumer autoloader.'); }
require $autoload;
$assertions = 0;
function check(bool $condition, string $label): void { global $assertions; ++$assertions; if (!$condition) { throw new RuntimeException($label); } }
function rejects(callable $operation, string $exception = InvalidArgumentException::class): void { global $assertions; ++$assertions; try { $operation(); } catch (Throwable $failure) { if ($failure instanceof $exception) { return; } throw new RuntimeException('Unexpected failure: '.$failure::class.': '.$failure->getMessage(), 0, $failure); } throw new RuntimeException('Expected '.$exception); }
/** Test double: observes dependency calls; this is not a canonical encoder implementation. */
final class ObservedEncoder implements \Kumwe\CanonicalJson\CanonicalEncoder {
 public int $calls = 0;
 public ?int $bytes = null;
 public bool $refuse = false;
 public function encode(mixed $value): string { ++$this->calls; if ($this->refuse) { throw new InvalidArgumentException('Injected refusal'); } return $this->bytes === null ? json_encode($value, JSON_THROW_ON_ERROR | JSON_PRESERVE_ZERO_FRACTION) : str_repeat('x', $this->bytes); }
 public function digest(mixed $value): string { return hash('sha256', $this->encode($value)); }
}
