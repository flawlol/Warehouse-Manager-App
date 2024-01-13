<?php

namespace Webdream\Warehouse\Core;

use Webdream\Warehouse\Interface\FactoryCreatable;

class Warehouse implements FactoryCreatable
{
    public function __construct(
        private readonly string $name,
        private readonly Address $address,
        private readonly int $capacity,
        private array $inventory = []
    )
    {

    }

    public function getCapacity(): int
    {
        return $this->capacity;
    }

    public function countInventory(): int
    {
        return count($this->inventory);
    }

    public function addProduct(Product $product): void
    {
        if ($this->hasCapacity()) {
            $this->inventory[] = $product;
        }
    }

    public function hasCapacity(): bool
    {
        return count($this->inventory) < $this->capacity;
    }

    public function listInventory(): array
    {
        return $this->inventory;
    }

    public function hasItem(Product $product): bool
    {
        return in_array($product, $this->inventory, true);
    }

    public function removeProductFromInventory(Product $product): void
    {
        $filter = array_filter($this->inventory, function ($item) use ($product) {
            return $item !== $product;
        });

        $this->inventory = $filter;
    }
}