<?php

declare(strict_types=1);

namespace udachin26\uessentials\session;

use pocketmine\math\Vector3;
use pocketmine\player\Player;
use udachin26\uessentials\uEssentials;
use udachin26\uessentials\language\LanguageManager;

final class PlayerSession extends Session{

    private string $langSupported = LanguageManager::DEFAULT_LANGUAGE;
    private Player $player;

    public function __construct(Player $player){
        $this->player = $player;

        //убрать тут говно

        //сделать првоерку из конфига включена ли поддержка Locale языка 
        $locale = $player->getLocale();
        //сделать проверку изменились данные из бд и вообще если он есть в бд
        if(in_array($locale, LanguageManager::SUPPORTED_LANGUAGES)){
            $this->langSupported = $locale;
        }
        //получать из бд данные о языка, а пока так

        //сделать проверку и установку на данных из провайдера
    }

    public function close(): void{

    }

    private function save(): void{

    }

    public function getPlayer(): Player{
        return $this->player;
    }

    public function setHome(string $name){
        uEssentials::getInstance()->getProviderManager()->setHomes();
    }

    public function getHomes(): array{
        return  uEssentials::getInstance()->getProviderManager()->getHomes($this->player->getName());
    }

    public function getHome(string $name): ?Vector3{
        return null;
    }

    public function removeHome(string $name): void{

    }

    public function existsHome(string $name): bool{
        return true;// проверку сразу из базы
    }
}