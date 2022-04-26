<?php

declare(strict_types=1);

namespace udachin26\uessentials\provider;

use poggit\libasynql\DataConnector;
use poggit\libasynql\libasynql;
use ReflectionClassConstant;
use udachin26\uessentials\uEssentials;

final class SqliteProvider extends Provider{

    public const INIT_HOMES = "uessentials.init_homes";
    public const GET_HOMES = "uessentials.get_homes";
    public const GETALL_HOMES = "uessentials.getall_homes";
    public const ADD_HOMES = "uessentials.add_homes";
    public const REMOVE_HOMES = "uessentials.remove_homes";

    //warps..

    protected string $name = "SQLite";
    private DataConnector $database;

    public function __construct(uEssentials $plugin){
        $this->database = libasynql::create($plugin, $plugin->getConfig()->get("database"), ["sqlite" => "sqlite.sql"]);

		$this->database->executeGeneric(self::INIT_HOMES);
        $this->database->waitAll();
    }

    public function close(): void{
        $this->database->close();
    }

    public function get(string $key, string $tableName): array{
        $table = (new \ReflectionClass(self::class))->getConstant("GET_" . $tableName);

        $return = [];
        if(!$table){
            return $return;
        }

        $this->database->executeSelect($table, ["name" => $key], function(array $data) use(&$return): void{
            $return = $data;
        }); 
        $this->database->waitAll();

        return $return;
    }

    public function getAll(string $tableName): array{
        $tableName = (new \ReflectionClass(self::class))->getConstant("GETALL_" . $tableName);

        $return = [];
        if(!$tableName){
            return $return;
        }

        $this->database->executeSelect($tableName, [], function(array $data) use(&$return): void{
            $return = $data;
        });
        $this->database->waitAll();
        
        return $return;
    }

    public function set(array $values, string $tableName): void{
        $tableName = (new \ReflectionClass(self::class))->getConstant("ADD_" . $tableName);

        $this->database->executeInsert($tableName, [
			"name" => $values[0],
			"homes" => $values[1]
		]);
    }

    public function remove(string $key, string $tableName): void{
        $tableName = (new \ReflectionClass(self::class))->getConstant("REMOVE_" . $tableName);

        $this->database->executeInsert($tableName, ["name" => $key]);
    }
}