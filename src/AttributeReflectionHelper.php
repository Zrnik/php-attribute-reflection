<?php

namespace Zrnik\AttributeReflection;

use ReflectionAttribute;

class AttributeReflectionHelper
{
    /**
     * @template T
     * @param object|class-string<T> $objectOrClassString
     * @return class-string<T>
     */
    public static function getClassString(object|string $objectOrClassString): string
    {
        if (is_string($objectOrClassString)) {
            /** @var class-string<T> */
            return $objectOrClassString;
        }

        /** @var class-string<T> */
        return get_debug_type($objectOrClassString);
    }

    /**
     * @template T of object
     * @param ReflectionAttribute<object>[] $attributes
     * @param class-string<T> $attributeClassString
     * @return T|null
     * @noinspection PhpDocSignatureInspection
     */
    public static function findSingleAttribute(array $attributes, string $attributeClassString): ?object
    {
        foreach ($attributes as $reflectionAttribute) {
            if ($reflectionAttribute->getName() === $attributeClassString) {
                /** @var T */
                return $reflectionAttribute->newInstance();
            }
        }

        return null;
    }

    /**
     * @template T of object
     * @param ReflectionAttribute<object>[] $attributes
     * @param class-string<T> $attributeClassString
     * @return T[]
     */
    public static function findMultipleAttributes(array $attributes, string $attributeClassString): array
    {
        /** @var T[] $foundAttributes */
        $foundAttributes = [];

        foreach ($attributes as $reflectionAttribute) {
            if ($reflectionAttribute->getName() === $attributeClassString) {
                /** @var T $t */
                $t = $reflectionAttribute->newInstance();
                $foundAttributes[] = $t;
            }
        }

        return $foundAttributes;
    }
}