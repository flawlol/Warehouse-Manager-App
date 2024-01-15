<?php

namespace Webdream\Warehouse\Item;

use Webdream\Warehouse\Core\Brand;
use Webdream\Warehouse\Core\Product;

class Mouse extends Product
{
    public function __construct(
        private readonly string $sku,
        private readonly string $name,
        private readonly int $price,
        private readonly Brand $brand,
        private readonly int $dpi
    )
    {
        parent::__construct($sku, $name, $price, $brand);
    }
}