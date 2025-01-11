<?php

use App\Caster\ValueObjectCaster;
use App\Entitys\EntityWithOtherDependency;
use App\Entitys\NotNullEntity;
use App\Entitys\SimpleEntity;
use App\Entitys\TestEntity;
use App\Enum\ActiveStatusEnum;
use App\Factory\DefaultObjectFactory;
use App\UseCase\Calculate;
use PHPUnit\Framework\TestCase;
use Yiisoft\Hydrator\Hydrator;
use Yiisoft\Hydrator\ObjectFactory\ContainerObjectFactory;
use Yiisoft\Hydrator\TypeCaster\CompositeTypeCaster;
use Yiisoft\Hydrator\TypeCaster\EnumTypeCaster;
use Yiisoft\Hydrator\TypeCaster\HydratorTypeCaster;
use Yiisoft\Hydrator\TypeCaster\PhpNativeTypeCaster;
use Yiisoft\Injector\Injector;

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

    public function testHydrateVoEntityWithOtherDependency(): void
    {
        $id = 1;
        $text = 'string';
        $status = 'Cancelled';
        $hydrator = new Hydrator();
        $object = $hydrator->create(EntityWithOtherDependency::class, [
            'useCase' => [
                'value' => Calculate::class
            ],
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

        $this->assertIsInt($object->calc());
    }

    public function testHydrateNotNullable(): void
    {
        $id = 1;
        $text = 'string';
        $status = ActiveStatusEnum::Cancelled->value;
        $hydrator = new Hydrator(
            new CompositeTypeCaster(
                new ValueObjectCaster(),
                new EnumTypeCaster(),
                new PhpNativeTypeCaster(),
                new HydratorTypeCaster(),
            ),
            null,
            new DefaultObjectFactory(
                new ContainerObjectFactory(new Injector())
            )
        );

        $object = $hydrator->create(
            NotNullEntity::class,
            [
                'id' => $id,
                'name' => $text,
                'status' => $status,
            ]
        );

        $this->assertSame($id, $object->getId()->getValue());
        $this->assertSame($text, $object->getName()->getValue());
        $this->assertSame($status, $object->getStatus()->value);
        $this->assertTrue($object->getNoName()->isNull());
        $this->assertTrue($object->getNoStatus()->isUndefined());
    }
}
