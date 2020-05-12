<?php




class Character
{
    protected $health, $strength, $defense, $speed, $luck, $name;

    public function __construct($name, $healthMin, $healthMax, $strengthMin, $strengthMax, $defenseMin, $defenseMax, $speedMin, $speedMax, $luckMin, $luckMax)
    {
        $this->health = rand($healthMin, $healthMax);
        $this->strength = rand($strengthMin, $strengthMax);
        $this->defense = rand($defenseMin, $defenseMax);
        $this->speed = rand($speedMin, $speedMax);
        $this->luck = rand($luckMin, $luckMax);
        $this->name = $name;
    }

    public function hasLuckThisTurn()
    {
        $chance = rand(0, 99);
        if ($chance < $this->luck) {
            return true;
        }
        return false;
    }

    public function getSpeed()
    {
        return $this->speed;
    }
    public function getLuck()
    {
        return $this->luck;
    }

    public function attack()
    {
        return $this->strength;
    }

    public function defend($attack)
    {
        $damage = $attack - $this->defense;
        if ($damage > 0) {
            $this->health -= $damage;
        }
        return$damage;
    }

    public function checkHealth(){
        return $this->health;
    }
}
