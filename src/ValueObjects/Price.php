<?php

declare(strict_types=1);

namespace App\ValueObjects;

use Assert\Assert;

final class Price
{
    /** @var null|int */
    private ?int $value;
    private ?int $currencyId;
    private ?string $currencyName;

    /**
     * @param int|string|null $value
     * @param int|null $currencyId
     * @param string|null $currencyName
     */
    public function __construct($value = null, ?int $currencyId = null, ?string $currencyName = null)
    {
        Assert::that($value)->nullOr()->numeric();

        $this->value = null === $value ? $value : (int)$value;
        $this->currencyId = $currencyId;
        $this->currencyName = $currencyName;
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
     * @return int|null
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

    /**
     * @param $value
     *
     * @return bool
     */
    public function isEquals($value): bool
    {
        return $this->value === self::tryValue($value);
    }

    /**
     * @param $value
     *
     * @return bool
     */
    public function isGreaterThan($value): bool
    {
        return $this->value > self::tryValue($value);
    }

    /**
     * @param $value
     *
     * @return bool
     */
    public function isLessThan($value): bool
    {
        return $this->value < self::tryValue($value);
    }

    /**
     * Proxy for [[add()]]
     *
     * @param $value
     *
     * @return $this
     */
    public function sum($value): self
    {
        return $this->add($value);
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function add($value): self
    {
        $this->value += self::tryValue($value);

        return $this;
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function sub($value): self
    {
        $immutable = clone $this;
        $immutable->value -= self::tryValue($value);

        return $immutable;
    }

    /**
     * @param $value
     *
     * @return int
     */
    private static function tryValue($value): int
    {
        Assert::that($value)
            ->notNull();

        $price = $value;
        if ($value instanceof Price) {
            $price = $value->getValue();
        }

        Assert::that($price)
            ->integer()
            ->greaterOrEqualThan(0);

        return $price;
    }

    /**
     * @return int|null
     */
    public function getCurrencyId(): ?int
    {
        return $this->currencyId;
    }

    /**
     * @return string|null
     */
    public function getCurrencyName(): ?string
    {
        return $this->currencyName;
    }
}
