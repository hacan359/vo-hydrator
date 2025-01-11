<?php

declare(strict_types=1);

namespace App\Entitys;

use App\Enum\ActiveStatusEnum;
use App\ValueObjects\Id;
use App\ValueObjects\Text;

final class TestEntity
{
    private Id $id;
    private Text $name;
    private ActiveStatusEnum $status;

    public function __construct(
        ?Id $id = null,
        ?Text $name = null,
        ?ActiveStatusEnum $status = null,

    ) {
        $this->id = $id ?? new Id();
        $this->name = $name ?? new Text();
        $this->status = $status ?? ActiveStatusEnum::Active;
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
}
