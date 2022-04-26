<?php

declare(strict_types=1);

namespace udachin26\uessentials;

use pocketmine\plugin\PluginBase;
use udachin26\uessentials\command\CommandManager;
use udachin26\uessentials\language\LanguageManager;
use udachin26\uessentials\provider\ProviderManager;
use udachin26\uessentials\session\SessionManager;

final class uEssentials extends PluginBase{

    private static uEssentials $instance;

    private CommandManager $commandManager;
    private ProviderManager $providerManager;
    private LanguageManager $languageManager;
    private SessionManager $sessionManager;
    
    public function onEnable(): void{
        self::$instance = $this;

        $this->languageManager = new LanguageManager($this);
        $this->providerManager = new ProviderManager($this);
        $this->commandManager = new CommandManager($this); 
        $this->sessionManager = new SessionManager($this);
    }

    public static function getInstance(): uEssentials{
        return self::$instance;
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
