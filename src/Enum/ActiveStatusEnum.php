<?php

declare(strict_types=1);

namespace App\Enum;

enum ActiveStatusEnum: int implements UndefinedInterface
{
    case Undefined = 0;
    case Active = 1;
    case Cancelled = 2;

    public function isUndefined(): bool
    {
        return $this === self::Undefined;
    }

    public static function Undefined(): self
    {
        return self::Undefined;
    }
}
