<?php

declare(strict_types=1);

namespace udachin26\uessentials\command;

use CortexPE\Commando\BaseCommand as CommandoCommand;
use pocketmine\permission\DefaultPermissions;
use pocketmine\permission\Permission;
use pocketmine\permission\PermissionManager;
use pocketmine\permission\PermissionParser;
use pocketmine\player\Player;
use udachin26\uessentials\uEssentials;
use udachin26\uessentials\session\PlayerSession;

abstract class BaseCommand extends CommandoCommand{

    public const ERR_COMMAND_ONLY_PLAYER = 0x05;
    public const ERR_PERMISSION_SET = 0x06;

    protected array $errorMessages = [
        self::ERR_INVALID_ARG_VALUE => "ERR_INVALID_ARG_VALUE",
		self::ERR_TOO_MANY_ARGUMENTS => "ERR_TOO_MANY_ARGUMENTS",
		self::ERR_INSUFFICIENT_ARGUMENTS => "ERR_INSUFFICIENT_ARGUMENTS",
		self::ERR_NO_ARGUMENTS => "ERR_NO_ARGUMENTS",
        self::ERR_COMMAND_ONLY_PLAYER => "ERR_COMMAND_ONLY_PLAYER",
        self::ERR_PERMISSION_SET => "ERR_PERMISSION_SET"
	];

    public function __construct(uEssentials $plugin, string $name){
        parent::__construct($plugin, $name);

        $string = "COMMAND_DESCRIPTION_" . strtoupper($this->getName());
        $langManager = $this->getOwningPlugin()->getLanguageManager();
        $string =  $langManager->getTranslate($string);
        $this->setDescription($string);

        $permission = $this->getOwningPlugin()->getConfig()->getNested("commands.".$this->getName().".permission");
        $string = $langManager->getTranslate("COMMAND_PERMISSION_" . strtoupper($this->getName()));
        $default = $permission["default"];
        $permission = new Permission($permission["name"], $string);

        $permManager = PermissionManager::getInstance();
        if($permManager->getPermission($permission->getName()) !== null){
            $string = $langManager->getTranslate($this->errorMessages[self::ERR_PERMISSION_SET]);
            $string = str_replace(["{permission}", "{command}"], [$permission->getName(), $this->getName()], $string);
            $plugin->getLogger()->error($string);
            return;
        }
        
        $opPerm = $permManager->getPermission(DefaultPermissions::ROOT_OPERATOR);
        $userPerm = $permManager->getPermission(DefaultPermissions::ROOT_USER);
        $permManager->addPermission($permission);
        switch($default){
            case PermissionParser::DEFAULT_TRUE:
                $userPerm->addChild($permission->getName(), true);
                break;
            case PermissionParser::DEFAULT_OP:
                $opPerm->addChild($permission->getName(), true);
                break;
            case PermissionParser::DEFAULT_NOT_OP:
                $userPerm->addChild($permission->getName(), true);
				$opPerm->addChild($permission->getName(), false);
                break;
            default:
                break;
        }
        $this->setPermission($permission->getName());
    }

    public function getOwningPlugin(): uEssentials{
        return parent::getOwningPlugin();
    }

    public function sendUsage(): void{
        $langManager = $this->getOwningPlugin()->getLanguageManager();
        $langCode = $langManager->getDefaultLang();

        if($langManager->getLocaleMode()){
            $langCode = $this->currentSender->getLanguage()->getLang();
            $langCode =  $langManager->convertLang($langCode);
        }

        $string = $langManager->getTranslate("COMMAND_USAGE", $langCode);
        $this->currentSender->sendMessage($string . $this->getUsage());
    }

    public function sendError(int $errorCode, array $args = []): void{
        $langManager = $this->getOwningPlugin()->getLanguageManager();
        $langCode = $langManager->getDefaultLang();

        if($langManager->getLocaleMode()){
            $langCode = $this->currentSender->getLanguage()->getLang();
            $langCode =  $langManager->convertLang($langCode);
        }

        $string = $this->errorMessages[$errorCode];
        $string = $langManager->getTranslate($string, $langCode);

		foreach($args as $item => $value) {
			$string = str_replace("{{$item}}", (string)$value, $string);
		}
        $this->currentSender->sendMessage($string);
    }

    public function getDescription(): string{
        $langManager = $this->getOwningPlugin()->getLanguageManager();

        $string = parent::getDescription();
        if($langManager->getLocaleMode() and isset($this->currentSender)){
            $langCode = $this->currentSender->getLanguage()->getLang();
            $langCode =  $langManager->convertLang($langCode);

            $string = "COMMAND_DESCRIPTION_" . strtoupper($this->getName());
            $string = $langManager->getTranslate($string, $langCode);
        }

        return $string;
    }

    public function getPlayerSession(Player $player): PlayerSession{
        $manager = $this->getOwningPlugin()->getSessionManager();
        $session = $manager->getPlayerSession($player);

        if(!isset($session)){
            $session = $manager->registerPlayerSession($player);
        }
        
        return $session;
    }
}