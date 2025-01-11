<?php

declare(strict_types=1);

namespace App\Enum;

interface UndefinedInterface
{
    public function isUndefined(): bool;

    public static function Undefined(): self;
}
