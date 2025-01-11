<?php

use App\Entitys\SimpleEntity;
use App\Entitys\TestEntity;
use App\Enum\ActiveStatusEnum;
use PHPUnit\Framework\TestCase;
use Yiisoft\Hydrator\Hydrator;

class HydrateTest extends TestCase
{
    public function testBaseHydrate(): void
    {
        $id = 1;
        $text = 'string';
        $hydrator = new Hydrator();
        $object = $hydrator->create(SimpleEntity::class, [
            'id' => $id,
            'name' => $text
        ]);

        $this->assertSame($id, $object->getId());
        $this->assertSame($text, $object->getName());
    }

    public function testHydrateVo(): void
    {
        $id = 1;
        $text = 'string';
        $status = 'Cancelled';
        $hydrator = new Hydrator();
        $object = $hydrator->create(TestEntity::class, [
            'id' => [
                'value' => $id
            ],
            'name' => [
                'value' => $text
            ],
            'status' => ActiveStatusEnum::Cancelled //для енам работает вот так
        ]);

        $this->assertSame($id, $object->getId()->getValue());
        $this->assertSame($text, $object->getName()->getValue());
        $this->assertSame($status, $object->getStatus()->name);
    }
}
