<?php

declare(strict_types=1);

namespace App\Caster;

use App\ValueObjects\Id;
use App\ValueObjects\Text;
use Yiisoft\Hydrator\Result;
use Yiisoft\Hydrator\TypeCaster\TypeCastContext;
use Yiisoft\Hydrator\TypeCaster\TypeCasterInterface;

final class ValueObjectCaster implements TypeCasterInterface
{
    public function cast(mixed $value, TypeCastContext $context): Result
    {
        switch ($context->getReflection()->getType()->getName()) {
            case Id::class:
                $value = $value instanceof Id ? $value : new Id($value);
                break;

            case Text::class:
                $value = $value instanceof Text ? $value : new Text($value);
                break;

            default:
                return Result::fail();
        }

        return Result::success($value);
    }
}
