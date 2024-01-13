<?php

namespace Webdream\Warehouse\Item;

use Webdream\Warehouse\Core\Product;

class Mouse extends Product
{
    public function __construct($sku, $name, $price, $brand, private readonly int $dpi)
    {
        parent::__construct($sku, $name, $price, $brand);
    }
}