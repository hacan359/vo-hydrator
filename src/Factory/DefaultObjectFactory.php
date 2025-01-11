<?php

declare(strict_types=1);

namespace App\Factory;

use App\Enum\UndefinedInterface;
use ReflectionClass;
use ReflectionMethod;
use Yiisoft\Hydrator\Exception\AbstractClassException;
use Yiisoft\Hydrator\Exception\NonPublicConstructorException;
use Yiisoft\Hydrator\Exception\WrongConstructorArgumentsCountException;
use Yiisoft\Hydrator\ObjectFactory\ContainerObjectFactory;
use Yiisoft\Hydrator\ObjectFactory\ObjectFactoryInterface;

final class DefaultObjectFactory implements ObjectFactoryInterface
{
    public function __construct(
        private readonly ContainerObjectFactory $containerObjectFactory
    ) {
    }

    public function create(ReflectionClass $reflectionClass, array $constructorArguments): object
    {
        if ($reflectionClass->isAbstract()) {
            throw new AbstractClassException($reflectionClass);
        }

        $constructor = $reflectionClass->getConstructor();

        if ($constructor !== null) {
            if (!$constructor->isPublic()) {
                throw new NonPublicConstructorException($constructor);
            }

            $constructorArguments = $this->initDefaultValues($constructorArguments, $constructor);

            $countArguments = count($constructorArguments);
            if ($constructor->getNumberOfRequiredParameters() > $countArguments) {
                throw new WrongConstructorArgumentsCountException($constructor, $countArguments);
            }
        }


        return $reflectionClass->newInstance(...$constructorArguments);
    }

    private function initDefaultValues(array $constructorArguments, ReflectionMethod $constructor): array
    {
        foreach ($constructor->getParameters() as $parameter) {
            $type = $parameter->getType();
            $className = $type?->getName();
            $constructorArguments[$parameter->name] ??= match (true) {
                $type?->allowsNull() => null,
                is_subclass_of($className, UndefinedInterface::class) => $className::Undefined(),
                $type !== null => $this->containerObjectFactory->create(new ReflectionClass($className), []),
                default => null,
            };
        }

        return $constructorArguments;
    }
}
