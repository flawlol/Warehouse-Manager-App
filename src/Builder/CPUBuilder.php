<?php

namespace Webdream\Warehouse\Builder;

use Webdream\Warehouse\Abstract\AbstractBuilder;
use Webdream\Warehouse\Item\CPU;

class CPUBuilder extends AbstractBuilder
{
    private int $warrantyPeriod;

    public function getWarrantyPeriod(): int
    {
        return $this->warrantyPeriod;
    }

    public function setWarrantyPeriod(int $warrantyPeriod): self
    {
        $this->warrantyPeriod = $warrantyPeriod;

        return $this;
    }

    public function build(): CPU
    {
        return new CPU($this->getSku(), $this->getName(), $this->getPrice(), $this->getBrand(), $this->getWarrantyPeriod());
    }
}