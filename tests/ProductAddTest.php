<?php

use PHPUnit\Framework\TestCase;
use Webdream\Warehouse\Core\Warehouse;
use Webdream\Warehouse\Core\WarehouseManager;
use Webdream\Warehouse\Exception\NoAvailableWarehouseException;
use Webdream\Warehouse\Factory\ProductFactory;
use Webdream\Warehouse\Interface\ManagerInterface;
use Webdream\Warehouse\Service\WarehouseService;
use Webdream\Warehouse\Trait\LoadProvidersForTests;

final class ProductAddTest extends TestCase
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

    public function testShouldBeAbleToRemoveProductsFromWarehouse(): void
    {
        // GIVEN
        $container = container();

        /** @var ProductFactory $productFactory */
        $productFactory = $container->get(ProductFactory::class);
        $product = $productFactory->create();
        $product2 = $productFactory->create();
        $product3 = $productFactory->create();

        /** @var ManagerInterface $manager */
        $manager = $container->get(ManagerInterface::class);
        $warehouse = $this->createWarehouse(3);

        // WHEN
        $manager->addWarehouse($warehouse);
        $manager->addProductToWarehouses($product)
            ->removeProductFromWarehouse($product)
            ->addProductToWarehouses($product2)
            ->addProductToWarehouses($product3);

        $manager->removeProductFromWarehouse($product2);

        // THEN
        $warehouse = $manager->getWarehouse($warehouse);
        $count = $warehouse->countInventory();
        $this->assertNotContains($product, $warehouse->listInventory());
        $this->assertNotContains($product2, $warehouse->listInventory());
        $this->assertContains($product3, $warehouse->listInventory());
        $this->assertCount($count, $warehouse->listInventory());
    }

    public function testShouldBeAbleToAddProductToWarehouse(): void
    {
        // GIVEN
        $container = container();

        /** @var ProductFactory $productFactory */
        $productFactory = $container->get(ProductFactory::class);
        $product = $productFactory->create();
        $product2 = $productFactory->create();
        $product3 = $productFactory->create();

        $warehouse = $this->createWarehouse(1);
        $warehouse2 = $this->createWarehouse();
        $warehouse3 = $this->createWarehouse();

        $manager = new WarehouseManager();

        // WHEN
        $manager->addWarehouse($warehouse);
        $manager->addWarehouse($warehouse2);
        $manager->addWarehouse($warehouse3);
        $manager->addProductToWarehouses($product)
            ->addProductToWarehouses($product2)
            ->addProductToWarehouses($product3);

        $getWarehouse = $manager->getWarehouse($warehouse);
        $getWarehouse2 = $manager->getWarehouse($warehouse);
        $getWarehouse3 = $manager->getWarehouse($warehouse);

        // THEN
        $this->assertContains($product, $getWarehouse->listInventory());
        $this->assertCount($getWarehouse->countInventory(), $getWarehouse->listInventory());
        $this->assertCount($getWarehouse2->countInventory(), $getWarehouse->listInventory());
        $this->assertCount($getWarehouse3->countInventory(), $getWarehouse->listInventory());
    }

    public function testShouldThrowExceptionDueToNoCapacity(): void
    {
        // GIVEN
        $container = container();

        /** @var ProductFactory $productFactory */
        $productFactory = $container->get(ProductFactory::class);
        $product = $productFactory->create();
        $product2 = $productFactory->create();
        $product3 = $productFactory->create();

        $warehouse = $this->createWarehouse();

        $manager = new WarehouseManager();

        // WHEN
        $manager->addWarehouse($warehouse);

        // THEN
        $this->expectException(NoAvailableWarehouseException::class);
        $manager->addProductToWarehouses($product)->addProductToWarehouses($product2);
        $manager->addProductToWarehouses($product3);
    }
}