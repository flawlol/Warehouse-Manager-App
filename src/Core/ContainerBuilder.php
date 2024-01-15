<?php

namespace Webdream\Warehouse\Core;

use ReflectionClass;
use ReflectionException;
use Webdream\Warehouse\Interface\ContainerInterface;

class ContainerBuilder implements ContainerInterface
{
    protected array $services = [];
    protected array $providers = [];
    private array $reflections = [];

    private function __construct()
    {

    }

    public static function getInstance(): self
    {
        static $instance;

        if ($instance === null) {
            $instance = new self();
        }

        return $instance;
    }

    public function register(string $id, $service): void
    {
        $this->services[$id] = $service;
    }

    public function get($id): object
    {
        if (isset($this->services[$id])) {
            if ($this->services[$id] instanceof \Closure) {
                return $this->services[$id]($this);
            }

            return $this->services[$id];
        }

        $item = $this->resolve($id);
        if (!($item instanceof ReflectionClass)) {
            return $item;
        }

        $instance = $this->getReflectionInstance($item);
        $this->services[$id] = $instance;
        return $instance;
    }

    private function getReflectionInstance(ReflectionClass $item)
    {
        $constructor = $item->getConstructor();
        if (is_null($constructor) || $constructor->getNumberOfRequiredParameters() == 0) {
            return $item->newInstance();
        }

        $params = [];
        foreach ($constructor->getParameters() as $param) {
            if ($type = $param->getType()) {
                $params[] = $this->get($type->getName());
            }
        }

        return $item->newInstanceArgs($params);
    }

    private function resolve($id)
    {
        try {
            if (isset($this->services[$id])) {
                $name = $this->services[$id];
                if (is_callable($name)) {
                    return $name();
                }
            } else {
                $name = $id;
            }

            if (isset($this->reflections[$name])) {
                return $this->reflections[$name];
            }

            $reflection = new ReflectionClass($name);
            $this->reflections[$name] = $reflection; // Cache the reflection class

            return $reflection;
        } catch (ReflectionException $e) {
           // throw new NotFoundException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function has($id): bool
    {
        return isset($this->services[$id]);
    }

    public function registerServiceProviders(array $providers): void
    {
        foreach ($providers as $provider)
        {
            if ($this->isAlreadyRegisteredProvider($provider)) {
                continue;
            }

            $provider->register($this);
            $this->providers[] = $provider;
        }
    }

    public function singleton(string $id, $service): void
    {
        $this->services[$id] = function () use ($service, $id) {
            static $instance;

            if ($instance === null) {
                $instance = $service;
            }

            return $instance($this);
        };
    }

    public function getRegisteredProviders(): array
    {
        return $this->providers;
    }

    public function getNamespace(): string
    {
        return __NAMESPACE__;
    }

    public function isAlreadyRegisteredProvider($class)
    {
        foreach ($this->providers as $provider)
        {
            if ($provider instanceof $class) {
                return true;
            }
        }
    }
}