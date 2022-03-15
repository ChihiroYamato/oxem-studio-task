<?php

require_once __DIR__ . '/core/autoload/autoload.php';

use Core\OXEM\Organic\Chicken;
use Core\OXEM\Organic\Cow;
use Core\OXEM\Storage\Farm;

$farm = Farm::getInstance();

for ($i = 0; $i < 20; $i++) {
    $farm->registerAnimal(new Chicken());
}

for ($i = 0; $i < 10; $i++) {
    $farm->registerAnimal(new Cow());
}

echo $farm->getAnimalsCount();

for ($i = 0; $i < 7; $i++) {
    $farm->gatherAnimalProduct();
}

echo $farm->getProducts();
$farm->archiveProducts();

echo "\n**Съездили на рынок**\n\n";

for ($i = 0; $i < 5; $i++) {
    $farm->registerAnimal(new Chicken());
}

$farm->registerAnimal(new Cow());

echo $farm->getAnimalsCount();

for ($i = 0; $i < 7; $i++) {
    $farm->gatherAnimalProduct();
}

echo $farm->getProducts();
$farm->archiveProducts();
echo $farm->getProducts(true);
