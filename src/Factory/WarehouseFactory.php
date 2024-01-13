<?php

namespace Webdream\Warehouse\Factory;

use Webdream\Warehouse\Core\Warehouse;
use Webdream\Warehouse\Interface\FactoryInterface;

class WarehouseFactory implements FactoryInterface
{
    public function create(): Warehouse
    {
        $names = ['Raktár1', 'Raktár2', 'Raktár3'];
        $capacity = random_int(1, 5);

        $randomName = $names[array_rand($names)];

        /** @var AddressFactory $addressFactory */
        $addressFactory = container()->get(AddressFactory::class);
        $address = $addressFactory->create();

        return new Warehouse($randomName, $address, $capacity);
    }
}