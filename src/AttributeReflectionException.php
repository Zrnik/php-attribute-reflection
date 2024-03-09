<?php

namespace Zrnik\AttributeReflection;

use ReflectionException;
use RuntimeException;
use Throwable;

class AttributeReflectionException extends RuntimeException
{
    final private function __construct(string $message, Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }

    public static function fromReflectionException(ReflectionException $reflectionException): self
    {
        return new self($reflectionException->getMessage(), $reflectionException);
    }

    public static function notAnAttribute(string $attributeClassString): self
    {
        return new self(
            sprintf('Class "%s" is not an attribute!', $attributeClassString)
        );
    }

    public static function mustNotBeRepeatable(
        string $attributeClassString,
        string $usedMethod,
        string $suggestedMethod,
    ): self
    {
        return new self(sprintf(
            'Looking for repeatable attribute "%s" with method "%s" is not allowed, ' .
            'please use "%s" method instead!',
            $attributeClassString,
            $usedMethod,
            $suggestedMethod,
        ));
    }

    public static function mustBeRepeatable(
        string $attributeClassString,
        string $usedMethod,
        string $suggestedMethod,
    ): self
    {
        return new self(sprintf(
            'Looking for non-repeatable attribute "%s" with method "%s" is not allowed, ' .
            'please use "%s" method instead!',
            $attributeClassString,
            $usedMethod,
            $suggestedMethod,
        ));
    }

    public static function invalidTarget(string $attributeClassString, string $targetName): self
    {
        return new self(
            sprintf('Attribute "%s" does not target "%s"!', $attributeClassString, $targetName)
        );
    }

    public static function unknownTarget(string $attributeClassString, int $targetFlag): self
    {
        return new self(
            sprintf('Attribute "%s" has an invalid target "%d"!', $attributeClassString, $targetFlag)
        );
    }

    public static function targetNotFound(
        string $targetName,
        string $targetValue
    ): self
    {
        return new self(
            sprintf(
                '%s "%s" was not found!',
                $targetName,
                $targetValue,
            )
        );
    }

    public static function subTargetNotFoundOnTarget(
        string $targetName,
        string $subTargetName,
        string $targetValue,
        string $subTargetValue,
    ): self
    {
        return new self(
            sprintf(
                '%s "%s" was not found on %s "%s"!',
                $subTargetName,
                $subTargetValue,
                $targetName,
                $targetValue,
            )
        );
    }

    public static function attributeNotFoundOnTarget(
        string $attributeClassString,
        string $targetName,
        string $targetValue
    ): self
    {
        return new self(
            sprintf(
                'Attribute "%s" was not found on %s "%s"!',
                $attributeClassString,
                $targetName,
                $targetValue
            )
        );
    }

    public static function targetWithSubTargetNotFound(
        string $targetName,
        string $subTargetName,
        string $targetValue,
        string $subTargetValue
    ): self
    {
        return new self(
            sprintf(
                '%s "%s" on %s "%s" was not found!',
                $targetName,
                $targetValue,
                $subTargetName,
                $subTargetValue,
            )
        );
    }

    public static function attributeNotFoundOnTargetWithSubTarget(
        string $attributeClassString,
        string $targetName,
        string $subTargetName,
        string $targetValue,
        string $subTargetValue,
    ): self
    {
        return new self(
            sprintf(
                'Attribute "%s" was not found on %s "%s" on %s "%s"!',
                $attributeClassString,
                $targetName,
                $targetValue,
                $subTargetName,
                $subTargetValue
            )
        );
    }
}