<?php

declare(strict_types=1);

namespace udachin26\bedrockessentials\command;

use udachin26\bedrockessentials\BedrockEssentials;
use udachin26\bedrockessentials\BedrockEssentialsOwned;
use udachin26\bedrockessentials\command\home\DelhomeCommand;
use udachin26\bedrockessentials\command\home\HomeCommand;
use udachin26\bedrockessentials\command\home\HomesCommand;
use udachin26\bedrockessentials\command\home\SethomeCommand;

final class CommandManager extends BedrockEssentialsOwned{

    private const SUPPORTED_COMMANDS = [
        "delhome" => DelhomeCommand::class,
        "home" => HomeCommand::class,
        "homes" => HomesCommand::class,
        "sethome" => SethomeCommand::class
    ];

    public function __construct(BedrockEssentials $plugin){
        parent::__construct($plugin);
        $commands = [];
        foreach(self::SUPPORTED_COMMANDS as $name => $command){
            $commands[] = new $command($plugin, $name);
        }
        $plugin->getServer()->getCommandMap()->registerAll("bedrockessentials", $commands);
    }
}