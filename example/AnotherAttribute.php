<?php

namespace Zrnik\Example;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS_CONSTANT)]
class AnotherAttribute
{
    public function __construct(
        public readonly string $customValue
    )
    {
    }
}