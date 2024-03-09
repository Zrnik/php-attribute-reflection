<?php

namespace Zrnik\AttributeReflection\Attributes\Repeatable;

use Attribute;
use Zrnik\AttributeReflection\Attributes\BaseAttribute;

#[Attribute(Attribute::TARGET_CLASS|Attribute::IS_REPEATABLE)]
class RepeatableClassAttribute extends BaseAttribute
{

}
