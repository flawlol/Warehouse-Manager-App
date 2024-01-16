<?php

namespace Webdream\Warehouse\Item;

use Webdream\Warehouse\Core\Brand;
use Webdream\Warehouse\Core\Product;

class Mouse extends Product
{
    public function __construct(
        protected string $sku,
        protected string $name,
        protected int $price,
        protected Brand $brand,
        private int $dpi
    )
    {
        parent::__construct($sku, $name, $price, $brand);
    }

    public function getDpi(): int
    {
        return $this->dpi;
    }

    public function setDpi(int $dpi): void
    {
        $this->dpi = $dpi;
    }
}