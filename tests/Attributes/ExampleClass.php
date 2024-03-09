<?php

namespace Zrnik\AttributeReflection\Attributes;

use Zrnik\AttributeReflection\Attributes\Repeatable\RepeatableAllAttribute;
use Zrnik\AttributeReflection\Attributes\Repeatable\RepeatableClassAttribute;
use Zrnik\AttributeReflection\Attributes\Repeatable\RepeatableClassConstantAttribute;
use Zrnik\AttributeReflection\Attributes\Repeatable\RepeatableMethodAttribute;
use Zrnik\AttributeReflection\Attributes\Repeatable\RepeatableParameterAttribute;
use Zrnik\AttributeReflection\Attributes\Repeatable\RepeatablePropertyAttribute;
use Zrnik\AttributeReflection\Attributes\SingleUse\SingleUseAllAttribute;
use Zrnik\AttributeReflection\Attributes\SingleUse\SingleUseClassAttribute;
use Zrnik\AttributeReflection\Attributes\SingleUse\SingleUseClassConstantAttribute;
use Zrnik\AttributeReflection\Attributes\SingleUse\SingleUseMethodAttribute;
use Zrnik\AttributeReflection\Attributes\SingleUse\SingleUseParameterAttribute;
use Zrnik\AttributeReflection\Attributes\SingleUse\SingleUsePropertyAttribute;

#[SingleUseAllAttribute('Class')]
#[RepeatableAllAttribute('Class')]
#[RepeatableAllAttribute('Class', 'Class')]
#[SingleUseClassAttribute('Test')]
#[RepeatableClassAttribute('Test')]
#[RepeatableClassAttribute('Test', 'Test')]
class ExampleClass
{
    #[SingleUseAllAttribute('Constant')]
    #[RepeatableAllAttribute('Constant')]
    #[RepeatableAllAttribute('Constant', 'Constant')]
    #[SingleUseClassConstantAttribute('Test')]
    #[RepeatableClassConstantAttribute('Test')]
    #[RepeatableClassConstantAttribute('Test', 'Test')]
    public const CONSTANT = 'constant';

    #[SingleUseAllAttribute('Property')]
    #[RepeatableAllAttribute('Property')]
    #[RepeatableAllAttribute('Property', 'Property')]
    #[SingleUsePropertyAttribute('Test')]
    #[RepeatablePropertyAttribute('Test')]
    #[RepeatablePropertyAttribute('Test', 'Test')]
    public ?string $property = null;

    #[SingleUseAllAttribute('Method')]
    #[RepeatableAllAttribute('Method')]
    #[RepeatableAllAttribute('Method', 'Method')]
    #[SingleUseMethodAttribute('Test')]
    #[RepeatableMethodAttribute('Test')]
    #[RepeatableMethodAttribute('Test', 'Test')]
    public function testFunction(
        #[SingleUseAllAttribute('Parameter')]
        #[RepeatableAllAttribute('Parameter')]
        #[RepeatableAllAttribute('Parameter', 'Parameter')]
        #[SingleUseParameterAttribute('Test')]
        #[RepeatableParameterAttribute('Test')]
        #[RepeatableParameterAttribute('Test', 'Test')]
        string $functionParameter
    ): void
    {
    }
}
