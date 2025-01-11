<?php

declare(strict_types=1);

namespace App\ValueObjects;

use Assert\Assert;

final class DateIntervalRange
{
    private DateInterval $from;
    private DateInterval $to;

    public function __construct(DateInterval $from, DateInterval $to)
    {
        if (!$from->isNull() && !$to->isNull()) {
            Assert::that($to->getSeconds())
                ->greaterOrEqualThan($from->getSeconds());
        }

        $this->from = $from;
        $this->to = $to;
    }

    public function getFrom(): DateInterval
    {
        return $this->from;
    }

    public function getTo(): DateInterval
    {
        return $this->to;
    }

    public function isNull(): bool
    {
        return $this->from->isNull() && $this->to->isNull();
    }
}
