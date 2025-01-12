<?php

declare(strict_types=1);

namespace App\Entitys;

use App\Enum\ActiveStatusEnum;
use App\ValueObjects\Id;
use App\ValueObjects\Text;

final class NotNullEntity
{
    public function __construct(
        private readonly Id $id,
        private readonly Text $name,
        private readonly Text $noName,
        private readonly ActiveStatusEnum $status,
        private readonly ActiveStatusEnum $noStatus,
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

    public function getNoName(): Text
    {
        return $this->noName;
    }

    public function getStatus(): ActiveStatusEnum
    {
        return $this->status;
    }

    public function getNoStatus(): ActiveStatusEnum
    {
        return $this->noStatus;
    }
}
