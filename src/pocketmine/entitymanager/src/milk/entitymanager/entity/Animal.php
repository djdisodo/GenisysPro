<?php

namespace milk\entitymanager\entity;

use pocketmine\entity\Ageable;
use pocketmine\math\Vector3;
use pocketmine\Player;

abstract class Animal extends WalkEntity implements Ageable{

    private $entityTick = 0;

    protected $speed = 0.7;

    public function initEntity(){
        $this->setDataProperty(self::DATA_FLAGS, self::DATA_FLAG_BABY, false);
        parent::initEntity();
    }

    public function isBaby(){
        return $this->getDataFlag(self::DATA_FLAGS, self::DATA_FLAG_BABY);
    }

    public function updateTick(){
        if(!$this->isAlive()){
            if(++$this->deadTicks >= 23) $this->close();
            return;
        }

        --$this->moveTime;
        $target = $this->updateMove();
        if($target instanceof Player){
            if($this->distance($target) <= 2){
                $this->pitch = 22;
                $this->x = $this->lastX;
                $this->y = $this->lastY;
                $this->z = $this->lastZ;
            }
        }elseif($target instanceof Vector3){
            if($this->distance($target) <= 1) $this->moveTime = 0;
        }
        if($this->entityTick++ >= 5){
            $this->entityTick = 0;
            $this->entityBaseTick(5);
        }
    }

}
