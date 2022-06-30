<?php

namespace App;

use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\FunctionVariant;
use PHPStan\Reflection\MethodReflection;
use PHPStan\TrinaryLogic;
use PHPStan\Type\ClosureTypeFactory;
use PHPStan\Type\Generic\TemplateTypeMap;

class FooExtension implements \PHPStan\Reflection\MethodsClassReflectionExtension
{
    public function __construct(private ClosureTypeFactory $closureTypeFactory)
    {
    }

    public function hasMethod(ClassReflection $classReflection, string $methodName): bool
    {
        return true;
    }

    public function getMethod(
        ClassReflection $classReflection,
        string $methodName
    ): \PHPStan\Reflection\MethodReflection {
        return new class($classReflection, $this->closureTypeFactory) implements MethodReflection {

            public function __construct(private ClassReflection $classReflection, private ClosureTypeFactory $closureTypeFactory)
            {
            }

            public function getDeclaringClass(): \PHPStan\Reflection\ClassReflection
            {
                return $this->classReflection;
            }

            public function isStatic(): bool
            {
                return false;
            }

            public function isPrivate(): bool
            {
                return false;
            }

            public function isPublic(): bool
            {
                return true;
            }

            public function getDocComment(): ?string
            {
                return null;
            }

            public function getName(): string
            {
                return 'foo';
            }

            public function getPrototype(): \PHPStan\Reflection\ClassMemberReflection
            {
                return $this;
            }

            public function getVariants(): array
            {
                // In Larastan closure comes from somewhere else. Here it's just a method call for demo purposes.
                $closureType = $this->closureTypeFactory->fromClosureObject((new Foo())->doFoo());

                return [
                    new FunctionVariant(TemplateTypeMap::createEmpty(), null, $closureType->getParameters(), $closureType->isVariadic(), $closureType->getReturnType()),
                ];
            }

            public function isDeprecated(): \PHPStan\TrinaryLogic
            {
                return TrinaryLogic::createNo();
            }

            public function getDeprecatedDescription(): ?string
            {
                return null;
            }

            public function isFinal(): \PHPStan\TrinaryLogic
            {
                return TrinaryLogic::createNo();
            }

            public function isInternal(): \PHPStan\TrinaryLogic
            {
                return TrinaryLogic::createNo();
            }

            public function getThrowType(): ?\PHPStan\Type\Type
            {
                return null;
            }

            public function hasSideEffects(): \PHPStan\TrinaryLogic
            {
                return TrinaryLogic::createNo();
            }
        };
    }
}