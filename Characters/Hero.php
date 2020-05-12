<?php


require_once 'Characters/Character.php';
class Hero extends Character
{

    public function rapidStrike()
    {
        if ($this->name == 'Stanhope') {
            //check for chance to rapid strike
            $chance = rand(0, 99);
            if ($chance < 10) {
                //rapid strike happens
                return true;
            }
            return false;
        }
    }
    //Stanhope's special ability
    public function magicShield()
    {
        if ($this->name == 'Stanhope') {
            $chance = rand(0, 99);
            if ($chance < 20) {
                return true;
            }
            return false;
        }
    }

    //Stanhope's special ability
    public function defend($attack)
    {
        if (!$this->magicShield()) {
           return parent::defend($attack);
        } else {
            $normalDamage = $attack - $this->defense;
            $damage = $normalDamage / 2;
            if ($damage > 0) {
                $this->health -= $damage;
            }
            echo '<div class="alert alert-warning" role="alert">
                    Stanhope used MAGIC SHIELD!(whitout shield '.$normalDamage.' damage)<br>
                  </div>';
            return $damage;
        }
    }

    public function attack()
    {
        if (!$this->rapidStrike()) {
            return parent::attack();
        } else {
            echo '<div class="alert alert-warning" role="alert">
                    Stanhope used RAPID ATTACK!<br>
                  </div>';
            return [parent::attack(), 'crit'];
        }
    }

}
