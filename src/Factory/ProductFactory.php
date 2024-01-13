<?php

namespace Webdream\Warehouse\Factory;

use Webdream\Warehouse\Builder\CPUBuilder;
use Webdream\Warehouse\Builder\KeyboardBuilder;
use Webdream\Warehouse\Builder\MouseBuilder;
use Webdream\Warehouse\Core\Brand;
use Webdream\Warehouse\Core\Product;
use Webdream\Warehouse\Interface\FactoryInterface;

class ProductFactory implements FactoryInterface
{
    public function create(): Product
    {
        $sku = $this->generateRandomSku();
        $price = random_int(100, 1000);

        $cpu = (new CPUBuilder())
            ->setName("I7 10700K")
            ->setBrand((new Brand("Intel", 5)))
            ->setSku($sku)
            ->setPrice($price)
            ->setWarrantyPeriod(3)
            ->build();

        $keyboard = (new KeyboardBuilder())
            ->setSku($sku)
            ->setName("Mechanikus billentyűzet")
            ->setPrice($price)
            ->setBrand((new Brand("Volcano", 3)))
            ->setIsMechanical(true)
            ->build();

        $mouse = (new MouseBuilder())
            ->setSku($sku)
            ->setName("DeathAdder V2")
            ->setPrice($price)
            ->setBrand((new Brand("Razer", 4)))
            ->setDpi(20000)
            ->build();

        $products = [
            $cpu,
            $keyboard,
            $mouse,
        ];

        return $products[array_rand($products)];
    }

    private function generateRandomSku(): string
    {
        return 'SKU' . random_int(1000, 9999);
    }
}