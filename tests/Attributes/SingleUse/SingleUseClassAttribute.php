<?php

namespace Zrnik\AttributeReflection\Attributes\SingleUse;

use Attribute;
use Zrnik\AttributeReflection\Attributes\BaseAttribute;

#[Attribute(Attribute::TARGET_CLASS)]
class SingleUseClassAttribute extends BaseAttribute
{

}
