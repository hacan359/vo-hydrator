<?php

declare(strict_types=1);

namespace App\ValueObjects;

use Assert\Assert;

final class PriceRange
{
    private Price $from;
    private Price $to;

    public function __construct(Price $from, Price $to)
    {
        if (!$from->isNull() && !$to->isNull()) {
            Assert::that($to->getValue())
                ->greaterOrEqualThan($from->getValue());

            if (!$from->getCurrencyName() && !$to->getCurrencyName()) {
                Assert::that($to->getCurrencyName())
                    ->eq($from->getCurrencyName());
            }
        }

        $this->from = $from;
        $this->to = $to;
    }

    public function isNull(): bool
    {
        return $this->from->isNull() && $this->to->isNull();
    }

    public function getFrom(): Price
    {
        return $this->from;
    }

    public function getTo(): Price
    {
        return $this->to;
    }
}
