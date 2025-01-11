<?php

declare(strict_types=1);

namespace App\UseCase;

class Calculate
{
    public function randomInt(): int
    {
        return random_int(1, 50);
    }
}
