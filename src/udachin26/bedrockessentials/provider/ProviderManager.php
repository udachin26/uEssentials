<?php

declare(strict_types=1);

namespace udachin26\bedrockessentials\provider;

use pocketmine\player\Player;
use udachin26\bedrockessentials\BedrockEssentials;
use udachin26\bedrockessentials\BedrockEssentialsOwned;
use udachin26\bedrockessentials\session\PlayerSession;

final class ProviderManager extends BedrockEssentialsOwned{

    private Provider $provider;

    public function __construct(BedrockEssentials $plugin){
        parent::__construct($plugin);

        $type = $this->getOwningPlugin()->getConfig()->getNested("database.type");
        switch($type){
            case ProviderType::PROVIDER_TYPE_SQLITE:
            default:
                $this->setSqliteProvider();
                break;
        }
    }

    private function setSqliteProvider(): void{
        $provider = new SqliteProvider($this->getOwningPlugin());
        $this->setProvider($provider);
        $this->getOwningPlugin()->getLogger()->info($provider->getName() . " is database"); //todo: lang config
    }

    private function setProvider(Provider $provider): void{
        $this->provider = $provider;
    }

    private function getProvider(): Provider{
        return $this->provider;
    }

    public function registerPlayer(Player|PlayerSession $key){

    }
}
