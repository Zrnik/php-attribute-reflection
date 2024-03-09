<?php

namespace Zrnik\AttributeReflection\Attributes\Repeatable;

use Attribute;
use Zrnik\AttributeReflection\Attributes\BaseAttribute;

#[Attribute(Attribute::TARGET_CLASS_CONSTANT|Attribute::IS_REPEATABLE)]
class RepeatableClassConstantAttribute extends BaseAttribute
{

}
