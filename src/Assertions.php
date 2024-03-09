<?php

namespace Zrnik\AttributeReflection;

use Attribute;
use ReflectionClass;
use RuntimeException;

class Assertions
{
    /**
     * @param class-string $attributeClassString
     * @return Attribute
     */
    public static function assertIsAttribute(string $attributeClassString): Attribute
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $reflection = new ReflectionClass($attributeClassString);

        foreach ($reflection->getAttributes() as $attribute) {
            if ($attribute->getName() === Attribute::class) {
                /** @var Attribute */
                return $attribute->newInstance(); // It's an attribute, OK!
            }
        }

        throw AttributeReflectionException::notAnAttribute($attributeClassString);
    }

    /**
     * @param class-string $attributeClassString
     * @param string $methodName
     * @return Attribute
     */
    public static function assertIsNotRepeatable(
        string $attributeClassString,
        string $methodName,
    ): Attribute
    {
        $attribute = self::assertIsAttribute($attributeClassString);

        if (!($attribute->flags & Attribute::IS_REPEATABLE)) {
            return $attribute; // Not repeatable, OK!
        }

        throw AttributeReflectionException::mustNotBeRepeatable(
            $attributeClassString,
            $methodName,
            self::createOppositeMethodName($methodName),
        );
    }

    /**
     * @param class-string $attributeClassString
     * @param string $methodName
     * @return Attribute
     */
    public static function assertIsRepeatable(
        string $attributeClassString,
        string $methodName,
    ): Attribute
    {
        $attribute = self::assertIsAttribute($attributeClassString);

        if ($attribute->flags & Attribute::IS_REPEATABLE) {
            return $attribute; // Repeatable, OK!
        }

        throw AttributeReflectionException::mustBeRepeatable(
            $attributeClassString,
            $methodName,
            self::createOppositeMethodName($methodName)
        );
    }

    /**
     * @param class-string $attributeClassString
     * @param int $targetFlag
     * @return Attribute
     */
    public static function assertTarget(string $attributeClassString, int $targetFlag): Attribute
    {
        $attribute = self::assertIsAttribute($attributeClassString);

        if ($attribute->flags & $targetFlag) {
            return $attribute; // Target OK!
        }

        $reflectionClass = new ReflectionClass(Attribute::class);
        foreach ($reflectionClass->getConstants() as $name => $value) {
            if ($targetFlag & $value) {
                throw AttributeReflectionException::invalidTarget($attributeClassString, $name);
            }
        }

        throw AttributeReflectionException::unknownTarget($attributeClassString, $targetFlag);
    }

    public static function createOppositeMethodName(string $methodName): string
    {
        if (str_ends_with($methodName, 'Attribute')) {
            return $methodName . 's';
        }

        if (str_ends_with($methodName, 'Attributes')) {
            return rtrim($methodName, 's');
        }

        throw new RuntimeException(
            sprintf(
                'Library error! Method must end with "Attribute" or "Attributes", got "%s"!',
                $methodName,
            )
        );
    }
}