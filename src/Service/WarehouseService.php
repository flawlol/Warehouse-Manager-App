<?php

namespace Webdream\Warehouse\Service;

use Webdream\Warehouse\Core\Product;
use Webdream\Warehouse\Core\Warehouse;
use Webdream\Warehouse\Core\WarehouseManager;
use Webdream\Warehouse\Exception\NoAvailableWarehouseException;
use Webdream\Warehouse\Factory\AddressFactory;
use Webdream\Warehouse\Interface\ManagerInterface;

class WarehouseService
{
    public function createWarehouse(int $capacity = 2): Warehouse
    {
        $names = ['Raktár1', 'Raktár2', 'Raktár3'];
        $randomName = $names[array_rand($names)];

        /** @var AddressFactory $addressFactory */
        $addressFactory = container()->get(AddressFactory::class);
        $address = $addressFactory->create();

        return new Warehouse($randomName, $address, $capacity);
    }

    public function addProductToWarehouse(WarehouseManager $warehouseManager, Product $product): ManagerInterface
    {
        /** @var Warehouse[] $warehouses */
        $warehouses = $warehouseManager->getWarehouses();
        foreach ($warehouses as $warehouse) {
            if ($warehouse->hasCapacity()) {
                $warehouse->addProduct($product);

                return $warehouseManager;
            }
        }

        throw new NoAvailableWarehouseException("Nincs elegendő kapacitás, a termék elhelyezésére!");
    }
}