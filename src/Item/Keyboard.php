<?php

namespace Webdream\Warehouse\Item;

use Webdream\Warehouse\Core\Brand;
use Webdream\Warehouse\Core\Product;

class Keyboard extends Product
{
    public function __construct(
        protected string $sku,
        protected string $name,
        protected int $price,
        protected Brand $brand,
        protected readonly bool $isMechanical
    )
    {
        parent::__construct($sku, $name, $price, $brand);
    }
}