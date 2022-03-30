<?php

declare(strict_types=1);

namespace udachin26\bedrockessentials\provider;

abstract class Provider{

    protected string $name;

    public function getName(): string{
        return $this->name;
    }

    abstract public function close(): void;

}