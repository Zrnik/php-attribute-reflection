<?php

namespace Zrnik\AttributeReflection\Attributes;

abstract class BaseAttribute
{
    public function __construct(
        public string $parameter1,
        public string $parameter2 = 'default'
    )
    {
    }
}