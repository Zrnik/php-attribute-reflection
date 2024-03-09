<?php

namespace Zrnik\AttributeReflection;

use PHPUnit\Framework\TestCase;
use Zrnik\AttributeReflection\Attributes\ExampleClass;
use Zrnik\AttributeReflection\Attributes\Repeatable\RepeatableAllAttribute;
use Zrnik\AttributeReflection\Attributes\Repeatable\RepeatableClassConstantAttribute;
use Zrnik\AttributeReflection\Attributes\Repeatable\RepeatableFunctionAttribute;
use Zrnik\AttributeReflection\Attributes\Repeatable\RepeatableMethodAttribute;
use Zrnik\AttributeReflection\Attributes\Repeatable\RepeatableParameterAttribute;
use Zrnik\AttributeReflection\Attributes\Repeatable\RepeatablePropertyAttribute;
use Zrnik\AttributeReflection\Attributes\SingleUse\SingleUseAllAttribute;
use Zrnik\AttributeReflection\Attributes\SingleUse\SingleUseClassConstantAttribute;
use Zrnik\AttributeReflection\Attributes\SingleUse\SingleUseFunctionAttribute;
use Zrnik\AttributeReflection\Attributes\SingleUse\SingleUseMethodAttribute;
use Zrnik\AttributeReflection\Attributes\SingleUse\SingleUseParameterAttribute;
use Zrnik\AttributeReflection\Attributes\SingleUse\SingleUsePropertyAttribute;
use Zrnik\PHPUnit\Exceptions;

class AttributeReflectionTest extends TestCase
{
    use Exceptions;

    private ExampleClass $exampleClass;

    protected function setUp(): void
    {
        $this->exampleClass = new ExampleClass();
    }

    public function testClassAttribute(): void
    {
        foreach ([$this->exampleClass, ExampleClass::class] as $objectOrClassString) {
            $singleUseAllAttribute = AttributeReflection::getClassAttribute(
                SingleUseAllAttribute::class,
                $objectOrClassString,
            );

            self::assertInstanceOf(
                SingleUseAllAttribute::class,
                $singleUseAllAttribute
            );

            self::assertSame(
                'Class',
                $singleUseAllAttribute->parameter1
            );

            $repeatableAllAttributes = AttributeReflection::getClassAttributes(
                RepeatableAllAttribute::class,
                $objectOrClassString,
            );

            self::assertInstanceOf(
                RepeatableAllAttribute::class,
                $repeatableAllAttributes[0]
            );

            self::assertSame(
                'Class',
                $repeatableAllAttributes[0]->parameter1
            );

            self::assertSame(
                'default',
                $repeatableAllAttributes[0]->parameter2
            );

            self::assertInstanceOf(
                RepeatableAllAttribute::class,
                $repeatableAllAttributes[1]
            );

            self::assertSame(
                'Class',
                $repeatableAllAttributes[1]->parameter1
            );

            self::assertSame(
                'Class',
                $repeatableAllAttributes[1]->parameter2
            );
        }
    }

    public function testClassConstantAttribute(): void
    {
        self::assertInstanceOf(
            SingleUseAllAttribute::class,
            AttributeReflection::getClassConstantAttribute(
                SingleUseAllAttribute::class,
                ExampleClass::class,
                'CONSTANT'
            )
        );

        self::assertInstanceOf(
            SingleUseClassConstantAttribute::class,
            AttributeReflection::getClassConstantAttribute(
                SingleUseClassConstantAttribute::class,
                ExampleClass::class,
                'CONSTANT'
            )
        );

        /** @var AttributeReflectionException $exception */
        $exception = $this->assertExceptionThrown(
            AttributeReflectionException::class,
            fn() => AttributeReflection::getClassConstantAttribute(
                SingleUseAllAttribute::class,
                ExampleClass::class,
                'UNKNOWN_CONSTANT'
            )
        );

        self::assertCount(
            2,
            AttributeReflection::getClassConstantAttributes(
                RepeatableAllAttribute::class,
                ExampleClass::class,
                'CONSTANT'
            )
        );

        self::assertCount(
            2,
            AttributeReflection::getClassConstantAttributes(
                RepeatableClassConstantAttribute::class,
                ExampleClass::class,
                'CONSTANT'
            )
        );
    }

    public function testPropertyAttribute(): void
    {
        self::assertInstanceOf(
            SingleUseAllAttribute::class,
            AttributeReflection::getPropertyAttribute(
                SingleUseAllAttribute::class,
                ExampleClass::class,
                'property'
            )
        );

        self::assertInstanceOf(
            SingleUsePropertyAttribute::class,
            AttributeReflection::getPropertyAttribute(
                SingleUsePropertyAttribute::class,
                ExampleClass::class,
                'property'
            )
        );

        $this->assertExceptionThrown(
            AttributeReflectionException::class,
            fn() => AttributeReflection::getPropertyAttribute(
                SingleUseAllAttribute::class,
                ExampleClass::class,
                'unknown_property'
            )
        );

        self::assertCount(
            2,
            AttributeReflection::getPropertyAttributes(
                RepeatableAllAttribute::class,
                ExampleClass::class,
                'property'
            )
        );

        self::assertCount(
            2,
            AttributeReflection::getPropertyAttributes(
                RepeatablePropertyAttribute::class,
                ExampleClass::class,
                'property'
            )
        );
    }

    public function testMethodAttribute(): void
    {
        self::assertInstanceOf(
            SingleUseAllAttribute::class,
            AttributeReflection::getMethodAttribute(
                SingleUseAllAttribute::class,
                ExampleClass::class,
                'testFunction'
            )
        );

        self::assertInstanceOf(
            SingleUseMethodAttribute::class,
            AttributeReflection::getMethodAttribute(
                SingleUseMethodAttribute::class,
                ExampleClass::class,
                'testFunction'
            )
        );

        $this->assertExceptionThrown(
            AttributeReflectionException::class,
            fn() => AttributeReflection::getMethodAttribute(
                SingleUseAllAttribute::class,
                ExampleClass::class,
                'unknownTestFunction'
            )
        );

        self::assertCount(
            2,
            AttributeReflection::getMethodAttributes(
                RepeatableAllAttribute::class,
                ExampleClass::class,
                'testFunction'
            )
        );

        self::assertCount(
            2,
            AttributeReflection::getMethodAttributes(
                RepeatableMethodAttribute::class,
                ExampleClass::class,
                'testFunction'
            )
        );
    }

    public function testMethodParameterAttribute(): void
    {
        self::assertInstanceOf(
            SingleUseAllAttribute::class,
            AttributeReflection::getMethodParameterAttribute(
                SingleUseAllAttribute::class,
                ExampleClass::class,
                'testFunction',
                'functionParameter',
            )
        );

        self::assertInstanceOf(
            SingleUseParameterAttribute::class,
            AttributeReflection::getMethodParameterAttribute(
                SingleUseParameterAttribute::class,
                ExampleClass::class,
                'testFunction',
                'functionParameter',
            )
        );

        $this->assertExceptionThrown(
            AttributeReflectionException::class,
            fn() => AttributeReflection::getMethodParameterAttribute(
                SingleUseAllAttribute::class,
                ExampleClass::class,
                'unknownTestFunction',
                'functionParameter',
            )
        );

        $this->assertExceptionThrown(
            AttributeReflectionException::class,
            fn() => AttributeReflection::getMethodParameterAttribute(
                SingleUseAllAttribute::class,
                ExampleClass::class,
                'testFunction',
                'unknownFunctionParameter',
            )
        );

        self::assertCount(
            2,
            AttributeReflection::getMethodParameterAttributes(
                RepeatableAllAttribute::class,
                ExampleClass::class,
                'testFunction',
                'functionParameter',
            )
        );

        self::assertCount(
            2,
            AttributeReflection::getMethodParameterAttributes(
                RepeatableParameterAttribute::class,
                ExampleClass::class,
                'testFunction',
                'functionParameter',
            )
        );
    }

    public function testFunctionAttribute(): void
    {
        self::assertInstanceOf(
            SingleUseAllAttribute::class,
            AttributeReflection::getFunctionAttribute(
                SingleUseAllAttribute::class,
                'php_attribute_reflection_test_function'
            )
        );

        self::assertInstanceOf(
            SingleUseFunctionAttribute::class,
            AttributeReflection::getFunctionAttribute(
                SingleUseFunctionAttribute::class,
                'php_attribute_reflection_test_function'
            )
        );

        $this->assertExceptionThrown(
            AttributeReflectionException::class,
            fn() => AttributeReflection::getFunctionAttribute(
                SingleUseFunctionAttribute::class,
                'unknown_php_attribute_reflection_test_function'
            )
        );

        self::assertCount(
            2,
            AttributeReflection::getFunctionAttributes(
                RepeatableAllAttribute::class,
                'php_attribute_reflection_test_function'
            )
        );

        self::assertCount(
            2,
            AttributeReflection::getFunctionAttributes(
                RepeatableFunctionAttribute::class,
                'php_attribute_reflection_test_function'
            )
        );
    }


    public function testFunctionParameterAttribute(): void
    {
        self::assertInstanceOf(
            SingleUseAllAttribute::class,
            AttributeReflection::getFunctionParameterAttribute(
                SingleUseAllAttribute::class,
                'php_attribute_reflection_test_function',
                'functionParameter',
            )
        );

        self::assertInstanceOf(
            SingleUseParameterAttribute::class,
            AttributeReflection::getFunctionParameterAttribute(
                SingleUseParameterAttribute::class,
                'php_attribute_reflection_test_function',
                'functionParameter',
            )
        );

        $this->assertExceptionThrown(
            AttributeReflectionException::class,
            fn() => AttributeReflection::getFunctionParameterAttribute(
                SingleUseAllAttribute::class,
                'unknown_php_attribute_reflection_test_function',
                'functionParameter',
            )
        );

        $this->assertExceptionThrown(
            AttributeReflectionException::class,
            fn() => AttributeReflection::getFunctionParameterAttribute(
                SingleUseAllAttribute::class,
                'php_attribute_reflection_test_function',
                'unknownFunctionParameter',
            )
        );

        self::assertCount(
            2,
            AttributeReflection::getFunctionParameterAttributes(
                RepeatableAllAttribute::class,
                'php_attribute_reflection_test_function',
                'functionParameter',
            )
        );

        self::assertCount(
            2,
            AttributeReflection::getFunctionParameterAttributes(
                RepeatableParameterAttribute::class,
                'php_attribute_reflection_test_function',
                'functionParameter',
            )
        );
    }
}
