<?php

namespace Core\OXEM\Organic;

class Cow extends Animal
{
    public function produce(): int
    {
        return rand(8, 12);
    }

    public static function getProductName(int $count) : string
    {
        $modificator = self::getNameModificator($count);

        return match ($modificator) {
            0 => 'литров молока',
            1 => 'литр молока',
            2 => 'литра молока',
        };
    }
}
