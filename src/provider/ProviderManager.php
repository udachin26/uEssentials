<?php

declare(strict_types=1);

namespace udachin26\uessentials\provider;

use pocketmine\player\Player;
use udachin26\uessentials\uEssentials;
use udachin26\uessentials\uEssentialsOwned;
use udachin26\uessentials\session\PlayerSession;

final class ProviderManager extends uEssentialsOwned{

    public const TABLE_HOMES = 0;
    public const TABLE_WARPS = 1;

    public const TABLES = [
        self::TABLE_HOMES => "HOMES",
        self::TABLE_WARPS => "WARPS"
    ];

    private Provider $provider;

    public function __construct(uEssentials $plugin){
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

        $plugin = $this->getOwningPlugin();
        $string = $plugin->getLanguageManager()->getTranslate("INFO_DEFAULT_PROVIDER");
        $string = str_replace("{provider}", $provider->getName(), $string);
        $plugin->getLogger()->info($string);
    }

    private function setProvider(Provider $provider): void{
        $this->provider = $provider;
    }

    private function getProvider(): Provider{
        return $this->provider;
    }

    public function getHomes(string $key): array{
        return $this->get($key);
    }

    public function setHomes(array $values): void{
        $this->set($values);
    }

    public function getWarps(string $key): array{
        return $this->get($key, self::TABLES[self::TABLE_WARPS]);
    }

    public function setWarps(array $values): void{
        $this->set($values, self::TABLES[self::TABLE_WARPS]);
    }

    private function get(string $key, string $table = self::TABLES[self::TABLE_HOMES]): array{
        return $this->getProvider()->get($key, $table);
    }

    private function set(array $values, string $tableName = self::TABLES[self::TABLE_HOMES]): void{
        $this->getProvider()->set($values, $tableName);
    }
}
