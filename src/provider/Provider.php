<?php

declare(strict_types=1);

namespace udachin26\uessentials\provider;

abstract class Provider{

    protected string $name;

    public function getName(): string{
        return $this->name;
    }

    abstract public function close(): void;

    abstract public function get(string $key, string $tableName): array;

    abstract public function set(array $values, string $tableName): void;

}