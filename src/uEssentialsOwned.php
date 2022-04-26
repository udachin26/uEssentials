<?php

declare(strict_types=1);

namespace udachin26\uessentials;

use pocketmine\plugin\PluginOwned;

abstract class uEssentialsOwned implements PluginOwned{

	private uEssentials $owningPlugin;

    public function __construct(uEssentials $owningPlugin){
		$this->owningPlugin = $owningPlugin;
	}

    public function getOwningPlugin(): uEssentials{
        return $this->owningPlugin;
    }
}
