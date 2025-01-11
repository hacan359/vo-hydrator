<?php

declare(strict_types=1);

namespace App\Entitys;

final class SimpleEntity
{
    private ?int $id;
    private ?string $name;


    public function __construct(
        ?int $id = null,
        ?string $name = null,
    ) {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }
}
