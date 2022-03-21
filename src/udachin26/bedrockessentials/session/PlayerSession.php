<?php

declare(strict_types=1);

namespace udachin26\bedrockessentials\session;

use pocketmine\math\Vector3;
use pocketmine\player\Player;

final class PlayerSession extends Session{

    private $lang; //todo: сделать константы в пространстве языка с языками чтобы можно было цифры использовать
    private Player $player;

    public function __construct(Player $player){
        $this->player = $player;

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

    }

    public function getHomes(): array{
        return [];
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