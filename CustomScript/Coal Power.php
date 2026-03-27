<?php
use Kemenyende\FactoryGame\Factory;

$multiplier = 1;

$factory = new Factory('Coal Power');
$factory->addRecipeForConsume____('Coal Power', 'Coal', 120*$multiplier);
$factory->addRecipeForProduce____('Miner Mk.1: Coal Pure', 'Coal', 120*$multiplier);
$factory->addRecipeForProduce____('Water Extractor: Water', 'Water', 360000*$multiplier);
$factory->show();