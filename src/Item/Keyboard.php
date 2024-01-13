<?php

namespace Webdream\Warehouse\Item;

use Webdream\Warehouse\Core\Product;

class Keyboard extends Product
{
    public function __construct($sku, $name, $price, $brand, private readonly bool $isMechanical)
    {
        parent::__construct($sku, $name, $price, $brand);
    }
}