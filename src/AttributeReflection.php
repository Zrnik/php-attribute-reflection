<?php /** @noinspection DuplicatedCode */

namespace Zrnik\AttributeReflection;

use Attribute;
use ReflectionClass;
use ReflectionException;
use ReflectionFunction;

class AttributeReflection
{
    /**
     * @template T of object
     * @param class-string<T> $attributeClassString
     * @param object|class-string $objectOrClassString
     * @return T
     * @noinspection PhpDocSignatureInspection
     */
    public static function getClassAttribute(
        string        $attributeClassString,
        object|string $objectOrClassString,
    ): object
    {
        Assertions::assertIsAttribute($attributeClassString);
        Assertions::assertTarget($attributeClassString, Attribute::TARGET_CLASS);
        Assertions::assertIsNotRepeatable(
            $attributeClassString,
            __FUNCTION__,
        );

        $objectClassString = AttributeReflectionHelper::getClassString($objectOrClassString);

        try {
            $classReflection = new ReflectionClass($objectClassString);
            return AttributeReflectionHelper::findSingleAttribute(
                $classReflection->getAttributes(),
                $attributeClassString
            )
                ?? throw AttributeReflectionException::attributeNotFoundOnTarget(
                    $attributeClassString,
                    'class',
                    $objectClassString,
                );
        } catch (ReflectionException $e) {
            throw AttributeReflectionException::fromReflectionException($e);
        }
    }

    /**
     * @template T of object
     * @param class-string<T> $attributeClassString
     * @param object|class-string $objectOrClassString
     * @return T[]
     */
    public static function getClassAttributes(
        string        $attributeClassString,
        object|string $objectOrClassString,
    ): array
    {
        Assertions::assertIsAttribute($attributeClassString);
        Assertions::assertTarget($attributeClassString, Attribute::TARGET_CLASS);
        Assertions::assertIsRepeatable(
            $attributeClassString,
            __FUNCTION__,
        );

        $objectClassString = AttributeReflectionHelper::getClassString($objectOrClassString);

        try {
            $classReflection = new ReflectionClass($objectClassString);

            /** @var T[] */
            return AttributeReflectionHelper::findMultipleAttributes(
                $classReflection->getAttributes(),
                $attributeClassString
            );

        } catch (ReflectionException $e) {
            throw AttributeReflectionException::fromReflectionException($e);
        }
    }

    /**
     * @template T of object
     * @param class-string<T> $attributeClassString
     * @param object|class-string $objectOrClassString
     * @return T
     * @noinspection PhpDocSignatureInspection
     */
    public static function getClassConstantAttribute(
        string        $attributeClassString,
        object|string $objectOrClassString,
        string        $constantName,
    )
    {
        Assertions::assertIsAttribute($attributeClassString);
        Assertions::assertTarget($attributeClassString, Attribute::TARGET_CLASS_CONSTANT);
        Assertions::assertIsNotRepeatable(
            $attributeClassString,
            __FUNCTION__,
        );

        $objectClassString = AttributeReflectionHelper::getClassString($objectOrClassString);

        try {
            $classReflection = new ReflectionClass($objectClassString);
            foreach ($classReflection->getReflectionConstants() as $constant) {
                if ($constant->getName() === $constantName) {
                    return AttributeReflectionHelper::findSingleAttribute(
                        $constant->getAttributes(),
                        $attributeClassString
                    )
                        ?? throw AttributeReflectionException::attributeNotFoundOnTargetWithSubTarget(
                            $attributeClassString,
                            'class',
                            'constant',
                            $objectClassString,
                            $constantName,
                        );
                }
            }

            throw AttributeReflectionException::subTargetNotFoundOnTarget(
                'class',
                'constant',
                $objectClassString,
                $constantName,
            );
        } catch (ReflectionException $e) {
            throw AttributeReflectionException::fromReflectionException($e);
        }
    }

    /**
     * @template T of object
     * @param class-string<T> $attributeClassString
     * @param object|class-string $objectOrClassString
     * @return T[]
     */
    public static function getClassConstantAttributes(
        string        $attributeClassString,
        object|string $objectOrClassString,
        string        $constantName,
    ): array
    {
        Assertions::assertIsAttribute($attributeClassString);
        Assertions::assertTarget($attributeClassString, Attribute::TARGET_CLASS_CONSTANT);
        Assertions::assertIsRepeatable(
            $attributeClassString,
            __FUNCTION__,
        );

        $objectClassString = AttributeReflectionHelper::getClassString($objectOrClassString);

        try {
            $classReflection = new ReflectionClass($objectClassString);

            foreach ($classReflection->getReflectionConstants() as $constant) {
                if ($constant->getName() === $constantName) {
                    /** @var T[] */
                    return AttributeReflectionHelper::findMultipleAttributes(
                        $constant->getAttributes(),
                        $attributeClassString
                    );
                }
            }

            throw AttributeReflectionException::subTargetNotFoundOnTarget(
                'class',
                'constant',
                $objectClassString,
                $constantName
            );
        } catch (ReflectionException $e) {
            throw AttributeReflectionException::fromReflectionException($e);
        }
    }

    /**
     * @template T of object
     * @param class-string<T> $attributeClassString
     * @param object|class-string $objectOrClassString
     * @return T
     * @noinspection PhpDocSignatureInspection
     */
    public static function getPropertyAttribute(
        string        $attributeClassString,
        object|string $objectOrClassString,
        string        $propertyName,
    )
    {
        Assertions::assertIsAttribute($attributeClassString);
        Assertions::assertTarget($attributeClassString, Attribute::TARGET_PROPERTY);
        Assertions::assertIsNotRepeatable(
            $attributeClassString,
            __FUNCTION__,
        );

        $objectClassString = AttributeReflectionHelper::getClassString($objectOrClassString);

        try {
            $classReflection = new ReflectionClass($objectClassString);
            foreach ($classReflection->getProperties() as $reflectionProperty) {
                if ($reflectionProperty->getName() === $propertyName) {
                    return AttributeReflectionHelper::findSingleAttribute(
                        $reflectionProperty->getAttributes(),
                        $attributeClassString
                    )
                        ?? throw AttributeReflectionException::attributeNotFoundOnTargetWithSubTarget(
                            $attributeClassString,
                            'class',
                            'property',
                            $objectClassString,
                            $propertyName,
                        );
                }
            }

            throw AttributeReflectionException::subTargetNotFoundOnTarget(
                'class',
                'property',
                $objectClassString,
                $propertyName,
            );
        } catch (ReflectionException $e) {
            throw AttributeReflectionException::fromReflectionException($e);
        }
    }

    /**
     * @template T of object
     * @param class-string<T> $attributeClassString
     * @param object|class-string $objectOrClassString
     * @return T[]
     */
    public static function getPropertyAttributes(
        string        $attributeClassString,
        object|string $objectOrClassString,
        string        $propertyName,
    ): array
    {
        Assertions::assertIsAttribute($attributeClassString);
        Assertions::assertTarget($attributeClassString, Attribute::TARGET_PROPERTY);
        Assertions::assertIsRepeatable(
            $attributeClassString,
            __FUNCTION__,
        );

        $objectClassString = AttributeReflectionHelper::getClassString($objectOrClassString);

        try {
            $classReflection = new ReflectionClass($objectClassString);

            foreach ($classReflection->getProperties() as $reflectionProperty) {
                if ($reflectionProperty->getName() === $propertyName) {
                    /** @var T[] */
                    return AttributeReflectionHelper::findMultipleAttributes(
                        $reflectionProperty->getAttributes(),
                        $attributeClassString
                    );
                }
            }

            throw AttributeReflectionException::subTargetNotFoundOnTarget(
                'class',
                'property',
                $objectClassString,
                $propertyName,
            );
        } catch (ReflectionException $e) {
            throw AttributeReflectionException::fromReflectionException($e);
        }
    }

    /**
     * @template T of object
     * @param class-string<T> $attributeClassString
     * @param object|class-string $objectOrClassString
     * @return T
     * @noinspection PhpDocSignatureInspection
     */
    public static function getMethodAttribute(
        string        $attributeClassString,
        object|string $objectOrClassString,
        string        $methodName,
    ): object
    {
        Assertions::assertIsAttribute($attributeClassString);
        Assertions::assertTarget($attributeClassString, Attribute::TARGET_METHOD);
        Assertions::assertIsNotRepeatable(
            $attributeClassString,
            __FUNCTION__,
        );

        $objectClassString = AttributeReflectionHelper::getClassString($objectOrClassString);

        try {
            $classReflection = new ReflectionClass($objectClassString);
            foreach ($classReflection->getMethods() as $reflectionMethod) {
                if ($reflectionMethod->getName() === $methodName) {

                    return AttributeReflectionHelper::findSingleAttribute(
                        $reflectionMethod->getAttributes(),
                        $attributeClassString
                    )
                        ?? throw AttributeReflectionException::attributeNotFoundOnTargetWithSubTarget(
                            $attributeClassString,
                            'class',
                            'method',
                            $objectClassString,
                            $methodName,
                        );
                }
            }

            throw AttributeReflectionException::subTargetNotFoundOnTarget(
                'class',
                'method',
                $objectClassString,
                $methodName
            );
        } catch (ReflectionException $e) {
            throw AttributeReflectionException::fromReflectionException($e);
        }
    }

    /**
     * @template T of object
     * @param class-string<T> $attributeClassString
     * @param object|class-string $objectOrClassString
     * @return T[]
     */
    public static function getMethodAttributes(
        string        $attributeClassString,
        object|string $objectOrClassString,
        string        $methodName,
    ): array
    {
        Assertions::assertIsAttribute($attributeClassString);
        Assertions::assertTarget($attributeClassString, Attribute::TARGET_METHOD);
        Assertions::assertIsRepeatable(
            $attributeClassString,
            __FUNCTION__,
        );

        $objectClassString = AttributeReflectionHelper::getClassString($objectOrClassString);

        try {
            $classReflection = new ReflectionClass($objectClassString);

            foreach ($classReflection->getMethods() as $reflectionMethod) {
                if ($reflectionMethod->getName() === $methodName) {
                    /** @var T[] */
                    return AttributeReflectionHelper::findMultipleAttributes(
                        $reflectionMethod->getAttributes(),
                        $attributeClassString
                    );
                }
            }

            throw AttributeReflectionException::targetNotFound(
                'method',
                $methodName
            );
        } catch (ReflectionException $e) {
            throw AttributeReflectionException::fromReflectionException($e);
        }
    }

    /**
     * @template T of object
     * @param class-string<T> $attributeClassString
     * @param object|class-string $objectOrClassString
     * @return T
     * @noinspection PhpDocSignatureInspection
     */
    public static function getMethodParameterAttribute(
        string        $attributeClassString,
        object|string $objectOrClassString,
        string        $methodName,
        string        $parameterName,
    ): object
    {
        Assertions::assertIsAttribute($attributeClassString);
        Assertions::assertTarget($attributeClassString, Attribute::TARGET_PARAMETER);
        Assertions::assertIsNotRepeatable(
            $attributeClassString,
            __FUNCTION__,
        );

        $objectClassString = AttributeReflectionHelper::getClassString($objectOrClassString);

        try {
            $classReflection = new ReflectionClass($objectClassString);
            foreach ($classReflection->getMethods() as $reflectionMethod) {
                if ($reflectionMethod->getName() === $methodName) {
                    foreach ($reflectionMethod->getParameters() as $reflectionParameter) {
                        if ($reflectionParameter->getName() === $parameterName) {
                            return AttributeReflectionHelper::findSingleAttribute(
                                $reflectionParameter->getAttributes(),
                                $attributeClassString
                            )
                                ?? throw AttributeReflectionException::attributeNotFoundOnTargetWithSubTarget(
                                    $attributeClassString,
                                    'method',
                                    'parameter',
                                    $methodName,
                                    $parameterName,
                                );
                        }
                    }

                    throw AttributeReflectionException::targetWithSubTargetNotFound(
                        'method',
                        'parameter',
                        $methodName,
                        $parameterName,
                    );
                }
            }

            throw AttributeReflectionException::targetNotFound(
                'method',
                $methodName
            );
        } catch (ReflectionException $e) {
            throw AttributeReflectionException::fromReflectionException($e);
        }
    }

    /**
     * @template T of object
     * @param class-string<T> $attributeClassString
     * @param object|class-string $objectOrClassString
     * @return T[]
     */
    public static function getMethodParameterAttributes(
        string        $attributeClassString,
        object|string $objectOrClassString,
        string        $methodName,
        string        $parameterName,
    ): array
    {
        Assertions::assertIsAttribute($attributeClassString);
        Assertions::assertTarget($attributeClassString, Attribute::TARGET_PARAMETER);
        Assertions::assertIsRepeatable(
            $attributeClassString,
            __FUNCTION__,
        );

        $objectClassString = AttributeReflectionHelper::getClassString($objectOrClassString);

        try {
            $classReflection = new ReflectionClass($objectClassString);

            foreach ($classReflection->getMethods() as $reflectionMethod) {
                if ($reflectionMethod->getName() === $methodName) {
                    foreach ($reflectionMethod->getParameters() as $reflectionParameter) {
                        if ($reflectionParameter->getName() === $parameterName) {
                            /** @var T[] */
                            return AttributeReflectionHelper::findMultipleAttributes(
                                $reflectionParameter->getAttributes(),
                                $attributeClassString
                            );
                        }
                    }

                    throw AttributeReflectionException::subTargetNotFoundOnTarget(
                        'parameter',
                        'method',
                        $parameterName,
                        $methodName,
                    );
                }
            }

            throw AttributeReflectionException::subTargetNotFoundOnTarget(
                'method',
                'class',
                $methodName,
                $objectClassString,
            );
        } catch (ReflectionException $e) {
            throw AttributeReflectionException::fromReflectionException($e);
        }
    }

    /**
     * @template T of object
     * @param class-string<T> $attributeClassString
     * @return T
     * @noinspection PhpDocSignatureInspection
     */
    public static function getFunctionAttribute(
        string $attributeClassString,
        string $functionName,
    ): object
    {
        Assertions::assertIsAttribute($attributeClassString);
        Assertions::assertTarget($attributeClassString, Attribute::TARGET_FUNCTION);
        Assertions::assertIsNotRepeatable(
            $attributeClassString,
            __FUNCTION__,
        );

        try {
            $classReflection = new ReflectionFunction($functionName);
            return AttributeReflectionHelper::findSingleAttribute(
                $classReflection->getAttributes(),
                $attributeClassString
            )
                ?? throw AttributeReflectionException::attributeNotFoundOnTarget(
                    $attributeClassString,
                    'function',
                    $functionName,
                );
        } catch (ReflectionException $e) {
            throw AttributeReflectionException::fromReflectionException($e);
        }
    }

    /**
     * @template T of object
     * @param class-string<T> $attributeClassString
     * @return T[]
     */
    public static function getFunctionAttributes(
        string $attributeClassString,
        string $functionName,
    ): array
    {
        Assertions::assertIsAttribute($attributeClassString);
        Assertions::assertTarget($attributeClassString, Attribute::TARGET_FUNCTION);
        Assertions::assertIsRepeatable(
            $attributeClassString,
            __FUNCTION__,
        );

        try {
            $reflectionFunction = new ReflectionFunction($functionName);

            /** @var T[] */
            return AttributeReflectionHelper::findMultipleAttributes(
                $reflectionFunction->getAttributes(),
                $attributeClassString
            );

        } catch (ReflectionException $e) {
            throw AttributeReflectionException::fromReflectionException($e);
        }
    }

    /**
     * @template T of object
     * @param class-string<T> $attributeClassString
     * @return T
     * @noinspection PhpDocSignatureInspection
     */
    public static function getFunctionParameterAttribute(
        string $attributeClassString,
        string $functionName,
        string $parameterName,
    ): object
    {
        Assertions::assertIsAttribute($attributeClassString);
        Assertions::assertTarget($attributeClassString, Attribute::TARGET_PARAMETER);
        Assertions::assertIsNotRepeatable(
            $attributeClassString,
            __FUNCTION__,
        );

        try {
            $classReflection = new ReflectionFunction($functionName);

            foreach ($classReflection->getParameters() as $reflectionParameter) {
                if ($reflectionParameter->getName() === $parameterName) {
                    return AttributeReflectionHelper::findSingleAttribute(
                        $reflectionParameter->getAttributes(),
                        $attributeClassString
                    )
                        ?? throw AttributeReflectionException::attributeNotFoundOnTargetWithSubTarget(
                            $attributeClassString,
                            'function',
                            'parameter',
                            $functionName,
                            $parameterName,
                        );
                }
            }

            throw AttributeReflectionException::targetNotFound(
                'function',
                $functionName,
            );
        } catch (ReflectionException $e) {
            throw AttributeReflectionException::fromReflectionException($e);
        }
    }

    /**
     * @template T of object
     * @param class-string<T> $attributeClassString
     * @return T[]
     */
    public static function getFunctionParameterAttributes(
        string $attributeClassString,
        string $functionName,
        string $parameterName,
    ): array
    {
        Assertions::assertIsAttribute($attributeClassString);
        Assertions::assertTarget($attributeClassString, Attribute::TARGET_PARAMETER);
        Assertions::assertIsRepeatable(
            $attributeClassString,
            __FUNCTION__,
        );

        try {
            $reflectionFunction = new ReflectionFunction($functionName);

            foreach ($reflectionFunction->getParameters() as $reflectionParameter) {
                if ($reflectionParameter->getName() === $parameterName) {
                    /** @var T[] */
                    return AttributeReflectionHelper::findMultipleAttributes(
                        $reflectionParameter->getAttributes(),
                        $attributeClassString
                    );
                }
            }

            throw AttributeReflectionException::targetWithSubTargetNotFound(
                'function',
                'parameter',
                $functionName,
                $parameterName,
            );
        } catch (ReflectionException $e) {
            throw AttributeReflectionException::fromReflectionException($e);
        }
    }
}
