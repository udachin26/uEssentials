<?php

declare(strict_types=1);

namespace udachin26\bedrockessentials\provider;

use poggit\libasynql\DataConnector;
use poggit\libasynql\libasynql;
use udachin26\bedrockessentials\BedrockEssentials;

final class SqliteProvider extends Provider{

    public const INIT_PLAYERS = "bedrockessentials.init_players";
    public const GET_PLAYERS = "bedrockessentials.get_players";
    public const GET_PLAYER = "bedrockessentials.get_player";
    public const ADD_PLAYER = "bedrockessentials.add_player";
    public const REMOVE_PLAYER = "bedrockessentials.remove_player";
    //update - save

    protected string $name = "SQLite";
    private DataConnector $database;

    public function __construct(BedrockEssentials $plugin){
        $this->database = libasynql::create($plugin, $plugin->getConfig()->get("database"), ["sqlite" => "sqlite.sql"]);

		$this->database->executeGeneric(self::INIT_PLAYERS);
        $this->database->waitAll();
    }

    public function close(): void{
        $this->database->close();
    }

    public function get(string $key): array{
        $return = [];
        $this->database->executeSelect(self::GET_PLAYER, ["name" => $key], function(array $data) use(&$return): void{
            $return = $data;
        }); 
        $this->database->waitAll();

        return $return;
    }

    public function getAll(): array{
        $return = [];
        $this->database->executeSelect(self::GET_PLAYERS, [], function(array $data) use(&$return): void{
            $return = $data;
        });
        $this->database->waitAll(); //временный костыль
        
        return $return;
    }

    public function set(array $values): void{
        $this->database->executeInsert(self::ADD_PLAYER, [
			"name" => $values[0],
			"homes" => $values[1]
		]);
    }

    public function remove(string $key): void{
        $this->connector->executeInsert(self::REMOVE_PLAYER, ["name" => $key]);
    }
}