<?php

namespace Webdream\Warehouse\Item;

use Webdream\Warehouse\Core\Brand;
use Webdream\Warehouse\Core\Product;

class CPU extends Product
{
    public function __construct(
        protected string $sku,
        protected string $name,
        protected int $price,
        protected Brand $brand,
        private int $warrantyPeriod
    )
    {
        parent::__construct($sku, $name, $price, $brand);
    }

    public function getWarrantyPeriod(): int
    {
        return $this->warrantyPeriod;
    }

    public function setWarrantyPeriod(int $warrantyPeriod): self
    {
        $this->warrantyPeriod = $warrantyPeriod;

        return $this;
    }
}