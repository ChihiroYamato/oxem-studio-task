<?php

namespace Core\OXEM\Organic;

class Chicken extends Animal
{
    public function produce(): int
    {
        return rand(0, 1);
    }

    public static function getProductName(int $count) : string
    {
        $modificator = self::getNameModificator($count);

        return match ($modificator) {
            0 => 'яиц',
            1 => 'яйцо',
            2 => 'яйца',
        };
    }
}
