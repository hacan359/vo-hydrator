<?php

declare(strict_types=1);

namespace App\ValueObjects;

use Assert\Assert;

final class DatePicker
{
    private Date $from;
    private Date $to;

    public function __construct(Date $from, Date $to)
    {
        if (!$from->isNull() && !$to->isNull()) {
            Assert::that($to->getValue()->getTimestamp())
                ->greaterOrEqualThan($from->getValue()->getTimestamp());
        }

        $this->from = $from;
        $this->to = $to;
    }

    public function getFrom(): Date
    {
        return $this->from;
    }

    public function getTo(): Date
    {
        return $this->to;
    }

    public function isNull(): bool
    {
        return $this->from->isNull() && $this->to->isNull();
    }
}
