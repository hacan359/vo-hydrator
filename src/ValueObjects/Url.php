<?php

declare(strict_types=1);

namespace App\ValueObjects;

use Assert\Assert;

final class Url
{
    private ?string $value;

    public function __construct(?string $value = null)
    {
        if (is_string($value)) {
            $value = trim($value);

            if ('' === $value) {
                $value = null;
            }
        }

        $this->value = $value;
    }

    public static function fromParts(?string $baseUrl = null, ?string $path = null, ?string $query = null): Url
    {
        $value = trim($baseUrl ?? '');

        if (null !== $path) {
            $path = ltrim($path, '/');

            $value .= '/' . $path;
        }

        if (null !== $query) {
            if (0 !== strncmp($query, '?', 1)) {
                $value .= '?';
            }

            $value .= $query;
        }

        return new self($value);
    }

    public function isNull(): bool
    {
        return null === $this->value;
    }

    public function getValue(): string
    {
        Assert::that($this->value)
            ->notNull();

        return $this->value;
    }

    public function getNullableValue(): ?string
    {
        return $this->value;
    }
}
