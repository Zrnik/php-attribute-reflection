<?php

namespace Zrnik\Example;

use Zrnik\AttributeReflection\AttributeReflection;
use Zrnik\AttributeReflection\AttributeReflectionException;

enum SolvedCase
{
    #[AttributeToFind('AnyParameter')]
    case FirstCase;

    #[AttributeToFind('DifferentParameter')]
    #[AnotherAttribute('WhateverIsHere')]
    case SecondCase;

    case ThirdCase;

    /**
     * @return string
     * @throws AttributeReflectionException
     */
    public function getParameter(): string
    {
       return AttributeReflection::getClassConstantAttribute(
           AttributeToFind::class,
           self::class,
           $this->name
       )->customValue;
    }
}
