<?php

declare(strict_types=1);

namespace udachin26\bedrockessentials\provider;

abstract class Provider{

    protected string $name;

    // public function __construct(){
        
    // }

    public function getName(): string{
        return $this->name;
    }

    // abstract protected function getValue();

    // abstract protected function setValue();

    // abstract protected function close();

}