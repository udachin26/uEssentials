<?php

declare(strict_types=1);

namespace udachin26\bedrockessentials\listener;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use udachin26\bedrockessentials\BedrockEssentials;
use udachin26\bedrockessentials\BedrockEssentialsOwned;

final class SessionListener extends BedrockEssentialsOwned implements Listener{

    public function __construct(BedrockEssentials $plugin){
        parent::__construct($plugin);
    }

    public function onPlayerJoin(PlayerJoinEvent $event){
        $player = $event->getPlayer();
        $this->getOwningPlugin()->getSessionManager()->registerPlayerSession($player);
    }

    public function onPlayerQuit(PlayerQuitEvent $event){
        $player = $event->getPlayer();
        $this->getOwningPlugin()->getSessionManager()->unregisterPlayerSession($player);
    }
}