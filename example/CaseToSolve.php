<?php

namespace Zrnik\Example;

use ReflectionClass;
use RuntimeException;

enum CaseToSolve
{
    #[AttributeToFind('AnyParameter')]
    case FirstCase;

    #[AttributeToFind('DifferentParameter')]
    #[AnotherAttribute('WhateverIsHere')]
    case SecondCase;

    case ThirdCase;

    public function getParameter(): string
    {
        $reflection = new ReflectionClass(self::class);
        $caseReflection = $reflection->getReflectionConstant($this->name);

        if($caseReflection === false) {
            throw new RuntimeException('case not found');
        }

        foreach ($caseReflection->getAttributes() as $reflectionAttribute) {
            if ($reflectionAttribute->getName() === AttributeToFind::class) {
                /** @var AttributeToFind $attributeToFindInstance */
                $attributeToFindInstance = $reflectionAttribute->newInstance();
                return $attributeToFindInstance->customValue;
            }
        }

        throw new RuntimeException(
            sprintf(
                'attribute "%s" not found on "%s"!',
                AttributeToFind::class,
                $this->name
            )
        );
    }
}
