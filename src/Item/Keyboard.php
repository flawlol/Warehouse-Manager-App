<?php

namespace Webdream\Warehouse\Item;

use Webdream\Warehouse\Core\Brand;
use Webdream\Warehouse\Core\Product;

class Keyboard extends Product
{
    public function __construct(
        private readonly string $sku,
        private readonly string $name,
        private readonly int $price,
        private readonly Brand $brand,
        private readonly bool $isMechanical
    )
    {
        parent::__construct($sku, $name, $price, $brand);
    }
}