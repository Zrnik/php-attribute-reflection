# Attribute Reflection

Fully tested, phpstan level 9 compliant.

### Installation:

> composer require zrnik/php-attribtue-reflection

### Usage & Reason why this library exists.

I use attributes on enum cases a lot. It's a good way to put 
metadata on the cases. Let's look at this example:

```php
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
```

You probably know what its meant to do:

```php
CaseToSolve::FirstCase->getParameter(); // 'AnyParameter'
CaseToSolve::SecondCase->getParameter(); // 'DifferentParameter'
CaseToSolve::ThirdCase->getParameter(); // RuntimeException
```

This is what this library does, it just returns the attribute value.
Now let's see how this code would work with this library:

```php
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
```

The `getParameter` method is much better, isn't it? Works the same:

```php
SolvedCase::FirstCase->getParameter(); // 'AnyParameter'
SolvedCase::SecondCase->getParameter(); // 'DifferentParameter'
SolvedCase::ThirdCase->getParameter(); // \Zrnik\AttributeReflection\AttributeReflectionException
```
