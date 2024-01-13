<?php

namespace Webdream\Warehouse\Interface;

interface ContainerInterface
{
    public static function getInstance(): self;
    public function register(string $id, $service): void;
    public function get($id): object;
    public function has($id): bool;
    public function registerServiceProviders(array $providers): void;
    public function singleton(string $id, $service): void;
    public function getRegisteredProviders(): array;
    public function getNamespace(): string;
    public function isAlreadyRegisteredProvider($class);
}