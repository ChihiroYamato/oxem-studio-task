<?php

namespace Core\OXEM\Organic;

/**
 * Абстрактный класс для сущностей животных
 *
 * @method produce :int
 * @method getProductName :string int $count
 * @method getNameModificator :string int $count
 */
abstract class Animal
{
    /**
     * Метод возвращает произведеное за раз кол-во продуктов
     * @return int кол-во продуктов
     */
    abstract public function produce() : int;

    /**
     * Метод озвращает корректное название единиц произведенной продукции в зависимости от кол-ва продукции
     * @param int $count кол-во продукции
     * @return string корректное название единиц произведенной продукции
     */
    abstract static public function getProductName(int $count) : string;

    /**
     * Метод возвращает модификатор, в соответствии с которым нужно склонять название единиц произведенной продукции
     * @param int $count кол-во продукции
     * @return int числовой модификатор
     */
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
