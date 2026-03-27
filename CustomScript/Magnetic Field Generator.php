<?php
use Kemenyende\FactoryGame\FGElement;
use Kemenyende\FactoryGame\Factory;

$multiplier = 480/96.75;

// ______________________________________________________________________
$factory = new Factory('Caterium => Quickwire');

$factory->addRecipeForProduce____('Miner Mk.3: Caterium Ore', 'Caterium Ore', 12*$multiplier);

$factory->addRecipeForProduce2___('Caterium Ingot', 4*$multiplier);
$factory->addRecipeForProduce2___('Quickwire', 20*$multiplier);

$factory->show();

// ______________________________________________________________________
$surplus = $factory->calcSurplus();
$factory = new Factory('Coal, Iron => Steel Beam, Steel Pipe');
$factory->addSupplies($surplus);

$factory->addRecipeForProduce____('Miner Mk.3: Coal', 'Coal', 60*$multiplier);
$factory->addRecipeForProduce____('Miner Mk.3: Coal', 'Coal', 6.75*$multiplier);
$factory->addRecipeForProduce____('Miner Mk.3: Iron Ore', 'Iron Ore', 60*$multiplier);
$factory->addRecipeForProduce____('Miner Mk.3: Iron Ore', 'Iron Ore', 6.75*$multiplier);

$factory->addRecipeForProduce2___('Steel Ingot', 60*$multiplier);
$factory->addRecipeForProduce2___('Steel Ingot', 6.75*$multiplier);

$factory->addRecipeForProduce2___('Steel Beam', 15*$multiplier);
$factory->addRecipeForProduce2___('Steel Pipe', 4.5*$multiplier);

$factory->show();

// ______________________________________________________________________
$surplus = $factory->calcSurplus();
$factory = new Factory('Iron, Steel Beam => Versatile Framework');
$factory->addSupplies($surplus);

// --> Modular Frame

$factory->addRecipeForProduce____('Miner Mk.3: Iron Ore', 'Iron Ore', 30*$multiplier);

$factory->addRecipeForProduce2___('Iron Ingot', 30*$multiplier);

$factory->addRecipeForProduce2___('Iron Plate', 11.25*$multiplier);
$factory->addRecipeForProduce2___('Iron Rod', 13.125*$multiplier);

$factory->addRecipeForProduce2___('Screw', 22.5*$multiplier);
$factory->addRecipeForProduce2___('Reinforced Iron Plate', 1.875*$multiplier);

$factory->addRecipeForProduce2___('Modular Frame', 1.25*$multiplier);

// --> Versatile Framework

$factory->addRecipeForProduce2___('Versatile Framework', 2.5*$multiplier);

$factory->show();

// ______________________________________________________________________
$surplus = $factory->calcSurplus();
$factory = new Factory('Copper, Quickwire, Steel Pipe => Electromagnetic Control Rod');
$factory->addSupplies($surplus);

$factory->addRecipeForProduce____('Miner Mk.3: Copper Ore', 'Copper Ore', 16*$multiplier);
$factory->addRecipeForProduce2___('Copper Ingot', 16*$multiplier);

$factory->addRecipeForProduce2___('Wire', 12*$multiplier);
$factory->addRecipeForProduce2___('Stator', 1.5*$multiplier);

$factory->addRecipeForProduce2___('Copper Sheet', 5*$multiplier);
$factory->addRecipeForProduce2___('AI Limiter', 1*$multiplier);

$factory->addRecipeForProduce2___('Electromagnetic Control Rod', 1*$multiplier);

$factory->show();

// ______________________________________________________________________
$surplus = $factory->calcSurplus();
$recipe = FGElement::getByClassName('FGRecipe', 'Recipe_SpaceElevatorPart_6_C');
$factory = new Factory($recipe->getDisplayName());
$factory->addSupplies($surplus);

$factory->addRecipeByObjet($recipe, 1*$multiplier);
$factory->show();