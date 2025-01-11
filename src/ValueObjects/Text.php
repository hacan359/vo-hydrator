<?php

declare(strict_types=1);

namespace App\ValueObjects;

use Assert\Assert;

final class Text
{

    /** @var null|string */
    private ?string $value;

    /**
     * @param null|string $value
     */
    public function __construct(?string $value = null)
    {
        $this->value = $value === null
            ? null
            : trim($value);
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        Assert::that($this->value)
            ->notNull();

        return $this->value;
    }

    /**
     * @return null|string
     */
    public function getNullableValue(): ?string
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

    public function isEmpty(): bool
    {
        return null === $this->value || '' === $this->value;
    }
}
