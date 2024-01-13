<?php

namespace Webdream\Warehouse\Interface;

interface FactoryInterface
{
    public function create(): FactoryCreatable;
}