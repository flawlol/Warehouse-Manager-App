<?php

namespace Webdream\Warehouse\Interface;

use Webdream\Warehouse\Core\Product;
use Webdream\Warehouse\Core\Warehouse;

interface ManagerInterface
{
    public function addWarehouse(Warehouse $warehouse): self;
    public function removeWarehouse(Warehouse $warehouse): void;
    public function addProduct(Product $product): self;
    public function getWarehouse(Warehouse $warehouse): Warehouse;
    public function getWarehouses(): array;
    public function countWarehouses(): int;
    public function removeProductFromWarehouse(Product $product): self;
}