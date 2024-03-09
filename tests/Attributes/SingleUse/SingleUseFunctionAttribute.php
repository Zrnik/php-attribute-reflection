<?php

namespace Zrnik\AttributeReflection\Attributes\SingleUse;

use Attribute;
use Zrnik\AttributeReflection\Attributes\BaseAttribute;

#[Attribute(Attribute::TARGET_FUNCTION)]
class SingleUseFunctionAttribute extends BaseAttribute
{

}
