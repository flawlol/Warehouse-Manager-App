<?php

namespace Webdream\Warehouse\Core;

use Webdream\Warehouse\Interface\FactoryCreatable;

class Product implements FactoryCreatable
{
    public function __construct(private string $sku, private string $name, private int $price, private Brand $brand)
    {

    }
}