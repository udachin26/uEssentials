<?php

declare(strict_types=1);

namespace udachin26\bedrockessentials;

use pocketmine\plugin\PluginBase;
use udachin26\bedrockessentials\command\CommandManager;
use udachin26\bedrockessentials\language\LanguageManager;
use udachin26\bedrockessentials\provider\ProviderManager;
use udachin26\bedrockessentials\session\SessionManager;

final class BedrockEssentials extends PluginBase{

    private CommandManager $commandManager;
    private ProviderManager $providerManager;
    private LanguageManager $languageManager;
    private SessionManager $sessionManager;
    
    public function onEnable(): void{
        $this->languageManager = new LanguageManager($this);
        $this->providerManager = new ProviderManager($this);
        $this->commandManager = new CommandManager($this); 
        $this->sessionManager = new SessionManager($this);
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
