<?php

namespace Zrnik\AttributeReflection\Attributes\Repeatable;

use Attribute;
use Zrnik\AttributeReflection\Attributes\BaseAttribute;

#[Attribute(Attribute::TARGET_PROPERTY|Attribute::IS_REPEATABLE)]
class RepeatablePropertyAttribute extends BaseAttribute
{

}
