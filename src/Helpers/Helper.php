<?php

use Webdream\Warehouse\Core\ContainerBuilder;
use Webdream\Warehouse\Interface\ContainerInterface;

function container(): ContainerInterface
{
    return ContainerBuilder::getInstance();
}