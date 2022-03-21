<?php

declare(strict_types=1);

namespace udachin26\bedrockessentials\session;

use pocketmine\player\Player;
use udachin26\bedrockessentials\BedrockEssentials;
use udachin26\bedrockessentials\BedrockEssentialsOwned;

final class SessionManager extends BedrockEssentialsOwned{

    private array $sessions = [];

    public function __construct(BedrockEssentials $plugin){
        parent::__construct($plugin);
    }

    public function getPlayerSession(Player $player): PlayerSession{
        return $this->getSession(spl_object_hash($player));
    }

    private function getSession(string $key): Session{
        return $this->sessions[$key];
    }

    private function registerSession(string $key, Session $session): void{
        $this->sessions[$key] = $session;
    }

    public function registerPlayerSession(Player $player): PlayerSession{
        $session = new PlayerSession($player);
        $this->registerSession(spl_object_hash($player), $session);

        return $session;
    }

    private function unregisterSession(string $key): void{
        unset($this->sessions[$key]);
    }

    public function unregisterPlayerSession(Player $player): void{
       $this->unregisterSession(spl_object_hash($player));
    }
}