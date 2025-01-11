<?php

declare(strict_types=1);

namespace App\Enum;

enum ActiveStatusEnum: int
{
    case Active = 1;
    case Cancelled = 2;
}
