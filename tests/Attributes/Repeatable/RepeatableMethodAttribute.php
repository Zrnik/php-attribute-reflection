<?php

namespace Zrnik\AttributeReflection\Attributes\Repeatable;

use Attribute;
use Zrnik\AttributeReflection\Attributes\BaseAttribute;

#[Attribute(Attribute::TARGET_METHOD|Attribute::IS_REPEATABLE)]
class RepeatableMethodAttribute extends BaseAttribute
{

}
