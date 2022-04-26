<?php

declare(strict_types=1);

namespace udachin26\uessentials\language;

use pocketmine\utils\Config;
use udachin26\uessentials\uEssentials;
use udachin26\uessentials\uEssentialsOwned;

final class LanguageManager extends uEssentialsOwned{

    public const DEFAULT_LANGUAGE = "en_US";
    public const SUPPORTED_LANGUAGES = [
        "en_US",
        "ru_RU"
    ];

    private string $defaultLang = self::DEFAULT_LANGUAGE;
    private bool $localeMode = false; 
    private array $languages = [];
    
    public function __construct(uEssentials $plugin){
        parent::__construct($plugin);

        foreach(self::SUPPORTED_LANGUAGES as $langCode){
            $file = "languages". DIRECTORY_SEPARATOR . $langCode . ".yml";
            $plugin->saveResource($file, false);
            $this->languages[$langCode] = new Config($plugin->getDataFolder() . $file, Config::YAML);
        }

        $configLang = $plugin->getConfig()->getNested("language.default", $this->defaultLang);
        if(in_array($configLang, self::SUPPORTED_LANGUAGES)){
            $this->defaultLang = $configLang;
        }
        
        $configLocale =  $plugin->getConfig()->getNested("language.locale", false);
        if($configLocale == true){
            $this->localeMode = true;
        }

        $string = $this->getTranslate("INFO_DEFAULT_LANGUAGE", $this->defaultLang);
        $string = str_replace("{language}",  $this->defaultLang, $string);
        $plugin->getLogger()->info($string);
    }

    public function getDefaultLang(): string{
        return $this->defaultLang;
    }

    public function getLocaleMode(): bool{
        return $this->localeMode;
    }

    public function convertLang(string $langCode): string{
        switch($langCode){
            case "rus":
                $langCode = "ru_RU";
                break;
            case "eng":
                $langCode = "en_US";
                break;
            default:
                $langCode = $this->defaultLang;
                break;
        }

        return $langCode;
    }

    public function getTranslate(string $key, string $langCode = "default"): bool|string{
        if($langCode == "default"){
            $langCode =  $this->defaultLang;
        }

        $config = $this->languages[$langCode];
        $out = false;
        if($config instanceof Config){
            $out = $config->get($key);
        }

        return $out;
    }

}