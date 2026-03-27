<?php
use Kemenyende\FactoryGame\Factory;

$Uranium = new Factory('Nuclear Power Plant (Uranium)');

$Uranium->addSupplyByDisplayName('Limestone', 162+108+10.8);
$Uranium->addSupplyByDisplayName('Copper Ore', 96+51.8);
$Uranium->addSupplyByDisplayName('Iron Ore', 98.1+28.35);
$Uranium->addSupplyByDisplayName('Caterium Ore', 72+21.6);
$Uranium->addSupplyByDisplayName('Coal', 98.1+19.35+7.5);
$Uranium->addSupplyByDisplayName('Sulfur', 72+18);
$Uranium->addSupplyByDisplayName('Uranium', 120);
$Uranium->addSupplyByDisplayName('Water', 1512000+753000);

$Uranium->addRecipeForProduce2___('Concrete', 54+36+3.6);
$Uranium->addRecipeForProduce2___('Copper Ingot', 96+51.8);
$Uranium->addRecipeForProduce2___('Caterium Ingot', 24+7.2);
$Uranium->addRecipeForProduce2___('Steel Ingot', 40.5+19.35);

$Uranium->addRecipeForProduce2___('Copper Sheet', 30+18);
$Uranium->addRecipeForProduce2___('Quickwire', 120+36);
$Uranium->addRecipeForProduce2___('Steel Pipe', 27+8.1);
$Uranium->addRecipeForProduce2___('Wire', 72+21.6);
$Uranium->addRecipeForProduce2___('Steel Ingot', 57.6);

$Uranium->addRecipeForProduce2___('Sulfuric Acid', 72000+18000);
$Uranium->addRecipeForProduce2___('AI Limiter', 6+1.8);
$Uranium->addRecipeForProduce2___('Stator', 9+2.7);
$Uranium->addRecipeForProduce2___('Steel Beam', 14.4+1.8);

$Uranium->addRecipeForProduce2___('Encased Uranium Cell', 60);
$Uranium->addRecipeForProduce2___('Encased Industrial Beam', 3.6);
$Uranium->addRecipeForProduce2___('Electromagnetic Control Rod', 6);

$Uranium->addRecipeForProduce2___('Uranium Fuel Rod', 1.2);

$Uranium->addRecipeByDisplayName_('Uranium Fuel Rod Power', 6);
$Uranium->show();


$Plutonium = new Factory('Nuclear Power Plant (Plutonium)');
$Plutonium->addSupplies($Uranium->calcSurplus());

$Plutonium->addSupplyByDisplayName('Raw Quartz', 25.5);
$Plutonium->addSupplyByDisplayName('Bauxite', 15);
$Plutonium->addSupplyByDisplayName('Nitrogen Gas', 72000);

$Plutonium->addRecipeForProduce2___('Iron Ingot', 9);
$Plutonium->addRecipeForProduce2___('Silica', 42.5);
$Plutonium->addRecipeForProduce2___('Alumina Solution', 15000);

$Plutonium->addRecipeForProduce2___('Iron Plate', 6);
$Plutonium->addRecipeForProduce2___('Nitric Acid', 18000);
$Plutonium->addRecipeForProduce2___('Aluminum Scrap', 22.5);

$Plutonium->addRecipeForProduce2___('Aluminum Ingot', 15);

$Plutonium->addRecipeForProduce2___('Alclad Aluminum Sheet', 15);
$Plutonium->addRecipeForProduce2___('Non-Fissile Uranium', 60);
$Plutonium->addRecipeForProduce2___('Electromagnetic Control Rod', 1.8);

$Plutonium->addRecipeForProduce2___('Heat Sink', 3);
$Plutonium->addRecipeForProduce2___('Plutonium Pellet', 18);

$Plutonium->addRecipeForProduce2___('Encased Plutonium Cell', 9);

$Plutonium->addRecipeForProduce2___('Plutonium Fuel Rod', 0.3);

$Plutonium->addRecipeByDisplayName_('Plutonium Fuel Rod Power', 3);

$Plutonium->show();
