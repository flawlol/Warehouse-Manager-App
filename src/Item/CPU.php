<?php

namespace Webdream\Warehouse\Item;

use Webdream\Warehouse\Core\Product;

class CPU extends Product
{
    public function __construct($sku, $name, $price, $brand, private readonly int $warrantyPeriod)
    {
        parent::__construct($sku, $name, $price, $brand);
    }
}