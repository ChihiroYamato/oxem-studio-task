<?php

namespace Core\OXEM\Storage;

use Core\OXEM\Organic\Animal;

/**
 * Класс хранилище для экземпляров класса Animal
 *
 * @var ?Farm $instance Экземпляр класса (Singleton)
 * @var array $farm Массив зарегистрированных животных
 * @var array $products Массив произведенной продукции
 * @var array $productsArchive Массив архива произведенной продукции
 *
 * @method __construct :void
 * @method __clone :void
 * @method getInstance :Farm
 * @method registerAnimal :void Animal $animal
 * @method getAnimalsCount :string
 * @method gatherAnimalProduct :void
 * @method getProducts :string bool $isArchive
 * @method archiveProducts :void
 */
final class Farm
{
    /** Экземпляр класса (Singleton) */
    private static ?Farm $instance = null;

    /** Массив зарегистрированных животных */
    protected array $farm = [];
    /** Массив произведенной продукции */
    protected array $products = [];
    /** Массив архива произведенной продукции */
    protected array $productsArchive = [];

    /** Запрет на создание объекта */
    private function __construct()
    {

    }

    /** Запрет на клонирование объекта  */
    private function __clone()
    {

    }

    /**
     * Метод возвращает экземпляр класса (Singleton)
     * @return Farm экземпляр класса (Singleton)
     */
    public static function getInstance() : Farm
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Метод регистририрует животное во внутренний массив
     * @param Animal $animal экземпляр абстрактного класса животных
     * @return void
     */
    public function registerAnimal(Animal $animal) : void
    {
        $this->farm[get_class($animal)][] = $animal;
    }

    /**
     * Метод возвращает информацию по кол-ву животных: каждого типа и всего
     * @return string информацию по кол-ву животных в виде строки
     */
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

    /**
     * Метод собирает продукт с каждого зарегистрированного животного и записывает во внутренний массив
     * @return void
     */
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

    /**
     * Метод возвращает информацию по произведенной продукции
     * @param bool $isArchive [optional] если указан true - возвращает продукцию из архива, по умолчанию false
     * @return string информация по произведенной продукции в виде строки
     */
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

    /**
     * Метод архивирует в отдельный массив текущий массив произведенной продукции с очисткой последнего
     * @return void
     */
    public function archiveProducts() : void
    {
        foreach ($this->products as $animalClass => $product) {
            $this->productsArchive[$animalClass][microtime()] = $product;
        }

        $this->products = [];
    }
}
