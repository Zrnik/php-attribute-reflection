<?php

namespace Zrnik\AttributeReflection\Attributes\Repeatable;

use Attribute;
use Zrnik\AttributeReflection\Attributes\BaseAttribute;

#[Attribute(Attribute::TARGET_FUNCTION|Attribute::IS_REPEATABLE)]
class RepeatableFunctionAttribute extends BaseAttribute
{

}
