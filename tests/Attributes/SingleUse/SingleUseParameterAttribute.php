<?php

namespace Zrnik\AttributeReflection\Attributes\SingleUse;

use Attribute;
use Zrnik\AttributeReflection\Attributes\BaseAttribute;

#[Attribute(Attribute::TARGET_PARAMETER)]
class SingleUseParameterAttribute extends BaseAttribute
{

}
