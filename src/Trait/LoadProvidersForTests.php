<?php

namespace Webdream\Warehouse\Trait;

use Webdream\Warehouse\Providers\ServiceProvider;

trait LoadProvidersForTests
{
    protected function registerProviders(): void
    {
        $provider = new ServiceProvider();
        $provider->register(container());
    }
}