<?php

namespace Zrnik\AttributeReflection\Attributes\Repeatable;

use Attribute;
use Zrnik\AttributeReflection\Attributes\BaseAttribute;

#[Attribute(Attribute::TARGET_ALL|Attribute::IS_REPEATABLE)]
class RepeatableAllAttribute extends BaseAttribute
{

}
