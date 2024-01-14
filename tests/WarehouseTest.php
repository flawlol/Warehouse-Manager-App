<?php

use PHPUnit\Framework\TestCase;
use Webdream\Warehouse\Core\Warehouse;
use Webdream\Warehouse\Factory\ProductFactory;
use Webdream\Warehouse\Interface\ManagerInterface;
use Webdream\Warehouse\Service\WarehouseService;
use Webdream\Warehouse\Trait\LoadProvidersForTests;

final class WarehouseTest extends TestCase
{
    use LoadProvidersForTests;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        $this->registerProviders();
        parent::__construct($name, $data, $dataName);
    }

    private function createWarehouse(int $capacity = 2): Warehouse
    {
        $container = container();

        /** @var WarehouseService $service */
        $service = $container->get(WarehouseService::class);

        return $service->createWarehouse($capacity);
    }

    public function testShouldBeAbleToAddWarehouseToManager(): void
    {
        // GIVEN
        $container = container();
        /** @var ManagerInterface $manager */
        $manager = $container->get(ManagerInterface::class);
        $warehouse = $this->createWarehouse();
        $warehouse2 = $this->createWarehouse();

        // WHEN
        $manager->addWarehouse($warehouse);
        $count = $manager->countWarehouses();

        // THEN
        $warehouses = $manager->getWarehouses();
        $this->assertCount($count, $warehouses);
        $this->assertContains($warehouse, $warehouses);
        $this->assertNotContains($warehouse2, $warehouses);
    }

    public function testShouldBeAbleToRemoveWarehouseFromManager(): void
    {
        // GIVEN
        $container = container();

        /** @var ManagerInterface $manager */
        $manager = $container->get(ManagerInterface::class);
        $warehouse = $this->createWarehouse();
        $warehouse2 = $this->createWarehouse();
        $warehouse3 = $this->createWarehouse();

        // WHEN
        $manager->addWarehouse($warehouse)->addWarehouse($warehouse2)->addWarehouse($warehouse3);
        $count = $manager->countWarehouses();
        $manager->removeWarehouse($warehouse);

        // THEN
        $this->assertNotCount($count, $manager->getWarehouses());
        $this->assertNotContains($warehouse, $manager->getWarehouses());
    }

    public function testShouldBeAbleToRemoveProductsFromMultipleWarehouse(): void
    {
        // GIVEN
        $container = container();

        /** @var ManagerInterface $manager */
        $manager = $container->get(ManagerInterface::class);

        /** @var ProductFactory $productFactory */
        $productFactory = $container->get(ProductFactory::class);
        $product = $productFactory->create();
        $product2 = $productFactory->create();
        $product3 = $productFactory->create();

        $warehouse = $this->createWarehouse(1);
        $warehouse2 = $this->createWarehouse();

        // WHEN
        $manager->addWarehouse($warehouse)->addWarehouse($warehouse2);

        $manager->addProduct($product)
            ->addProduct($product2)
            ->addProduct($product3);

        $countWarehouse = $warehouse->countInventory();
        $countWarehouse2 = $warehouse2->countInventory();

        $manager->removeProductFromWarehouse($product)->removeProductFromWarehouse($product2);

        // THEN
        $warehouseInventory = $warehouse->listInventory();
        $warehouse2Inventory = $warehouse2->listInventory();
        $this->assertNotCount($countWarehouse, $warehouseInventory);
        $this->assertNotCount($countWarehouse2, $warehouse2Inventory);
        $this->assertNotContains($product, $warehouseInventory);
        $this->assertNotContains($product2, $warehouse2Inventory);
        $this->assertContains($product3, $warehouse2Inventory);
        $this->assertCount(1, $warehouse2Inventory);
    }
}