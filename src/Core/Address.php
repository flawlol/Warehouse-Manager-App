<?php

namespace Webdream\Warehouse\Core;

use Webdream\Warehouse\Interface\FactoryCreatable;

readonly class Address implements FactoryCreatable
{
    public function __construct(private string $zip, private string $city, private string $address)
    {

    }
}