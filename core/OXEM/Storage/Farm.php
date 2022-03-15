<?php

namespace Core\OXEM\Storage;

use Core\OXEM\Organic\Animal;

final class Farm
{
    private static ?Farm $instance = null;

    protected array $farm = [];
    protected array $products = [];
    protected array $productsArchive = [];

    private function __construct()
    {

    }

    private function __clone()
    {

    }

    public static function getInstance() : Farm
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function registerAnimal(Animal $animal) : void
    {
        $this->farm[get_class($animal)][] = $animal;
    }

    public function getAnimalsCount() : string
    {
        $animalsCount = 0;
        $returnString = 'На ферме зарегистрировано:';

        foreach ($this->farm as $animalClass => $animals) {
            $count = count($animals);
            $animalsCount += $count;
            $returnString .= ' ' . $count . ' ' . basename($animalClass) . ',';
        }

        $returnString = preg_replace('/,$/', ".\n", $returnString);
        $returnString .= 'Всего: ' . $animalsCount . " животных\n";

        return $returnString;
    }

    public function gatherAnimalProduct() : void
    {
        foreach ($this->farm as $animalClass => $animals) {
            foreach ($animals as $animal) {
                if (isset($this->products[$animalClass])) {
                    $this->products[$animalClass] += $animal->produce();
                } else {
                    $this->products[$animalClass] = $animal->produce();
                }
            }
        }
    }

    public function getProducts(bool $isArchive = false) : string
    {
        $products = $isArchive ? $this->productsArchive : $this->products;
        if (empty($products)) {
            return "Нет данных о сборе продукции\n";
        }

        $returnString = ($isArchive ? 'Всего с' : 'C') . 'обрано:';

        foreach ($products as $animalClass => $product) {
            $product = $isArchive ? array_sum($product) : $product;
            $returnString .= ' ' . $product . ' ' . $animalClass::getProductName($product) . ',';
        }

        return preg_replace('/,$/', ".\n", $returnString);
    }

    public function archiveProducts() : void
    {
        foreach ($this->products as $animalClass => $product) {
            $this->productsArchive[$animalClass][microtime()] = $product;
        }

        $this->products = [];
    }
}
