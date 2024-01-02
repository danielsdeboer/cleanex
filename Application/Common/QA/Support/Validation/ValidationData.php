<?php

namespace Application\Common\QA\Support\Validation;

use Illuminate\Support\Str;

/**
 * @phpstan-type Value string|int|float|bool|null|array<string|int, mixed>
 */
class ValidationData
{
	public readonly string $name;

	/** @param Value $value */
	public function __construct(
		public readonly string $field,
		public readonly string $error,
		public readonly string|int|float|bool|array|null $value,
		string|null $name = null,
	) {
		$this->name = $name
			?: sprintf('%s %s', $this->field, $this->error);
	}

	public static function required(string $field): self
	{
		return new self($field, 'required', null);
	}

	public static function string(string $field): self
	{
		return new self($field, 'string', 1.234);
	}

	public static function maxLength(string $field, int $length): self
	{
		return new self($field, 'greater than', Str::random($length + 1));
	}

	/** @return non-empty-array<string, Value> */
	public function getRequestFragment(): array
	{
		return [$this->field => $this->value];
	}

	/** @return non-empty-array<string, string> */
	public function getErrorFragment(): array
	{
		return [$this->field => $this->error];
	}
}
