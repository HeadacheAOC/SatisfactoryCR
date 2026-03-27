<?php
use Kemenyende\FactoryGame\Factory;


$multiplier = 480/13.5;

$factory = new Factory('Alternate: Compacted Coal');
$factory->addRecipeForProduce____('Miner Mk.1: Coal', 'Coal', 6*$multiplier);
$factory->addRecipeForProduce____('Miner Mk.1: Sulfur', 'Sulfur', 6*$multiplier);
$factory->addRecipeForProduce____('Alternate: Compacted Coal', 'Compacted Coal', 6*$multiplier);
$factory->show();

$surplus = $factory->calcSurplus();
$factory = new Factory('Turbofuel Power');
$factory->addSupplies($surplus);
$factory->addRecipeForProduce____('Oil Extractor: Crude Oil', 'Crude Oil', 13500*$multiplier);
$factory->addRecipeForProduce2___('Fuel', 9000*$multiplier);
$factory->addRecipeForProduce2___('Turbofuel', 7500*$multiplier);
$factory->addRecipeByDisplayName_('Turbofuel Power', 1*$multiplier);
$factory->show();


$surplus = $factory->calcSurplus();
$factory = new Factory('Residual Polymer Resin');
$factory->addSupplies($surplus);
$factory->addRecipeForProduce____('Alternate: Polyester Fabric', 'Fabric', 1.125*$multiplier);
$factory->addRecipeForProduce____('Residual Plastic', 'Plastic', 0 + (1.125*$multiplier));
$factory->addRecipeForProduce____('Residual Rubber', 'Rubber', 1.125*$multiplier);
$factory->addRecipeForProduce2___('Empty Canister', 10);
$factory->addRecipeForProduce2___('Packaged Turbofuel', 10);
$factory->show();