<?php
use Kemenyende\FactoryGame\Factory;
use Kemenyende\FactoryGame\Region;

class Kemenyende2025 extends Region {
	
	private ?Factory $ELSEWHERE_ELSEWHERE = null;
	
	private ?Factory $Prairie_____BasicsC = null;
	private ?Factory $Prairie__CoalMineSE = null;
	private ?Factory $Prairie_____SteelSO = null;
	private ?Factory $Prairie__CoalPowerE = null;
	
	private ?Factory $Champi____FuelPower = null;

	protected function step1_addFactories() {
		$this->Prairie_____BasicsC = $this->addFactory('Prairie: Space Elevator (Center)');
		$this->Prairie_____SteelSO = $this->addFactory('Prairie: Steel (Sud-Ouest)');
		$this->Prairie__CoalMineSE = $this->addFactory('Prairie: Coal Mine (Sud-Est)');
		$this->Prairie__CoalPowerE = $this->addFactory('Prairie: Coal Power (Est)');
		
		$this->Champi____FuelPower = $this->addFactory('Champi: Fuel Power');
		
		$this->ELSEWHERE_ELSEWHERE = $this->addFactory('ELSEWHERE');
	}

	protected function step2_addRecipes() {
		
		// Basics
		$amountOf_CopperSheet = 10;
		$this->Prairie_____BasicsC->addRecipeForProduce2___('Copper Sheet', 1*$amountOf_CopperSheet);
		$this->Prairie_____BasicsC->addRecipeForProduce2___  ('Copper Ingot', 2*$amountOf_CopperSheet);
		$this->Prairie_____BasicsC->addRecipeForProduce____    ('Miner Mk.1: Copper Ore', 'Copper Ore', 2*$amountOf_CopperSheet);
		$amountOf_Cable = 10;
		$this->Prairie_____BasicsC->addRecipeForProduce2___('Cable', 1*$amountOf_Cable);
		$this->Prairie_____BasicsC->addRecipeForProduce2___  ('Wire', 2*$amountOf_Cable);
		$this->Prairie_____BasicsC->addRecipeForProduce2___    ('Copper Ingot', 1*$amountOf_Cable);
		$this->Prairie_____BasicsC->addRecipeForProduce____      ('Miner Mk.1: Copper Ore', 'Copper Ore', 1*$amountOf_Cable);
		
		// Coal Power
		$amountOf_CoalPowerRecipe = 240/15;
		$this->Prairie__CoalPowerE->addRecipeByDisplayName_('Coal Power', $amountOf_CoalPowerRecipe);
		$this->Prairie__CoalMineSE->addRecipeForProduce____  ('Miner Mk.2: Coal Pure', 'Coal', 15*$amountOf_CoalPowerRecipe);
		$this->Prairie__CoalPowerE->addRecipeForProduce____  ('Water Extractor: Water', 'Water', 45000*$amountOf_CoalPowerRecipe);
		
		// Fuel Power
		$amountOf_ExtraFuel = 20000;
		$this->Champi____FuelPower->addRecipeForConsume____('Fuel Power', 'Fuel', $amountOf_ExtraFuel);
		
		
		
		$this->addRecipesForAssemblyDirectorSystem(4/3);
		$this->addRecipesForMagneticFieldGenerator(4);
		$this->addRecipesForThermalPropulsionRocket(1);
		//$this->addRecipesForNuclearPasta(2);


		//$this->addRecipesForBiochemicalScultor(0.5);
		//$this->addRecipesForBallisticWarpDrive(0.5);
		//$this->addRecipesForAIExpansionServer(0.5);
		//$this->addRecipesForPowerShard(120/128);

		// Transformer l'excedent liquide pour le transport par train
	}

	protected function step4_Supply() {
		
		$this->supply($this->Prairie__CoalPowerE, $this->Prairie__CoalMineSE, 'Coal');
		
		$this->supply($this->ELSEWHERE_ELSEWHERE, $this->Prairie_____BasicsC, 'Smart Plating');
		$this->supply($this->ELSEWHERE_ELSEWHERE, $this->Prairie_____SteelSO, 'Automated Wiring');
		$this->supply($this->ELSEWHERE_ELSEWHERE, $this->Prairie_____SteelSO, 'Versatile Framework');
		
	}
	
	//////////////////////////////////
	///// Recipe_SpaceElevatorPart_X_C
	/////

	public function addRecipesForMagneticFieldGenerator(float $amountOf_MagneticFieldGeneratorRecipe) {
		
		// Magnetic Field Generator
		$this->ELSEWHERE_ELSEWHERE->addRecipe______________('Recipe_SpaceElevatorPart_6_C', 1*$amountOf_MagneticFieldGeneratorRecipe);
		
		// Magnetic Field Generator: Versatile Framework
		$this->Prairie_____SteelSO->addRecipe______________  ('Recipe_SpaceElevatorPart_2_C', 0.5*$amountOf_MagneticFieldGeneratorRecipe);
		$this->Prairie_____SteelSO->addRecipeForProduce2___    ('Modular Frame', 1.25*$amountOf_MagneticFieldGeneratorRecipe);
		$this->Prairie_____SteelSO->addRecipeForProduce2___      ('Reinforced Iron Plate', 1.875*$amountOf_MagneticFieldGeneratorRecipe);
		$this->Prairie_____SteelSO->addRecipeForProduce2___        ('Iron Plate', 11.25*$amountOf_MagneticFieldGeneratorRecipe);
		$this->Prairie_____SteelSO->addRecipeForProduce2___          ('Iron Ingot', 16.875*$amountOf_MagneticFieldGeneratorRecipe);
		$this->Prairie_____SteelSO->addRecipeForProduce____            ('Miner Mk.1: Iron Ore', 'Iron Ore', 16.875*$amountOf_MagneticFieldGeneratorRecipe);
		$this->Prairie_____SteelSO->addRecipeForProduce2___        ('Screws', 22.5*$amountOf_MagneticFieldGeneratorRecipe);
		$this->Prairie_____SteelSO->addRecipeForProduce2___          ('Iron Rod', 5.625*$amountOf_MagneticFieldGeneratorRecipe);
		$this->Prairie_____SteelSO->addRecipeForProduce2___            ('Iron Ingot', 5.625*$amountOf_MagneticFieldGeneratorRecipe);
		$this->Prairie_____SteelSO->addRecipeForProduce____              ('Miner Mk.1: Iron Ore', 'Iron Ore', 5.625*$amountOf_MagneticFieldGeneratorRecipe);
		$this->Prairie_____SteelSO->addRecipeForProduce2___      ('Iron Rod', 7.5*$amountOf_MagneticFieldGeneratorRecipe);
		$this->Prairie_____SteelSO->addRecipeForProduce2___        ('Iron Ingot', 7.5*$amountOf_MagneticFieldGeneratorRecipe);
		$this->Prairie_____SteelSO->addRecipeForProduce____          ('Miner Mk.1: Iron Ore', 'Iron Ore', 7.5*$amountOf_MagneticFieldGeneratorRecipe);
		$this->Prairie_____SteelSO->addRecipeForProduce2___    ('Steel Beam', 15*$amountOf_MagneticFieldGeneratorRecipe);
		$this->Prairie_____SteelSO->addRecipeForProduce2___      ('Steel Ingot', 60*$amountOf_MagneticFieldGeneratorRecipe);
		$this->Prairie_____SteelSO->addRecipeForProduce____        ('Miner Mk.1: Coal', 'Coal', 60*$amountOf_MagneticFieldGeneratorRecipe);
		$this->Prairie_____SteelSO->addRecipeForProduce____        ('Miner Mk.1: Iron Ore', 'Iron Ore', 60*$amountOf_MagneticFieldGeneratorRecipe);
		
		// Magnetic Field Generator: Electromagnetic Control Rod
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___  ('Electromagnetic Control Rod', 1*$amountOf_MagneticFieldGeneratorRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___    ('Stator', 1.5*$amountOf_MagneticFieldGeneratorRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Steel Pipe', 4.5*$amountOf_MagneticFieldGeneratorRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Steel Ingot', 6.75*$amountOf_MagneticFieldGeneratorRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____          ('Miner Mk.1: Coal', 'Coal', 6.75*$amountOf_MagneticFieldGeneratorRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____          ('Miner Mk.1: Iron Ore', 'Iron Ore', 6.75*$amountOf_MagneticFieldGeneratorRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Wire', 12*$amountOf_MagneticFieldGeneratorRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Copper Ingot', 6*$amountOf_MagneticFieldGeneratorRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____          ('Miner Mk.1: Copper Ore', 'Copper Ore', 6*$amountOf_MagneticFieldGeneratorRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___    ('AI Limiter', 1*$amountOf_MagneticFieldGeneratorRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Copper Sheet', 5*$amountOf_MagneticFieldGeneratorRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Copper Ingot', 10*$amountOf_MagneticFieldGeneratorRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____          ('Miner Mk.1: Copper Ore', 'Copper Ore', 10*$amountOf_MagneticFieldGeneratorRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Quickwire', 20*$amountOf_MagneticFieldGeneratorRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Caterium Ingot', 4*$amountOf_MagneticFieldGeneratorRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____          ('Miner Mk.1: Caterium Ore', 'Caterium Ore', 12*$amountOf_MagneticFieldGeneratorRecipe);
	}

	public function addRecipesForAssemblyDirectorSystem(float $amountOf_AssemblyDirectorSystemRecipe) {
		$this->ELSEWHERE_ELSEWHERE->addRecipe______________('Recipe_SpaceElevatorPart_7_C', 1*$amountOf_AssemblyDirectorSystemRecipe); // Assembly Director System
		$this->ELSEWHERE_ELSEWHERE->addRecipe______________  ('Recipe_SpaceElevatorPart_5_C', 1.5*$amountOf_AssemblyDirectorSystemRecipe); // Adaptive Control Unit
		$this->Prairie_____SteelSO->addRecipe______________    ('Recipe_SpaceElevatorPart_3_C', 3*$amountOf_AssemblyDirectorSystemRecipe); // Automated Wiring
		$this->Prairie_____SteelSO->addRecipeForProduce2___      ('Stator', 7.5*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Prairie_____SteelSO->addRecipeForProduce2___        ('Steel Pipe', 22.5*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Prairie_____SteelSO->addRecipeForProduce2___          ('Steel Ingot', 33.75*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Prairie_____SteelSO->addRecipeForProduce____            ('Miner Mk.1: Iron Ore', 'Iron Ore', 33.75*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Prairie_____SteelSO->addRecipeForProduce____            ('Miner Mk.1: Coal', 'Coal', 33.75*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Prairie_____SteelSO->addRecipeForProduce2___        ('Wire', 60*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Prairie_____SteelSO->addRecipeForProduce2___          ('Copper Ingot', 30*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Prairie_____SteelSO->addRecipeForProduce____            ('Miner Mk.1: Copper Ore', 'Copper Ore', 30*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Prairie_____SteelSO->addRecipeForProduce2___      ('Cable', 150*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Prairie_____SteelSO->addRecipeForProduce2___        ('Wire', 300*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Prairie_____SteelSO->addRecipeForProduce2___          ('Copper Ingot', 150*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Prairie_____SteelSO->addRecipeForProduce____            ('Miner Mk.1: Copper Ore', 'Copper Ore', 150*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___    ('Circuit Board', 7.5*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Copper Sheet', 15*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Copper Ingot', 30*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____          ('Miner Mk.1: Copper Ore', 'Copper Ore', 30*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Plastic', 30*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____         ('Oil Extractor: Crude Oil', 'Crude Oil', 45000*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForConsume____           ('Residual Fuel', 'Heavy Oil Residue', (45000/3)*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeByDisplayName_             ('Fuel Power', (((45000/3)*(2/3))/20000)*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___    ('Heavy Modular Frame', 1.5*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Steel Pipe', 30*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Steel Ingot', 45*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____          ('Miner Mk.1: Iron Ore', 'Iron Ore', 45*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____          ('Miner Mk.1: Coal', 'Coal', 45*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Encased Industrial Beam', 7.5*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Concrete', 45*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____          ('Miner Mk.1: Limestone', 'Limestone', 135*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Steel Beam', 22.5*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___          ('Steel Ingot', 90*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____            ('Miner Mk.1: Iron Ore', 'Iron Ore', 90*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____            ('Miner Mk.1: Coal', 'Coal', 90*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Modular Frame', 7.5*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Reinforced Iron Plate', 11.25*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___          ('Iron Plate', 67.5*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___            ('Iron Ingot', 101.25*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____              ('Miner Mk.1: Iron Ore', 'Iron Ore', 101.25*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___          ('Screws', 135*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___            ('Iron Rod', 33.75*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___              ('Iron Ingot', 33.75*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____                ('Miner Mk.1: Iron Ore', 'Iron Ore', 33.75*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Iron Rod', 45*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___          ('Iron Ingot', 45*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____            ('Miner Mk.1: Iron Ore', 'Iron Ore', 45*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Screws', 180*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Iron Rod', 45*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___          ('Iron Ingot', 45*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____            ('Miner Mk.1: Iron Ore', 'Iron Ore', 45*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___    ('Computer', 3*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Circuit Board', 12*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Copper Sheet', 24*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___          ('Copper Ingot', 48*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____            ('Miner Mk.1: Copper Ore', 'Copper Ore', 48*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Plastic', 48*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____          ('Oil Extractor: Crude Oil', 'Crude Oil', 72000*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForConsume____            ('Residual Fuel', 'Heavy Oil Residue', (72000/3)*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeByDisplayName_               ('Fuel Power', (((72000/3)*(2/3))/20000)*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Cable', 24*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Wire', 48*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___          ('Copper Ingot', 24*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____            ('Miner Mk.1: Copper Ore', 'Copper Ore', 24*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Plastic', 48*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____        ('Oil Extractor: Crude Oil', 'Crude Oil', 72000*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForConsume____          ('Residual Fuel', 'Heavy Oil Residue', (72000/3)*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeByDisplayName_             ('Fuel Power', (((72000/3)*(2/3))/20000)*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___  ('Supercomputer', 0.75*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___    ('AI Limiter', 1.5*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Copper Sheet', 7.5*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Copper Ingot', 15*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____          ('Miner Mk.1: Copper Ore', 'Copper Ore', 15*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Quickwire', 30*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Caterium Ingot', 6*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____          ('Miner Mk.1: Caterium Ore', 'Caterium Ore', 18*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___    ('High-Speed Connector', 2.25*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Quickwire', 126*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Caterium Ingot', 25.2*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____          ('Miner Mk.1: Caterium Ore', 'Caterium Ore', 75.6*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Cable', 22.5*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Wire', 45*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___          ('Copper Ingot', 22.5*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____            ('Miner Mk.1: Copper Ore', 'Copper Ore', 22.5*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Circuit Board', 2.25*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Copper Sheet', 4.5*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___          ('Copper Ingot', 9*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____             ('Miner Mk.1: Copper Ore', 'Copper Ore', 9*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE__addRecipesForProduce2__        ('Plastic', 9*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___    ('Computer', 3*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE__addRecipesForProduce2__      ('Plastic', 69*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Circuit Board', 12*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE__addRecipesForProduce2__        ('Plastic', 48*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Copper Sheet', 24*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___          ('Copper Ingot', 48*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____             ('Miner Mk.1: Copper Ore', 'Copper Ore', 48*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Cable', 24*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Wire', 48*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___          ('Copper Ingot', 24*$amountOf_AssemblyDirectorSystemRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____            ('Miner Mk.1: Copper Ore', 'Copper Ore', 24*$amountOf_AssemblyDirectorSystemRecipe);
	}

	public function addRecipesForThermalPropulsionRocket(float $amountOf_ThermalPropulsionRocketRecipe) {
		$this->ELSEWHERE_ELSEWHERE->addRecipe______________('Recipe_SpaceElevatorPart_8_C', 1*$amountOf_ThermalPropulsionRocketRecipe); // Thermal Propulsion Rocket

		// Modular Engine
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___  ('Modular Engine', 2.5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___    ('Motor', 5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Rotor', 10*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Iron Rod', 50*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___          ('Iron Ingot', 50*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____            ('Miner Mk.1: Iron Ore', 'Iron Ore', 50*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Screws', 250*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___          ('Iron Rod', 62.5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___            ('Iron Ingot', 62.5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____              ('Miner Mk.1: Iron Ore', 'Iron Ore', 62.5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Stator', 10*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Steel Pipe', 30*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___          ('Steel Ingot', 45*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____            ('Miner Mk.1: Iron Ore', 'Iron Ore', 45*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____            ('Miner Mk.1: Coal', 'Coal', 45*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Wire', 80*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___          ('Copper Ingot', 40*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____            ('Miner Mk.1: Copper Ore', 'Copper Ore', 40*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___    ('Rubber', 37.5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____       ('Oil Extractor: Crude Oil', 'Crude Oil', 56250*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForConsume____         ('Residual Fuel', 'Heavy Oil Residue', (56250/(3/2))*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeByDisplayName_           ('Fuel Power', (((56250/(3/2))*(2/3))/20000)*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Prairie_____BasicsC->addRecipe______________    ('Recipe_SpaceElevatorPart_1_C', 2.5*$amountOf_ThermalPropulsionRocketRecipe); // Smart Plating
		$this->Prairie_____BasicsC->addRecipeForProduce2___      ('Rotor', 5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Prairie_____BasicsC->addRecipeForProduce2___        ('Iron Rod', 25*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Prairie_____BasicsC->addRecipeForProduce2___          ('Iron Ingot', 25*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Prairie_____BasicsC->addRecipeForProduce____            ('Miner Mk.1: Iron Ore', 'Iron Ore', 25*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Prairie_____BasicsC->addRecipeForProduce2___        ('Screws', 125*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Prairie_____BasicsC->addRecipeForProduce2___          ('Iron Rod', 31.25*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Prairie_____BasicsC->addRecipeForProduce2___            ('Iron Ingot', 31.25*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Prairie_____BasicsC->addRecipeForProduce____              ('Miner Mk.1: Iron Ore', 'Iron Ore', 31.25*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Prairie_____BasicsC->addRecipeForProduce2___      ('Reinforced Iron Plate', 5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Prairie_____BasicsC->addRecipeForProduce2___        ('Iron Plate', 30*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Prairie_____BasicsC->addRecipeForProduce2___          ('Iron Ingot', 45*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Prairie_____BasicsC->addRecipeForProduce____            ('Miner Mk.1: Iron Ore', 'Iron Ore', 45*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Prairie_____BasicsC->addRecipeForProduce2___        ('Screws', 60*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Prairie_____BasicsC->addRecipeForProduce2___          ('Iron Rod', 15*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Prairie_____BasicsC->addRecipeForProduce2___            ('Iron Ingot', 15*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Prairie_____BasicsC->addRecipeForProduce____              ('Miner Mk.1: Iron Ore', 'Iron Ore', 15*$amountOf_ThermalPropulsionRocketRecipe);

		// Turbo Motor
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___  ('Turbo Motor', 1*$amountOf_ThermalPropulsionRocketRecipe);

		// Turbo Motor: Motor
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___    ('Motor', 4*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Rotor', 8*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Iron Rod', 40*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___          ('Iron Ingot', 40*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____            ('Miner Mk.1: Iron Ore', 'Iron Ore', 40*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Screws', 200*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___          ('Iron Rod', 50*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___            ('Iron Ingot', 50*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____              ('Miner Mk.1: Iron Ore', 'Iron Ore', 50*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Stator', 8*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Steel Pipe', 24*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___          ('Steel Ingot', 36*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____            ('Miner Mk.1: Iron Ore', 'Iron Ore', 36*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____            ('Miner Mk.1: Coal', 'Coal', 36*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Wire', 64*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___          ('Copper Ingot', 32*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____            ('Miner Mk.1: Copper Ore', 'Copper Ore', 32*$amountOf_ThermalPropulsionRocketRecipe);

		// Turbo Motor: Rubber
		$this->ELSEWHERE_ELSEWHERE__addRecipesForProduce2__    ('Rubber', 24*$amountOf_ThermalPropulsionRocketRecipe);

		// Turbo Motor: Cooling System
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___    ('Cooling System', 4*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE__addRecipesForProduce2__      ('Rubber', 8*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Heat Sink', 8*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE__addRecipesForProduce2__        ('Alclad Aluminum Sheet', 40*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Copper Sheet', 24*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___          ('Copper Ingot', 48*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____            ('Miner Mk.1: Copper Ore', 'Copper Ore', 48*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____       ('Water Extractor: Water', 'Water', 20000*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____       ('Unpackage Nitrogen Gas', 'Nitrogen Gas', 100000*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForConsume____         ('Packaged Nitrogen Gas', 'Nitrogen Gas', 100000*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____            ('Resource Well Extractor: Nitrogen Gas', 'Nitrogen Gas', 100000*$amountOf_ThermalPropulsionRocketRecipe);

		// Turbo Motor: Radio Control Unit
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___    ('Radio Control Unit', 2*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Aluminum Casing', 32*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE__addRecipesForProduce2__        ('Aluminum Ingot', 48*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Crystal Oscillator', 1*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Quartz Crystal', 18*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____          ('Miner Mk.1: Raw Quartz', 'Raw Quartz', 30*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Cable', 14*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___          ('Wire', 28*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___            ('Copper Ingot', 14*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____              ('Miner Mk.1: Copper Ore', 'Copper Ore', 14*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Reinforced Iron Plate', 2.5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___          ('Iron Plate', 15*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___            ('Iron Ingot', 22.5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____              ('Miner Mk.1: Iron Ore', 'Iron Ore', 22.5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___          ('Screws', 30*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___            ('Iron Rod', 7.5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___              ('Iron Ingot', 7.5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____                ('Miner Mk.1: Iron Ore', 'Iron Ore', 7.5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Computer', 2*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Circuit Board', 8*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___          ('Copper Sheet', 16*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___            ('Copper Ingot', 32*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____              ('Miner Mk.1: Copper Ore', 'Copper Ore', 32*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Cable', 16*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___          ('Wire', 32*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___            ('Copper Ingot', 16*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____              ('Miner Mk.1: Copper Ore', 'Copper Ore', 16*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE__addRecipesForProduce2__        ('Plastic', 64*$amountOf_ThermalPropulsionRocketRecipe);

		// Cooling System
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___    ('Cooling System', 3*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE__addRecipesForProduce2__      ('Rubber', 6*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Heat Sink', 6*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE__addRecipesForProduce2__        ('Alclad Aluminum Sheet', 30*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Copper Sheet', 18*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___          ('Copper Ingot', 36*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____             ('Miner Mk.1: Copper Ore', 'Copper Ore', 36*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____       ('Water Extractor: Water', 'Water', 15000*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____       ('Unpackage Nitrogen Gas', 'Nitrogen Gas', 75000*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForConsume____        ('Packaged Nitrogen Gas', 'Nitrogen Gas', 75000*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____          ('Resource Well Extractor: Nitrogen Gas', 'Nitrogen Gas', 75000*$amountOf_ThermalPropulsionRocketRecipe);

		// Fused Modular Frame
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___  ('Fused Modular Frame', 1*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____    ('Resource Well Extractor: Nitrogen Gas', 'Nitrogen Gas', 25000*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___    ('Heavy Modular Frame', 1*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___       ('Steel Pipe', 20*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___         ('Steel Ingot', 30*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____          ('Miner Mk.1: Iron Ore', 'Iron Ore', 30*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____          ('Miner Mk.1: Coal', 'Coal', 30*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Encased Industrial Beam', 5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Concrete', 30*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____           ('Miner Mk.1: Limestone', 'Limestone', 90*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Steel Beam', 15*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___          ('Steel Ingot', 60*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____             ('Miner Mk.1: Iron Ore', 'Iron Ore', 60*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____             ('Miner Mk.1: Coal', 'Coal', 60*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___       ('Modular Frame', 5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___         ('Reinforced Iron Plate', 7.5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___           ('Iron Plate', 45*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___             ('Iron Ingot', 67.5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____              ('Miner Mk.1: Iron Ore', 'Iron Ore', 67.5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___           ('Screws', 90*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___             ('Iron Rod', 22.5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___               ('Iron Ingot', 22.5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____                ('Miner Mk.1: Iron Ore', 'Iron Ore', 22.5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___         ('Iron Rod', 30*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___           ('Iron Ingot', 30*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____            ('Miner Mk.1: Iron Ore', 'Iron Ore', 30*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___       ('Screws', 120*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___         ('Iron Rod', 30*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___           ('Iron Ingot', 30*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____            ('Miner Mk.1: Iron Ore', 'Iron Ore', 30*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___    ('Aluminum Casing', 50*$amountOf_ThermalPropulsionRocketRecipe);
		$this->ELSEWHERE_ELSEWHERE__addRecipesForProduce2__      ('Aluminum Ingot', 75*$amountOf_ThermalPropulsionRocketRecipe);
	}

	public function addRecipesForNuclearPasta(float $amountOf_NuclearPastaRecipe) {
		$this->ELSEWHERE_ELSEWHERE->addRecipe______________  ('Recipe_SpaceElevatorPart_9_C', 1*$amountOf_NuclearPastaRecipe); // Nuclear Pasta

		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___  ('Copper Powder', 100*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___    ('Copper Ingot', 600*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____       ('Miner Mk.1: Copper Ore', 'Copper Ore', 600*$amountOf_NuclearPastaRecipe);

		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___  ('Pressure Conversion Cube', 0.5*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___    ('Radio Control Unit', 1*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Aluminum Casing', 16*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE__addRecipesForProduce2__        ('Aluminum Ingot', 24*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Crystal Oscillator', 0.5*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___         ('Quartz Crystal', 9*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____            ('Miner Mk.1: Raw Quartz', 'Raw Quartz', 15*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Cable', 7*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___          ('Wire', 14*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___            ('Copper Ingot', 7*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____               ('Miner Mk.1: Copper Ore', 'Copper Ore', 7*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Reinforced Iron Plate', 1.25*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___          ('Iron Plate', 7.5*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___            ('Iron Ingot', 11.25*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____               ('Miner Mk.1: Iron Ore', 'Iron Ore', 11.25*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___          ('Screws', 15*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___            ('Iron Rod', 3.75*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___              ('Iron Ingot', 3.75*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____                 ('Miner Mk.1: Iron Ore', 'Iron Ore', 3.75*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Computer', 1*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Circuit Board', 4*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___          ('Copper Sheet', 8*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___            ('Copper Ingot', 16*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____               ('Miner Mk.1: Copper Ore', 'Copper Ore', 16*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE__addRecipesForProduce2__          ('Plastic', 16*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Cable', 8*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___          ('Wire', 16*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___            ('Copper Ingot', 8*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____               ('Miner Mk.1: Copper Ore', 'Copper Ore', 8*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE__addRecipesForProduce2__        ('Plastic', 16*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___    ('Fused Modular Frame', 0.5*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Heavy Modular Frame', 0.5*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Modular Frame', 2.5*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___          ('Reinforced Iron Plate', 3.75*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___            ('Iron Plate', 22.5*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___              ('Iron Ingot', 33.75*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____                ('Miner Mk.1: Iron Ore', 'Iron Ore', 33.75*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___            ('Screws', 45*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___              ('Iron Rod', 11.25*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___                ('Iron Ingot', 11.25*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____                  ('Miner Mk.1: Iron Ore', 'Iron Ore', 11.25*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___          ('Iron Rod', 15*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___            ('Iron Ingot', 15*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____              ('Miner Mk.1: Iron Ore', 'Iron Ore', 15*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Steel Pipe', 10*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___          ('Steel Ingot', 15*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____            ('Miner Mk.1: Iron Ore', 'Iron Ore', 15*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____            ('Miner Mk.1: Coal', 'Coal', 15*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Encased Industrial Beam', 2.5*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___          ('Steel Beam', 7.5*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___            ('Steel Ingot', 30*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____              ('Miner Mk.1: Iron Ore', 'Iron Ore', 30*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____              ('Miner Mk.1: Coal', 'Coal', 30*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___          ('Concrete', 15*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____            ('Miner Mk.1: Limestone', 'Limestone', 45*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Screws', 60*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___          ('Iron Rod', 15*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___            ('Iron Ingot', 15*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____              ('Miner Mk.1: Iron Ore', 'Iron Ore', 15*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Aluminum Casing', 25*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE__addRecipesForProduce2__        ('Aluminum Ingot', 37.5*$amountOf_NuclearPastaRecipe);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____      ('Resource Well Extractor: Nitrogen Gas', 'Nitrogen Gas', 12500*$amountOf_NuclearPastaRecipe);
	}

	public function addRecipesForBiochemicalScultor(float $amountOf_BiochemicalScultor) {
		$this->ELSEWHERE_ELSEWHERE->addRecipe______________('Recipe_SpaceElevatorPart_10_C', 0.5*$amountOf_BiochemicalScultor); // Biochemical Sculptor
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____  ('Water Extractor: Water', 'Water', 5000*$amountOf_BiochemicalScultor);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___  ('Ficsite Trigon', 20*$amountOf_BiochemicalScultor);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____    ('Ficsite Ingot (Caterium)', 'Ficsite Ingot', (20/3)*$amountOf_BiochemicalScultor);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Reanimated SAM', 20*$amountOf_BiochemicalScultor);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____        ('Miner Mk.1: SAM', 'SAM', 80*$amountOf_BiochemicalScultor);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Caterium Ingot', (26+(2/3))*$amountOf_BiochemicalScultor);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____        ('Miner Mk.1: Caterium Ore', 'Caterium Ore', 80*$amountOf_BiochemicalScultor);
	}

	public function addRecipesForBallisticWarpDrive(float $amountOf_BallisticWarpDrive) {
		$this->ELSEWHERE_ELSEWHERE->addRecipe______________('Recipe_SpaceElevatorPart_11_C', 1*$amountOf_BallisticWarpDrive); // Ballistic Warp Drive

		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___  ('Singularity Cell', 5*$amountOf_BallisticWarpDrive);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___    ('Dark Matter Crystal', 10*$amountOf_BallisticWarpDrive);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Diamonds', 10*$amountOf_BallisticWarpDrive);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____        ('Miner Mk.1: Coal', 'Coal', 200*$amountOf_BallisticWarpDrive);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Dark Matter Residue', 50000*$amountOf_BallisticWarpDrive);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Reanimated SAM', 25*$amountOf_BallisticWarpDrive);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____          ('Miner Mk.1: SAM', 'SAM', 100*$amountOf_BallisticWarpDrive);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___    ('Iron Plate', 50*$amountOf_BallisticWarpDrive);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Iron Ingot', 75*$amountOf_BallisticWarpDrive);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____        ('Miner Mk.1: Iron Ore', 'Iron Ore', 75*$amountOf_BallisticWarpDrive);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___    ('Concrete', 100*$amountOf_BallisticWarpDrive);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____      ('Miner Mk.1: Limestone', 'Limestone', 300*$amountOf_BallisticWarpDrive);

		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___  ('Superposition Oscillator', 2*$amountOf_BallisticWarpDrive);
		$this->ELSEWHERE_ELSEWHERE__addRecipesForProduce2__    ('Alclad Aluminum Sheet', 18*$amountOf_BallisticWarpDrive);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___    ('Excited Photonic Matter', 50000*$amountOf_BallisticWarpDrive);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___    ('Dark Matter Crystal', 12*$amountOf_BallisticWarpDrive);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Diamonds', 12*$amountOf_BallisticWarpDrive);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____        ('Miner Mk.1: Coal', 'Coal', 240*$amountOf_BallisticWarpDrive);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Dark Matter Residue', (60000-50000)*$amountOf_BallisticWarpDrive); // Retirer le 'Dark Matter Residue' produit par 'Excited Photonic Matter'
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Reanimated SAM', (30-25)*$amountOf_BallisticWarpDrive); // Retirer le 'Dark Matter Residue' produit par 'Excited Photonic Matter'
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____          ('Miner Mk.1: SAM', 'SAM', (120-100)*$amountOf_BallisticWarpDrive); // Retirer le 'Dark Matter Residue' produit par 'Excited Photonic Matter'
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___    ('Crystal Oscillator', 2*$amountOf_BallisticWarpDrive);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___       ('Quartz Crystal', 36*$amountOf_BallisticWarpDrive);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____          ('Miner Mk.1: Raw Quartz', 'Raw Quartz', 60*$amountOf_BallisticWarpDrive);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Cable', 28*$amountOf_BallisticWarpDrive);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Wire', 56*$amountOf_BallisticWarpDrive);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___          ('Copper Ingot', 28*$amountOf_BallisticWarpDrive);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____             ('Miner Mk.1: Copper Ore', 'Copper Ore', 28*$amountOf_BallisticWarpDrive);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Reinforced Iron Plate', 5*$amountOf_BallisticWarpDrive);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Iron Plate', 30*$amountOf_BallisticWarpDrive);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___          ('Iron Ingot', 45*$amountOf_BallisticWarpDrive);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____             ('Miner Mk.1: Iron Ore', 'Iron Ore', 45*$amountOf_BallisticWarpDrive);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Screws', 60*$amountOf_BallisticWarpDrive);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___          ('Iron Rod', 15*$amountOf_BallisticWarpDrive);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___            ('Iron Ingot', 15*$amountOf_BallisticWarpDrive);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____               ('Miner Mk.1: Iron Ore', 'Iron Ore', 15*$amountOf_BallisticWarpDrive);

		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___  ('Dark Matter Crystal', 40*$amountOf_BallisticWarpDrive);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___    ('Diamonds', 40*$amountOf_BallisticWarpDrive);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____      ('Miner Mk.1: Coal', 'Coal', 800*$amountOf_BallisticWarpDrive);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___    ('Dark Matter Residue', 200000*$amountOf_BallisticWarpDrive);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Reanimated SAM', 100*$amountOf_BallisticWarpDrive);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____        ('Miner Mk.1: SAM', 'SAM', 400*$amountOf_BallisticWarpDrive);
	}

	public function addRecipesForAIExpansionServer(float $amountOf_AIExpansionServer) {
		$this->ELSEWHERE_ELSEWHERE->addRecipe______________('Recipe_SpaceElevatorPart_12_C', 0.25*$amountOf_AIExpansionServer); // AI Expansion Server

		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___  ('Excited Photonic Matter', 25000*$amountOf_AIExpansionServer); // + 25000 Dark Matter Residue

		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___  ('Neural-Quantum Processor', 1*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___    ('Time Crystal', 5*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Diamonds', 10*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____        ('Miner Mk.1: Coal', 'Coal', 200*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___    ('Supercomputer', (4/3)*0.75*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE__addRecipesForProduce2__      ('Plastic', 28*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('AI Limiter', (4/3)*1.5*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Copper Sheet', (4/3)*7.5*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___          ('Copper Ingot', (4/3)*15*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____            ('Miner Mk.1: Copper Ore', 'Copper Ore', (4/3)*15*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Quickwire', (4/3)*30*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___          ('Caterium Ingot', (4/3)*6*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____            ('Miner Mk.1: Caterium Ore', 'Caterium Ore', (4/3)*18*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('High-Speed Connector', (4/3)*2.25*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Quickwire', (4/3)*126*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___          ('Caterium Ingot', (4/3)*25.2*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____            ('Miner Mk.1: Caterium Ore', 'Caterium Ore', (4/3)*75.6*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Cable', (4/3)*22.5*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___          ('Wire', (4/3)*45*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___            ('Copper Ingot', (4/3)*22.5*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____              ('Miner Mk.1: Copper Ore', 'Copper Ore', (4/3)*22.5*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Circuit Board', (4/3)*2.25*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___          ('Copper Sheet', (4/3)*4.5*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___            ('Copper Ingot', 12*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____               ('Miner Mk.1: Copper Ore', 'Copper Ore', 12*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE__addRecipesForProduce2__          ('Plastic', 12*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Computer', (4/3)*3*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE__addRecipesForProduce2__        ('Plastic', 64*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Circuit Board', (4/3)*12*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE__addRecipesForProduce2__          ('Plastic', 64*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___          ('Copper Sheet', (4/3)*24*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___            ('Copper Ingot', (4/3)*48*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____               ('Miner Mk.1: Copper Ore', 'Copper Ore', (4/3)*48*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Cable', (4/3)*24*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___          ('Wire', (4/3)*48*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___            ('Copper Ingot', (4/3)*24*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____              ('Miner Mk.1: Copper Ore', 'Copper Ore', (4/3)*24*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___    ('Ficsite Trigon', 15*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____      ('Ficsite Ingot (Iron)', 'Ficsite Ingot', 5*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Reanimated SAM', 20*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____          ('Miner Mk.1: SAM', 'SAM', 80*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Iron Ingot', 120*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____          ('Miner Mk.1: Iron Ore', 'Iron Ore', 120*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___    ('Excited Photonic Matter', 25000*$amountOf_AIExpansionServer); // + 25000 Dark Matter Residue

		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___  ('Superposition Oscillator', 1*$amountOf_AIExpansionServer); // + 25000 Dark Matter Residue
		$this->ELSEWHERE_ELSEWHERE__addRecipesForProduce2__    ('Alclad Aluminum Sheet', 9*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___    ('Excited Photonic Matter', 25000*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___    ('Dark Matter Crystal', 6*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Diamonds', 6*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____        ('Miner Mk.1: Coal', 'Coal', 120*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Dark Matter Residue', (30000-25000)*$amountOf_AIExpansionServer); // - 25000 Dark Matter Residue produit par 'Excited Photonic Matter'
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Reanimated SAM', 2.5*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____          ('Miner Mk.1: SAM', 'SAM', 10*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___    ('Crystal Oscillator', 1*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___       ('Quartz Crystal', 18*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____          ('Miner Mk.1: Raw Quartz', 'Raw Quartz', 30*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Cable', 14*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Wire', 28*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___          ('Copper Ingot', 14*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____             ('Miner Mk.1: Copper Ore', 'Copper Ore', 14*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Reinforced Iron Plate', 2.5*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Iron Plate', 15*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___          ('Iron Ingot', 22.5*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____             ('Miner Mk.1: Iron Ore', 'Iron Ore', 22.5*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Screws', 30*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___          ('Iron Rod', 7.5*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___            ('Iron Ingot', 7.5*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____               ('Miner Mk.1: Iron Ore', 'Iron Ore', 7.5*$amountOf_AIExpansionServer);

	}
	
	////////////
	///// Extras
	/////
	
	public function addRecipesForPowerShard(float $amountOf_PowerShard) {
		$this->DesertN_____Shard->addRecipeForProduce____('Synthetic Power Shard', 'Power Shard',  $amountOf_PowerShard);
		$this->DesertN_____Shard->addRecipeForProduce2___  ('Time Crystal', 2 * $amountOf_PowerShard);
		$this->DesertN_____Shard->addRecipeForProduce2___    ('Diamonds', 6.4 * $amountOf_PowerShard);
		$this->DesertN_____Shard->addRecipeForProduce____      ('Miner Mk.1: Coal', 'Coal', 128 * $amountOf_PowerShard);
		$this->DesertN_____Shard->addRecipeForProduce2___  ('Dark Matter Crystal', 2.4 * $amountOf_PowerShard);
		$this->DesertN_____Shard->addRecipeForProduce2___  ('Quartz Crystal', 12 * $amountOf_PowerShard);
		$this->DesertN_____Shard->addRecipeForProduce____    ('Miner Mk.1: Raw Quartz', 'Raw Quartz', 20 * $amountOf_PowerShard);
		$this->DesertN_____Shard->addRecipeForProduce2___  ('Excited Photonic Matter', 12000 * $amountOf_PowerShard);
	}

	private function ELSEWHERE_ELSEWHERE__addRecipesForProduce2__(string $expectedProductDisplayName, float $expectedProductAmount) {
		if ('Alclad Aluminum Sheet' == $expectedProductDisplayName) {
			$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___('Alclad Aluminum Sheet', $expectedProductAmount);
			$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___  ('Copper Ingot', (1/3)*$expectedProductAmount);
			$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____     ('Miner Mk.1: Copper Ore', 'Copper Ore', (1/3)*$expectedProductAmount);
			$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___  ('Aluminum Ingot', $expectedProductAmount);
			$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___    ('Aluminum Scrap', 1.5*$expectedProductAmount);
			$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____      ('Miner Mk.1: Coal', 'Coal', 0.5*$expectedProductAmount);
			$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Alumina Solution', 1000*$expectedProductAmount); // Residue : Silica
			$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____         ('Miner Mk.1: Bauxite', 'Bauxite', 1*$expectedProductAmount);
			$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____         ('Water Extractor: Water', 'Water', 1000*$expectedProductAmount);
			$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___     ('Silica', (5/6)*$expectedProductAmount); // Soustraire la quantite produite par la recette : Alumina Solution
			$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____        ('Miner Mk.1: Raw Quartz', 'Raw Quartz', 0.5*$expectedProductAmount);
		} elseif ('Aluminum Ingot' == $expectedProductDisplayName) {
			$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___('Aluminum Ingot', $expectedProductAmount);
			$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___  ('Aluminum Scrap', 1.5*$expectedProductAmount);
			$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____    ('Miner Mk.1: Coal', 'Coal', 0.5*$expectedProductAmount);
			$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___    ('Alumina Solution', 1000*$expectedProductAmount); // Residue : Silica
			$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____       ('Miner Mk.1: Bauxite', 'Bauxite', 1*$expectedProductAmount);
			$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____       ('Water Extractor: Water', 'Water', 1000*$expectedProductAmount);
			$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___   ('Silica', (5/6)*$expectedProductAmount); // Soustraire la quantite produite par la recette : Alumina Solution
			$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____      ('Miner Mk.1: Raw Quartz', 'Raw Quartz', 0.5*$expectedProductAmount);
		} elseif ('Plastic' == $expectedProductDisplayName) {
			$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____('Alternate: Recycled Plastic', 'Plastic', $expectedProductAmount);
			$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___  ('Rubber', 0.5*$expectedProductAmount);
			$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____    ('Oil Extractor: Crude Oil', 'Crude Oil', 750*$expectedProductAmount);
			$this->ELSEWHERE_ELSEWHERE->addRecipeForConsume____  ('Alternate: Diluted Packaged Fuel', 'Heavy Oil Residue', 500*$expectedProductAmount);
			$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___    ('Packaged Water', 1*$expectedProductAmount);
			$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____      ('Water Extractor: Water', 'Water', 1000*$expectedProductAmount);
			$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____    ('Unpackage Fuel', 'Fuel', 1000*$expectedProductAmount);
			$this->ELSEWHERE_ELSEWHERE->addRecipeForConsume____      ('Fuel Power', 'Fuel', 500*$expectedProductAmount);
		} elseif ('Rubber' == $expectedProductDisplayName) {
			$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___('Rubber', $expectedProductAmount);
			$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____  ('Oil Extractor: Crude Oil', 'Crude Oil', 1500*$expectedProductAmount);
			$this->ELSEWHERE_ELSEWHERE->addRecipeForConsume____  ('Alternate: Diluted Packaged Fuel', 'Heavy Oil Residue', 1000*$expectedProductAmount);
			$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___    ('Packaged Water', 2*$expectedProductAmount);
			$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____      ('Water Extractor: Water', 'Water', 2000*$expectedProductAmount);
			$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____    ('Unpackage Fuel', 'Fuel', 2000*$expectedProductAmount);
			$this->ELSEWHERE_ELSEWHERE->addRecipeForConsume____      ('Fuel Power', 'Fuel', 2000*$expectedProductAmount);
		} else {
			throw new Exception($expectedProductDisplayName);
		}
	}

}

$marais = new Kemenyende2025(false);
$marais->proceed();
