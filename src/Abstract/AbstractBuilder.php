<?php

namespace Webdream\Warehouse\Abstract;

use Webdream\Warehouse\Core\Brand;
use Webdream\Warehouse\Core\Product;

abstract class AbstractBuilder
{
    private string $sku;
    private string $name;
    private int $price;
    private Brand $brand;

    protected function getSku(): string
    {
        return $this->sku;
    }

    protected function getName(): string
    {
        return $this->name;
    }

    protected function getPrice(): int
    {
        return $this->price;
    }

    protected function getBrand(): Brand
    {
        return $this->brand;
    }

    public function setBrand(Brand $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setSku(string $sku): self
    {
        $this->sku = $sku;

        return $this;
    }

    abstract protected function build(): Product;
}