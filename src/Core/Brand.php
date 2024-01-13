<?php

namespace Webdream\Warehouse\Core;

use Webdream\Warehouse\Interface\FactoryCreatable;

readonly class Brand implements FactoryCreatable
{
    public function __construct(private string $name, private int $qualityRating)
    {

    }
}