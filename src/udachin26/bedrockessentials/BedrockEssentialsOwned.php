<?php

declare(strict_types=1);

namespace udachin26\bedrockessentials;

use pocketmine\plugin\PluginOwned;

abstract class BedrockEssentialsOwned implements PluginOwned{

	private BedrockEssentials $owningPlugin;

    public function __construct(BedrockEssentials $owningPlugin){
		$this->owningPlugin = $owningPlugin;
	}

    public function getOwningPlugin(): BedrockEssentials{
        return $this->owningPlugin;
    }
}
