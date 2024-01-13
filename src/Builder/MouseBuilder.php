<?php

namespace Webdream\Warehouse\Builder;

use Webdream\Warehouse\Abstract\AbstractBuilder;
use Webdream\Warehouse\Item\Mouse;

class MouseBuilder extends AbstractBuilder
{
    private int $dpi;

    public function getDpi(): int
    {
        return $this->dpi;
    }

    public function setDpi(int $dpi): self
    {
        $this->dpi = $dpi;

        return $this;
    }

    public function build(): Mouse
    {
        return new Mouse($this->getSku(), $this->getName(), $this->getPrice(), $this->getBrand(), $this->getDpi());
    }
}