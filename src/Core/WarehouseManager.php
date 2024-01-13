<?php

namespace Webdream\Warehouse\Core;

use Webdream\Warehouse\Exception\NoAvailableWarehouseException;
use Webdream\Warehouse\Interface\ManagerInterface;
use Webdream\Warehouse\Service\WarehouseService;

class WarehouseManager implements ManagerInterface
{
    public function __construct(
        private array $warehouses = [],
        private readonly WarehouseService $warehouseService = new WarehouseService()
    )
    {

    }

    public function addWarehouse(Warehouse $warehouse): self
    {
        $this->warehouses[] = $warehouse;

        return $this;
    }

    public function removeWarehouse(Warehouse $warehouse): void
    {
        foreach ($this->warehouses as $key => $item)
        {
            if ($item === $warehouse)
            {
                array_splice($this->warehouses, $key, 1);
                break;
            }
        }
    }

    /**
     * @throws NoAvailableWarehouseException
     */
    public function addProductToWarehouses(Product $product): self
    {
        return $this->warehouseService->addProductToWarehouse($this, $product);
    }

    public function getWarehouse(Warehouse $warehouse): Warehouse
    {
        return $warehouse;
    }

    public function getWarehouses(): array
    {
        return $this->warehouses;
    }

    public function countWarehouses(): int
    {
        return count($this->warehouses);
    }

    public function removeProductFromWarehouse(Product $product): self
    {
        /** @var Warehouse $warehouse */
        foreach ($this->warehouses as $warehouse)
        {
            if ($warehouse->hasItem($product)) {
                $warehouse->removeProductFromInventory($product);
            }
        }

        return $this;
    }
}