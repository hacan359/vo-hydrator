<?php

declare(strict_types=1);

namespace App\ValueObjects;

use Assert\Assert;

final class Id
{

    /**
     * @var null|int
     */
    private ?int $value;

    /**
     * @param int|string|null $value
     */
    public function __construct($value = null)
    {
        Assert::that($value)
            ->nullOr()
            ->numeric()
            ->greaterThan(0);

        $this->value = null === $value ? null : (int)$value;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        Assert::that($this->value)
            ->notNull();

        return $this->value;
    }

    /**
     * @return null|int
     */
    public function getNullableValue(): ?int
    {
        return $this->value;
    }

    /**
     * @return bool
     */
    public function isNull(): bool
    {
        return $this->value === null;
    }
}
