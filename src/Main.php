<?php

declare(strict_types=1);

namespace lubro0\SpawnAtLobby;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\math\Vector3;
use pocketmine\world\Position;

class Main extends PluginBase implements Listener{

    public function onEnable(): void{
        $this->saveDefaultConfig();
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onJoin(PlayerJoinEvent $event): void{
        $player = $event->getPlayer();

        $worldName = $this->getConfig()->get("world", "lobby");
        $positionString = $this->getConfig()->get("position", "0 0 0");

        if ($worldName === "world" && $positionString === "0 0 0") {
            return;
        }

        $positionArray = explode(" ", $positionString);

        if (count($positionArray) === 3) {
            $x = (float) $positionArray[0];
            $y = (float) $positionArray[1];
            $z = (float) $positionArray[2];

            $world = $this->getServer()->getWorldManager()->getWorldByName($worldName);
            if ($world !== null) {
                $player->teleport(new Position($x, $y, $z, $world));
            }
        }
    }
}
