<?php

declare(strict_types=1);

namespace udachin26\uessentials\listener;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use udachin26\uessentials\uEssentials;
use udachin26\uessentials\uEssentialsOwned;

final class SessionListener extends uEssentialsOwned implements Listener{

    public function __construct(uEssentials $plugin){
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