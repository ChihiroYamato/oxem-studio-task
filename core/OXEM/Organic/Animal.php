<?php

namespace Core\OXEM\Organic;

abstract class Animal
{
    abstract public function produce() : int;

    abstract static public function getProductName(int $count) : string;

    final static protected function getNameModificator(int $count) : int
    {
        $mod10 = $count % 10;
        $mod100 = $count % 100;

        return match (true) {
            $mod10 === 0, $mod100 >= 5 && $mod100 <= 20, $mod10 >= 5 && $mod10 <= 10 => 0,
            $mod10 === 1 => 1,
            $mod10 >= 2 && $mod10 <= 4 => 2,
        };
    }
}
