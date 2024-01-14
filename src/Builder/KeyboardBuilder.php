<?php

namespace Webdream\Warehouse\Builder;

use Webdream\Warehouse\Abstract\AbstractBuilder;
use Webdream\Warehouse\Item\Keyboard;

class KeyboardBuilder extends AbstractBuilder
{
    private bool $isMechanical;

    public function getIsMechanical(): bool
    {
        return $this->isMechanical;
    }

    public function setIsMechanical(bool $isMechanical): self
    {
        $this->isMechanical = $isMechanical;

        return $this;
    }

    public function build(): Keyboard
    {
        return new Keyboard($this->getSku(), $this->getName(), $this->getPrice(), $this->getBrand(), $this->getIsMechanical());
    }
}