<?php
use Kemenyende\FactoryGame\FGElement;
use Kemenyende\FactoryGame\Factory;

$multiplier = 2;

// Encased Industrial Beam
$recipe = FGElement::getByDisplayName('FGRecipe', 'Encased Industrial Beam');
$factory = new Factory($recipe->getDisplayName());
$factory->addSupplyByDisplayName('Coal', 60*$multiplier);
$factory->addSupplyByDisplayName('Coal', 30*$multiplier); // Steel Pipe
$factory->addSupplyByDisplayName('Iron Ore', 60*$multiplier);
$factory->addSupplyByDisplayName('Iron Ore', 30*$multiplier); // Steel Pipe
$factory->addSupplyByDisplayName('Iron Ore', 120*$multiplier); // Modular Frame
$factory->addSupplyByDisplayName('Iron Ore', 30*$multiplier); // Heavy Modular Frame
$factory->addSupplyByDisplayName('Limestone', 90*$multiplier);
$factory->addRecipeForProduce2___('Steel Ingot', 60*$multiplier);
$factory->addRecipeForProduce2___('Steel Ingot', 30*$multiplier); // Steel Pipe
$factory->addRecipeForProduce2___('Steel Beam', 15*$multiplier);
$factory->addRecipeForProduce2___('Concrete', 30*$multiplier);
$factory->addRecipeByObjet($recipe, (5/6)*$multiplier);
$factory->show();

// Steel Pipe
$surplus = $factory->calcSurplus();
$recipe = FGElement::getByDisplayName('FGRecipe', 'Steel Pipe');
$factory = new Factory($recipe->getDisplayName());
$factory->addSupplies($surplus);
$factory->addRecipeByObjet($recipe, (20/20)*$multiplier);
$factory->show();

// Modular Frame
$surplus = $factory->calcSurplus();
$recipe = FGElement::getByDisplayName('FGRecipe', 'Modular Frame');
$factory = new Factory($recipe->getDisplayName());
$factory->addSupplies($surplus);
$factory->addRecipeForProduce2___('Iron Ingot', 120*$multiplier);
$factory->addRecipeForProduce2___('Iron Ingot', 30*$multiplier); // Heavy Modular Frame
$factory->addRecipeForProduce2___('Iron Rod', 52.5*$multiplier);
$factory->addRecipeForProduce2___('Iron Rod', 30*$multiplier); // Heavy Modular Frame
$factory->addRecipeForProduce2___('Iron Plate', 45*$multiplier);
$factory->addRecipeForProduce2___('Screw', 90*$multiplier);
$factory->addRecipeForProduce2___('Screw', 120*$multiplier); // Heavy Modular Frame
$factory->addRecipeForProduce2___('Reinforced Iron Plate', 7.5*$multiplier);
$factory->addRecipeByObjet($recipe, (5/2)*$multiplier);
$factory->show();

// Heavy Modular Frame
$surplus = $factory->calcSurplus();
$recipe = FGElement::getByDisplayName('FGRecipe', 'Heavy Modular Frame');
$factory = new Factory($recipe->getDisplayName());
$factory->addSupplies($surplus);
$factory->addRecipeByObjet($recipe, (1/2)*$multiplier);
$factory->show();

// Computer
$surplus = $factory->calcSurplus();
$recipe = FGElement::getByDisplayName('FGRecipe', 'Computer');
$factory = new Factory($recipe->getDisplayName());
$factory->addSupplies($surplus);
$factory->addSupplyByDisplayName('Copper Ore', 68*$multiplier);
$factory->addRecipeForProduce2___('Copper Ingot', 68*$multiplier);
$factory->addRecipeForProduce2___('Copper Sheet', 26*$multiplier);
$factory->addSupplyByDisplayName('Crude Oil', 126000*$multiplier);
$factory->addRecipeForProduce2___('Wire', 32*$multiplier);
$factory->addRecipeForProduce2___('Cable', 16*$multiplier);
$factory->addRecipeForProduce2___('Plastic', 84*$multiplier);
$factory->addRecipeByDisplayName_('Residual Fuel', (42/60)*$multiplier);
$factory->addRecipeByDisplayName_('Fuel Power', (42/30)*$multiplier);
$factory->addRecipeForProduce2___('Circuit Board', 13*$multiplier);
$factory->addRecipeByObjet($recipe, (2/2.5)*$multiplier);
$factory->show();

// Adaptive Control Unit
$surplus = $factory->calcSurplus();
$recipe = FGElement::getByClassName('FGRecipe', 'Recipe_SpaceElevatorPart_5_C');
$factory = new Factory($recipe->getDisplayName());
$factory->addSupplies($surplus);
$factory->addSupplyByDisplayName('Automated Wiring', 10);
$factory->addRecipeByObjet($recipe, $multiplier);
$factory->show();