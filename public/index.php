<?php

use Webdream\Warehouse\Core\Address;
use Webdream\Warehouse\Core\Brand;
use Webdream\Warehouse\Core\Warehouse;
use Webdream\Warehouse\Exception\NoAvailableWarehouseException;
use Webdream\Warehouse\Factory\AddressFactory;
use Webdream\Warehouse\Factory\ProductFactory;
use Webdream\Warehouse\Factory\WarehouseFactory;
use Webdream\Warehouse\Interface\ManagerInterface;

require_once __DIR__ . '/../src/kernel.php';

/** Globális container kezelő */
$container = container();

/** Brand létrehozása */
$brand = new Brand("Intel", 5);

/** Raktár létrehozása manuálisan */

/** @var AddressFactory $addressFactory */
$addressFactory = $container->get(AddressFactory::class);
$address = $addressFactory->create();
$manualWarehouse = new Warehouse("Manuál raktár", $address, 50);

/**
 * Factory-k használata
 *
 * @var ProductFactory $productFactory
 */
$productFactory = $container->get(ProductFactory::class);

/** @var WarehouseFactory $warehouseFactory */
$warehouseFactory = $container->get(WarehouseFactory::class);

$product = $productFactory->create();
$product2 = $productFactory->create();
$product3 = $productFactory->create();
$product4 = $productFactory->create();

$warehouse = $warehouseFactory->create();
$warehouse2 = $warehouseFactory->create();


/**
 * Osztályok lekérése container segítségével
 *
 * @var ManagerInterface $warehouseManager
 */
$warehouseManager = $container->get(ManagerInterface::class);


/** Raktár hozzáadása a manger-hez */

$warehouseManager->addWarehouse($warehouse);
$warehouseManager->addWarehouse($warehouse2);


/** Termékek hozzáadása a raktárhoz. */
try {
    $warehouseManager->addProductToWarehouses($product);
    $warehouseManager->addProductToWarehouses($product2);
    $warehouseManager->addProductToWarehouses($product3);
    $warehouseManager->addProductToWarehouses($product4);
} catch (NoAvailableWarehouseException $e) {
    dd($e);
}

/** Termék törlése a raktárból */
$warehouseManager->removeProductFromWarehouse($product4);

/** Debug helper */
dd($warehouseManager);