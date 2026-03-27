<?php
use Kemenyende\FactoryGame\FGElement;
use Kemenyende\FactoryGame\Factory;

//Recipe_SpaceElevatorPart_1_C();
//Recipe_SpaceElevatorPart_2_C();
//Recipe_SpaceElevatorPart_3_C();
//Recipe_SpaceElevatorPart_4_C();
//Recipe_SpaceElevatorPart_5_C();
//Recipe_SpaceElevatorPart_6_C();
Recipe_SpaceElevatorPart_7_C();
Recipe_SpaceElevatorPart_8_C();
Recipe_SpaceElevatorPart_9_C();


function Recipe_SpaceElevatorPart_1_C() { // Smart Plating
	$recipe = FGElement::getByClassName('FGRecipe', 'Recipe_SpaceElevatorPart_1_C');
	$multiplier = 1;
	$factory = new Factory($recipe->getDisplayName());
	$factory->addRecipeByDisplayName_('Reinforced Iron Plate', 2*$multiplier);
	$factory->addRecipeByDisplayName_('Rotor', 2*$multiplier);
	$factory->addRecipeByObjet($recipe, 1*$multiplier);
	$factory->show();
}

function Recipe_SpaceElevatorPart_2_C() { // Versatile Framework
	$recipe = FGElement::getByClassName('FGRecipe', 'Recipe_SpaceElevatorPart_2_C');
	$multiplier = 2 * (120/180);
	$factory = new Factory($recipe->getDisplayName());
	$factory->addSupplyByDisplayName('Iron Ore', 180*$multiplier);
	$factory->addRecipeByDisplayName_('Iron Ingot', (60/30)*$multiplier);
	$factory->addRecipeByDisplayName_('Iron Rod', ((15+11.25)/15)*$multiplier);
	$factory->addRecipeByDisplayName_('Screw', (45/40)*$multiplier);
	$factory->addRecipeByDisplayName_('Iron Plate', (22.5/20)*$multiplier);
	$factory->addRecipeByDisplayName_('Reinforced Iron Plate', (3.75/5)*$multiplier);
	$factory->addRecipeByDisplayName_('Modular Frame', (2.5/2)*$multiplier);
	$factory->addSupplyByDisplayName('Coal', 120*$multiplier);
	$factory->addRecipeByDisplayName_('Steel Ingot', (120/45)*$multiplier);
	$factory->addRecipeByDisplayName_('Steel Beam', (30/15)*$multiplier);
	$factory->addRecipeByObjet($recipe, 1*$multiplier);
	$factory->show();
}

function Recipe_SpaceElevatorPart_3_C() { // Automated Wiring
	$recipe = FGElement::getByClassName('FGRecipe', 'Recipe_SpaceElevatorPart_3_C');
	$multiplier = 240/60;
	$factory = new Factory($recipe->getDisplayName());
	$factory->addSupplyByDisplayName('Iron Ore', 11.25*$multiplier);
	$factory->addSupplyByDisplayName('Coal', 11.25*$multiplier);
	$factory->addSupplyByDisplayName('Copper Ore', 60*$multiplier);
	$factory->addRecipeByDisplayName_('Steel Ingot', (11.25/45)*$multiplier);
	$factory->addRecipeByDisplayName_('Steel Pipe', (7.5/20)*$multiplier);
	$factory->addRecipeByDisplayName_('Copper Ingot', (60/30)*$multiplier);
	$factory->addRecipeByDisplayName_('Wire', ((100+20)/30)*$multiplier);
	$factory->addRecipeByDisplayName_('Stator', (2.5/5)*$multiplier);
	$factory->addRecipeByDisplayName_('Cable', (50/30)*$multiplier);
	$factory->addRecipeByObjet($recipe, 1*$multiplier);
	$factory->show();
}

function Recipe_SpaceElevatorPart_4_C() { // Modular Engine
	$recipe = FGElement::getByClassName('FGRecipe', 'Recipe_SpaceElevatorPart_4_C');
	$multiplier = 240/109.5;
	$factory = new Factory($recipe->getDisplayName());

	$factory->addRecipeByDisplayName_('Iron Ingot', (43.5/30)*$multiplier);

	$factory->addRecipeByDisplayName_('Iron Ingot', (48/30)*$multiplier);
	$factory->addRecipeByDisplayName_('Iron Rod', (43.5/15)*$multiplier);
	$factory->addRecipeByDisplayName_('Steel Ingot', (18/45)*$multiplier);
	$factory->addRecipeByDisplayName_('Copper Ingot', (16/30)*$multiplier);

	$factory->addRecipeByDisplayName_('Iron Rod', (30/15)*$multiplier);
	$factory->addRecipeByDisplayName_('Screw', (174/40)*$multiplier);
	$factory->addRecipeByDisplayName_('Steel Pipe', (12/20)*$multiplier);
	$factory->addRecipeByDisplayName_('Wire', (32/30)*$multiplier);
	$factory->addRecipeByDisplayName_('Iron Plate', (12/20)*$multiplier);

	$factory->addRecipeByDisplayName_('Rotor', (6/4)*$multiplier);
	$factory->addRecipeByDisplayName_('Stator', (4/5)*$multiplier);
	$factory->addRecipeByDisplayName_('Crude Oil', (225/1200)*$multiplier);
	$factory->addRecipeByDisplayName_('Reinforced Iron Plate', (2/5)*$multiplier);

	$factory->addRecipeByDisplayName_('Motor', (2/5)*$multiplier);
	$factory->addRecipeByDisplayName_('Rubber', (15/20)*$multiplier);
	$factory->addRecipeByDisplayName_('Smart Plating', (2/2)*$multiplier);

	$factory->addRecipeByObjet($recipe, 1*$multiplier);
	$factory->show();
}

function Recipe_SpaceElevatorPart_5_C() { // Adaptive Control Unit
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

}


function Recipe_SpaceElevatorPart_6_C() {
	$recipe = FGElement::getByClassName('FGRecipe', 'Recipe_SpaceElevatorPart_6_C');
	$multiplier = 1;
	$factory = new Factory($recipe->getDisplayName());
	$factory->addRecipeByObjet($recipe, 1*$multiplier);
	$factory->show();
}

function Recipe_SpaceElevatorPart_7_C() {
	$recipe = FGElement::getByClassName('FGRecipe', 'Recipe_SpaceElevatorPart_7_C');
	$multiplier = 1;
	$factory = new Factory($recipe->getDisplayName(), null);
	$factory->addRecipeByObjet($recipe, 1*$multiplier);
	$factory->show();
}

function Recipe_SpaceElevatorPart_8_C() {
	$recipe = FGElement::getByClassName('FGRecipe', 'Recipe_SpaceElevatorPart_8_C');
	$multiplier = 1;
	$factory = new Factory($recipe->getDisplayName(), null);
	$factory->addRecipeByObjet($recipe, 1*$multiplier);
	$factory->show();
}

function Recipe_SpaceElevatorPart_9_C() {
	$recipe = FGElement::getByClassName('FGRecipe', 'Recipe_SpaceElevatorPart_9_C');
	$multiplier = 1;
	$factory = new Factory($recipe->getDisplayName(), null);
	$factory->addRecipeByObjet($recipe, 1*$multiplier);
	$factory->show();
}
