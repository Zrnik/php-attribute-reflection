<?php

namespace Zrnik\Example;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS_CONSTANT)]
class AttributeToFind
{
    public function __construct(
        public readonly string $customValue
    )
    {
    }
}