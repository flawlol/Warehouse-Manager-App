<?php

namespace Webdream\Warehouse\Providers;

use Webdream\Warehouse\Core\WarehouseManager;
use Webdream\Warehouse\Interface\ContainerInterface;
use Webdream\Warehouse\Interface\ManagerInterface;

class ServiceProvider
{
    public function register(ContainerInterface $container): void
    {
        $container->singleton(ManagerInterface::class, function (): WarehouseManager {
            return new WarehouseManager();
        });
    }
}