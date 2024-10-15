<?php

use \FactoryGame\Factory;

$Uranium = new Factory('Nuclear Power Plant (Uranium)');

$Uranium->addSupplyByDisplayName('Limestone', 162+108+10.8);
$Uranium->addSupplyByDisplayName('Copper Ore', 96+51.8);
$Uranium->addSupplyByDisplayName('Iron Ore', 98.1+28.35);
$Uranium->addSupplyByDisplayName('Caterium Ore', 72+21.6);
$Uranium->addSupplyByDisplayName('Coal', 98.1+19.35+7.5);
$Uranium->addSupplyByDisplayName('Sulfur', 72+18);
$Uranium->addSupplyByDisplayName('Uranium', 120);
$Uranium->addSupplyByDisplayName('Water', 1512000+753000);

$Uranium->addRecipeByDisplayName6('Concrete', 54+36+3.6);
$Uranium->addRecipeByDisplayName6('Copper Ingot', 96+51.8);
$Uranium->addRecipeByDisplayName6('Caterium Ingot', 24+7.2);
$Uranium->addRecipeByDisplayName6('Steel Ingot', 40.5+19.35);

$Uranium->addRecipeByDisplayName6('Copper Sheet', 30+18);
$Uranium->addRecipeByDisplayName6('Quickwire', 120+36);
$Uranium->addRecipeByDisplayName6('Steel Pipe', 27+8.1);
$Uranium->addRecipeByDisplayName6('Wire', 72+21.6);
$Uranium->addRecipeByDisplayName6('Steel Ingot', 57.6);

$Uranium->addRecipeByDisplayName6('Sulfuric Acid', 72000+18000);
$Uranium->addRecipeByDisplayName6('AI Limiter', 6+1.8);
$Uranium->addRecipeByDisplayName6('Stator', 9+2.7);
$Uranium->addRecipeByDisplayName6('Steel Beam', 14.4+1.8);

$Uranium->addRecipeByDisplayName6('Encased Uranium Cell', 60);
$Uranium->addRecipeByDisplayName6('Encased Industrial Beam', 3.6);
$Uranium->addRecipeByDisplayName6('Electromagnetic Control Rod', 6);

$Uranium->addRecipeByDisplayName6('Uranium Fuel Rod', 1.2);

$Uranium->addRecipeByDisplayName('Uranium Fuel Rod Power', 6);
$Uranium->show();


$Plutonium = new Factory('Nuclear Power Plant (Plutonium)');
$Plutonium->addSupplies($Uranium->calcSurplus());

$Plutonium->addSupplyByDisplayName('Raw Quartz', 25.5);
$Plutonium->addSupplyByDisplayName('Bauxite', 15);
$Plutonium->addSupplyByDisplayName('Nitrogen Gas', 72000);

$Plutonium->addRecipeByDisplayName6('Iron Ingot', 9);
$Plutonium->addRecipeByDisplayName6('Silica', 42.5);
$Plutonium->addRecipeByDisplayName6('Alumina Solution', 15000);

$Plutonium->addRecipeByDisplayName6('Iron Plate', 6);
$Plutonium->addRecipeByDisplayName6('Nitric Acid', 18000);
$Plutonium->addRecipeByDisplayName6('Aluminum Scrap', 22.5);

$Plutonium->addRecipeByDisplayName6('Aluminum Ingot', 15);

$Plutonium->addRecipeByDisplayName6('Alclad Aluminum Sheet', 15);
$Plutonium->addRecipeByDisplayName6('Non-Fissile Uranium', 60);
$Plutonium->addRecipeByDisplayName6('Electromagnetic Control Rod', 1.8);

$Plutonium->addRecipeByDisplayName6('Heat Sink', 3);
$Plutonium->addRecipeByDisplayName6('Plutonium Pellet', 18);

$Plutonium->addRecipeByDisplayName6('Encased Plutonium Cell', 9);

$Plutonium->addRecipeByDisplayName6('Plutonium Fuel Rod', 0.3);

$Plutonium->addRecipeByDisplayName('Plutonium Fuel Rod Power', 3);

$Plutonium->show();
