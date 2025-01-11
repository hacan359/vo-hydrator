<?php

declare(strict_types=1);

namespace App\ValueObjects;

use Assert\Assert;

final class Logic
{
    private ?bool $value;

    /**
     * @param bool|string|int|null $value
     */
    public function __construct($value = null)
    {
        if (is_string($value)) {
            $value = (int)$value;
        }

        if (is_numeric($value)) {
            Assert::that($value)
                ->between(0, 1);
        }

        $this->value = null === $value ? $value : (bool)$value;
    }

    public function getValue(): bool
    {
        Assert::that($this->value)
            ->notNull();

        return $this->value;
    }

    public function getNullableValue(): ?bool
    {
        return $this->value;
    }

    public function isNull(): bool
    {
        return null === $this->value;
    }
}
