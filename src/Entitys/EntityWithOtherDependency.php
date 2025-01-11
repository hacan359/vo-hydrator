<?php

declare(strict_types=1);

namespace App\Entitys;

use App\Enum\ActiveStatusEnum;
use App\UseCase\Calculate;
use App\ValueObjects\Id;
use App\ValueObjects\Text;

final class EntityWithOtherDependency
{
    public function __construct(
        private Calculate $useCase,
        private readonly ?Id $id,
        private readonly ?Text $name,
        private readonly ?ActiveStatusEnum $status,
    ) {
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getName(): Text
    {
        return $this->name;
    }

    public function getStatus(): ActiveStatusEnum
    {
        return $this->status;
    }

    public function calc(): int
    {
        return $this->useCase->randomInt();
    }
}
