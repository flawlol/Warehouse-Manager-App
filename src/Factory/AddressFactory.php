<?php

namespace Webdream\Warehouse\Factory;

use Webdream\Warehouse\Core\Address;
use Webdream\Warehouse\Interface\FactoryInterface;

class AddressFactory implements FactoryInterface
{
    public function create(): Address
    {
        $zips = ["1234", "4321", "9876"];
        $cities = ["Budapest", "Pécs", "Debrecen"];
        $addresses = ["Valami cím 12", "Föld alatti 4312", "Chiliad"];

        $zip = array_rand($zips);
        $city = array_rand($cities);
        $address = array_rand($addresses);

        return new Address(
            $zips[$zip],
            $cities[$city],
            $addresses[$address]
        );
    }
}