<?php

use Zrnik\AttributeReflection\Attributes\Repeatable\RepeatableAllAttribute;
use Zrnik\AttributeReflection\Attributes\Repeatable\RepeatableFunctionAttribute;
use Zrnik\AttributeReflection\Attributes\Repeatable\RepeatableParameterAttribute;
use Zrnik\AttributeReflection\Attributes\SingleUse\SingleUseAllAttribute;
use Zrnik\AttributeReflection\Attributes\SingleUse\SingleUseFunctionAttribute;
use Zrnik\AttributeReflection\Attributes\SingleUse\SingleUseParameterAttribute;

#[SingleUseAllAttribute('Function')]
#[RepeatableAllAttribute('Function')]
#[RepeatableAllAttribute('Function', 'Function')]
#[SingleUseFunctionAttribute('Test')]
#[RepeatableFunctionAttribute('Test')]
#[RepeatableFunctionAttribute('Test', 'Test')]
function php_attribute_reflection_test_function(
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
