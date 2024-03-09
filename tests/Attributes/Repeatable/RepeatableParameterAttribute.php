<?php

namespace Zrnik\AttributeReflection\Attributes\Repeatable;

use Attribute;
use Zrnik\AttributeReflection\Attributes\BaseAttribute;

#[Attribute(Attribute::TARGET_PARAMETER|Attribute::IS_REPEATABLE)]
class RepeatableParameterAttribute extends BaseAttribute
{

}
