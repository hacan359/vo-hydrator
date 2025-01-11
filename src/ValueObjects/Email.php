<?php

declare(strict_types=1);

namespace App\ValueObjects;

use Assert\Assert;

final class Email
{
    private ?string $value;

    public function __construct(?string $value = null)
    {
        if (is_string($value)) {
            $value = trim($value);
        }

        $this->value = $value;
    }

    public function getValue(): string
    {
        Assert::that($this->value)
            ->email();

        return $this->value;
    }

    public function getNullableValue(): ?string
    {
        return $this->value;
    }

    public function isEmpty(): bool
    {
        return empty($this->value);
    }

    public function isNull(): bool
    {
        return $this->value === null;
    }

    public function isValid(): bool
    {
        return filter_var($this->value, FILTER_VALIDATE_EMAIL) !== false;
    }
}
