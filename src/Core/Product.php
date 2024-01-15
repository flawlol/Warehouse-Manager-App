<?php

namespace Webdream\Warehouse\Core;

use Webdream\Warehouse\Interface\FactoryCreatable;

class Product implements FactoryCreatable
{
    protected function __construct(
        protected string $sku,
        protected string $name,
        protected int $price,
        protected Brand $brand
    )
    {

    }
}