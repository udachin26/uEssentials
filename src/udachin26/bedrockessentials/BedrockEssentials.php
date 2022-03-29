<?php

declare(strict_types=1);

namespace udachin26\bedrockessentials;

use pocketmine\plugin\PluginBase;
use udachin26\bedrockessentials\command\CommandManager;
use udachin26\bedrockessentials\language\LanguageManager;
use udachin26\bedrockessentials\listener\SessionListener;
use udachin26\bedrockessentials\provider\ProviderManager;
use udachin26\bedrockessentials\session\SessionManager;

final class BedrockEssentials extends PluginBase{

    private ProviderManager $providerManager;
    private CommandManager $commandManager;
    private SessionManager $sessionManager;
    private LanguageManager $languageManager;
    

    public function onEnable(): void{
        $this->providerManager = new ProviderManager($this);
        $this->commandManager = new CommandManager($this);   
        $this->sessionManager = new SessionManager($this);
        $this->languageManager = new LanguageManager($this);

        $this->getServer()->getPluginManager()->registerEvents(new SessionListener($this), $this);
    }
    
    public function getCommandManager(): CommandManager{
        return $this->commandManager;
    }

    public function getProviderManager(): ProviderManager{
        return $this->providerManager;
    }

    public function getSessionManager(): SessionManager{
        return $this->sessionManager;
    }

    public function getLanguageManager(): LanguageManager{
        return $this->languageManager;
    }
}
