<?php

namespace Zrnik\AttributeReflection;

use Attribute;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Zrnik\AttributeReflection\Attributes\ExampleClass;
use Zrnik\AttributeReflection\Attributes\Repeatable\RepeatableAllAttribute;
use Zrnik\AttributeReflection\Attributes\Repeatable\RepeatableClassAttribute;
use Zrnik\AttributeReflection\Attributes\Repeatable\RepeatableClassConstantAttribute;
use Zrnik\AttributeReflection\Attributes\Repeatable\RepeatableFunctionAttribute;
use Zrnik\AttributeReflection\Attributes\Repeatable\RepeatableMethodAttribute;
use Zrnik\AttributeReflection\Attributes\Repeatable\RepeatableParameterAttribute;
use Zrnik\AttributeReflection\Attributes\Repeatable\RepeatablePropertyAttribute;
use Zrnik\AttributeReflection\Attributes\SingleUse\SingleUseAllAttribute;
use Zrnik\AttributeReflection\Attributes\SingleUse\SingleUseClassAttribute;
use Zrnik\AttributeReflection\Attributes\SingleUse\SingleUseClassConstantAttribute;
use Zrnik\AttributeReflection\Attributes\SingleUse\SingleUseFunctionAttribute;
use Zrnik\AttributeReflection\Attributes\SingleUse\SingleUseMethodAttribute;
use Zrnik\AttributeReflection\Attributes\SingleUse\SingleUseParameterAttribute;
use Zrnik\AttributeReflection\Attributes\SingleUse\SingleUsePropertyAttribute;
use Zrnik\PHPUnit\Exceptions;

class AssertionsTest extends TestCase
{
    use Exceptions;

    private const UNKNOWN_ATTRIBUTE_TARGET = 512;
    private const MOCK_METHOD_NAME1 = 'Attribute';
    private const MOCK_METHOD_NAME2 = 'Attributes';

    public function testIsAttributeAssertion(): void
    {
        $this->assertNoExceptionThrown(
            fn() => Assertions::assertIsAttribute(RepeatableAllAttribute::class)
        );

        $this->assertNoExceptionThrown(
            fn() => Assertions::assertIsAttribute(SingleUseFunctionAttribute::class)
        );

        $this->assertExceptionThrown(
            AttributeReflectionException::class,
            fn() => Assertions::assertIsAttribute(ExampleClass::class)
        );
    }

    public function testIsNotRepeatableAssertion(): void
    {
        $this->assertNoExceptionThrown(
            fn() => Assertions::assertIsNotRepeatable(
                SingleUseParameterAttribute::class,
                self::MOCK_METHOD_NAME1,
            )
        );

        $this->assertExceptionThrown(
            AttributeReflectionException::class,
            fn() => Assertions::assertIsNotRepeatable(
                RepeatableFunctionAttribute::class,
                self::MOCK_METHOD_NAME1,
            )
        );
    }

    public function testIsRepeatableAssertion(): void
    {
        $this->assertNoExceptionThrown(
            fn() => Assertions::assertIsRepeatable(
                RepeatableAllAttribute::class,
                self::MOCK_METHOD_NAME2,
            )
        );

        $this->assertExceptionThrown(
            AttributeReflectionException::class,
            fn() => Assertions::assertIsRepeatable(
                SingleUseAllAttribute::class,
                self::MOCK_METHOD_NAME2,
            )
        );
    }

    public function testTargetAllAssertion(): void
    {
        $attributes = [
            RepeatableAllAttribute::class,
            SingleUseAllAttribute::class,
        ];

        $targets = [
            Attribute::TARGET_ALL,
            Attribute::TARGET_CLASS,
            Attribute::TARGET_FUNCTION,
            Attribute::TARGET_METHOD,
            Attribute::TARGET_PROPERTY,
            Attribute::TARGET_CLASS_CONSTANT,
            Attribute::TARGET_PARAMETER,
        ];

        foreach ($attributes as $attribute) {
            foreach ($targets as $target) {
                $this->assertNoExceptionThrown(
                    fn() => Assertions::assertTarget($attribute, $target)
                );
            }
        }
    }

    public function testTargetAssertion(): void
    {
        $allTargets = [
            'TARGET_ALL' => Attribute::TARGET_ALL,
            'TARGET_CLASS' => Attribute::TARGET_CLASS,
            'TARGET_CLASS_CONSTANT' => Attribute::TARGET_CLASS_CONSTANT,
            'TARGET_FUNCTION' => Attribute::TARGET_FUNCTION,
            'TARGET_METHOD' => Attribute::TARGET_METHOD,
            'TARGET_PARAMETER' => Attribute::TARGET_PARAMETER,
            'TARGET_PROPERTY' => Attribute::TARGET_PROPERTY,
            'UNKNOWN_ATTRIBUTE_TARGET' => self::UNKNOWN_ATTRIBUTE_TARGET,
        ];

        $truthTable = [
            RepeatableClassAttribute::class => Attribute::TARGET_CLASS,
            RepeatableClassConstantAttribute::class => Attribute::TARGET_CLASS_CONSTANT,
            RepeatableFunctionAttribute::class => Attribute::TARGET_FUNCTION,
            RepeatableMethodAttribute::class => Attribute::TARGET_METHOD,
            RepeatableParameterAttribute::class => Attribute::TARGET_PARAMETER,
            RepeatablePropertyAttribute::class => Attribute::TARGET_PROPERTY,
            SingleUseClassAttribute::class => Attribute::TARGET_CLASS,
            SingleUseClassConstantAttribute::class => Attribute::TARGET_CLASS_CONSTANT,
            SingleUseFunctionAttribute::class => Attribute::TARGET_FUNCTION,
            SingleUseMethodAttribute::class => Attribute::TARGET_METHOD,
            SingleUseParameterAttribute::class => Attribute::TARGET_PARAMETER,
            SingleUsePropertyAttribute::class => Attribute::TARGET_PROPERTY,
        ];

        foreach ($truthTable as $attributeClassString => $attributeExpectedTarget) {
            foreach ($allTargets as $testedTargetName => $testedTarget) {
                if (
                    ($testedTarget === $attributeExpectedTarget || $testedTarget === Attribute::TARGET_ALL)
                    && $testedTarget !== self::UNKNOWN_ATTRIBUTE_TARGET
                ) {
                    $this->assertNoExceptionThrown(
                        fn() => Assertions::assertTarget($attributeClassString, $testedTarget)
                    );
                } else {
                    $attributeReflectionException = $this->assertExceptionThrown(
                        AttributeReflectionException::class,
                        fn() => Assertions::assertTarget($attributeClassString, $testedTarget)
                    );

                    $this->assertSame(
                        ($testedTarget === self::UNKNOWN_ATTRIBUTE_TARGET)
                            ? AttributeReflectionException::unknownTarget($attributeClassString, $testedTarget)->getMessage()
                            : AttributeReflectionException::invalidTarget($attributeClassString, $testedTargetName)->getMessage(),
                        $attributeReflectionException->getMessage(),
                    );
                }
            }
        }
    }

    public function testCreateOppositeMethodName(): void
    {
        $truthTable = [
            'TestAttribute' => 'TestAttributes',
            'OtherAttribute' => 'OtherAttributes',
            'TestAttributes' => 'TestAttribute',
            'OtherAttributes' => 'OtherAttribute',
        ];

        foreach ($truthTable as $input => $expectedOutput) {
            self::assertSame(
                $expectedOutput,
                Assertions::createOppositeMethodName($input),
            );
        }

        /** @noinspection SpellCheckingInspection */
        $exceptions = [
            'TestAttribut',
            'TestAttributeSuffix',
        ];

        foreach ($exceptions as $invalidMethodName) {

            $this->assertExceptionThrown(
                RuntimeException::class,
                fn() => Assertions::createOppositeMethodName($invalidMethodName),
            );
        }
    }
}
