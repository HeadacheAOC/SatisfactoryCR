<?php
use Kemenyende\FactoryGame\Factory;

$factory = new Factory('Power Shard');



$ratio = 120/128;
$factory->addRecipeForProduce____('Synthetic Power Shard', 'Power Shard',  $ratio);
$factory->addRecipeForProduce2___  ('Time Crystal', 2 * $ratio);
$factory->addRecipeForProduce2___    ('Diamonds', 6.4 * $ratio);
$factory->addRecipeForProduce____      ('Miner Mk.1: Coal', 'Coal', 128 * $ratio);
$factory->addRecipeForProduce2___  ('Dark Matter Crystal', 2.4 * $ratio);
$factory->addRecipeForProduce2___  ('Quartz Crystal', 12 * $ratio);
$factory->addRecipeForProduce____    ('Miner Mk.1: Raw Quartz', 'Raw Quartz', 20 * $ratio);
$factory->addRecipeForProduce2___  ('Excited Photonic Matter', 12000 * $ratio);



$factory->show();
