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
        $manager->addProduct($product)
            ->removeProductFromWarehouse($product)
            ->addProduct($product2)
            ->addProduct($product3);


        $manager->removeProductFromWarehouse($product2);

        // THEN
        $warehouse = $manager->getWarehouse($warehouse);

        $this->assertNotContains($product, $warehouse->listInventory());
        $this->assertNotContains($product2, $warehouse->listInventory());
        $this->assertContains($product3, $warehouse->listInventory());
        $this->assertCount(1, $warehouse->listInventory());
        $this->assertNotCount(2, $warehouse->listInventory());
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
        $manager->addProduct($product)
            ->addProduct($product2)
            ->addProduct($product3);

        $getWarehouse = $manager->getWarehouse($warehouse);
        $getWarehouse2 = $manager->getWarehouse($warehouse2);
        $getWarehouse3 = $manager->getWarehouse($warehouse3);

        // THEN
        $this->assertContains($product, $getWarehouse->listInventory());
        $this->assertCount(1, $getWarehouse->listInventory());
        $this->assertCount(2, $getWarehouse2->listInventory());
        $this->assertCount(0, $getWarehouse3->listInventory());
        $this->assertContains($product2, $getWarehouse2->listInventory());
        $this->assertContains($product3, $getWarehouse2->listInventory());
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
        $manager->addProduct($product)->addProduct($product2);
        $manager->addProduct($product3);
        $this->assertContains($product, $warehouse->listInventory());
        $this->assertContains($product2, $warehouse->listInventory());
        $this->assertNotContains($product3, $warehouse->listInventory());
    }
}