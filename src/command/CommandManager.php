<?php

declare(strict_types=1);

namespace udachin26\uessentials\command;

use udachin26\uessentials\uEssentials;
use udachin26\uessentials\uEssentialsOwned;
use udachin26\uessentials\command\home\DelhomeCommand;
use udachin26\uessentials\command\home\HomeCommand;
use udachin26\uessentials\command\home\HomesCommand;
use udachin26\uessentials\command\home\SethomeCommand;

final class CommandManager extends uEssentialsOwned{

    private const SUPPORTED_COMMANDS = [
        "delhome" => DelhomeCommand::class,
        "home" => HomeCommand::class,
        "homes" => HomesCommand::class,
        "sethome" => SethomeCommand::class
    ];

    public function __construct(uEssentials $plugin){
        parent::__construct($plugin);
        $commands = [];
        foreach(self::SUPPORTED_COMMANDS as $name => $command){
            $commands[] = new $command($plugin, $name);
        }
        $plugin->getServer()->getCommandMap()->registerAll("uessentials", $commands);
    }
}