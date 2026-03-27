<?php
use Kemenyende\FactoryGame\Factory;
use Kemenyende\FactoryGame\Region;

class KemenyendeTheForest extends Region {
	private ?Factory $ELSEWHERE_ELSEWHERE = null;
	private ?Factory $POWER_________POWER = null;
	
	private ?Factory $Home_______Space1_9 = null;
	
	private ?Factory $Forest________Steel = null;
	private ?Factory $Forest____CoalPower = null;
	private ?Factory $___________OilPower = null;
	private ?Factory $___________Caterium = null;
	private ?Factory $_____________Quartz = null;
	private ?Factory $___________Aluminum = null;
	private ?Factory $___________Nitrogen = null;

	protected function step1_addFactories() {
		
		$this->Forest____CoalPower = $this->addFactory('Forest: Coal Power');
		
		$this->Forest________Steel = $this->addFactory('Forest: Steel');
		$this->___________OilPower = $this->addFactory('??: Crude Oil Power');
		$this->___________Caterium = $this->addFactory('??: Caterium');
		$this->_____________Quartz = $this->addFactory('??: Quartz');
		$this->___________Aluminum = $this->addFactory('??: Aluminum');
		$this->___________Nitrogen = $this->addFactory('??: Nitrogen');
		
		$this->Home_______Space1_9 = $this->addFactory('Home: Space 1-9');
		
		
		$this->ELSEWHERE_ELSEWHERE = $this->addFactory('Ailleurs...');
	}

	protected function step2_addRecipes() {
		
		// Coal Power
		$amountOf_CoalPowerRecipe = 240/15;
		$this->Forest____CoalPower->addRecipeByDisplayName_('Coal Power', $amountOf_CoalPowerRecipe);
		$this->Forest____CoalPower->addRecipeForProduce____  ('Miner Mk.2: Coal Pure', 'Coal', 15*$amountOf_CoalPowerRecipe);
		$this->Forest____CoalPower->addRecipeForProduce____  ('Water Extractor: Water', 'Water', 45000*$amountOf_CoalPowerRecipe);
		

		$amountOf_BiochemicalScultor = 1; // 1 pour finir le jeux en 1000 minutes.
		
		$this->addRecipesForBiochemicalScultor($amountOf_BiochemicalScultor);
			$this->addRecipesForAssemblyDirectorSystem($amountOf_BiochemicalScultor * .25);
		
		$this->addRecipesForBallisticWarpDrive($amountOf_BiochemicalScultor * .2);
			$this->addRecipesForThermalPropulsionRocket($amountOf_BiochemicalScultor * .2);
			$this->addRecipesForNuclearPasta($amountOf_BiochemicalScultor * .1);
		
		$this->addRecipesForAIExpansionServer($amountOf_BiochemicalScultor * .256);
			$this->addRecipesForMagneticFieldGenerator($amountOf_BiochemicalScultor * .256);
		
		/*$this->addRecipesForPowerShard($amountOf_PowerShard = 5);
			// Transformer l'excedent liquide pour le transport par train
			$this->ELSEWHERE_ELSEWHERE->addRecipeForConsume____('Dark Matter Crystal', 'Dark Matter Residue', 2000 * $amountOf_PowerShard);
			$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___    ('Diamonds', .4 * $amountOf_PowerShard);
			$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____      ('Miner Mk.1: Coal', 'Coal', 8 * $amountOf_PowerShard);
		*/
	}

	protected function step4_Supply() {
		$this->supply($this->Home_______Space1_9, $this->Forest________Steel, 'Steel Beam');
		$this->supply($this->Home_______Space1_9, $this->Forest________Steel, 'Steel Pipe');
		$this->supply($this->Home_______Space1_9, $this->___________OilPower, 'Rubber');
		$this->supply($this->Home_______Space1_9, $this->___________OilPower, 'Plastic');
		$this->supply($this->Home_______Space1_9, $this->___________Caterium, 'Caterium Ingot');
		$this->supply($this->Home_______Space1_9, $this->_____________Quartz, 'Quartz Crystal');
		$this->supply($this->Home_______Space1_9, $this->___________Nitrogen, 'Packaged Nitrogen Gas');
		$this->supply($this->Home_______Space1_9, $this->___________Nitrogen, 'Packaged Water');
		$this->supply($this->Home_______Space1_9, $this->___________Aluminum, 'Aluminum Casing');
		$this->supply($this->Home_______Space1_9, $this->___________Aluminum, 'Alclad Aluminum Sheet');
		
		
		$this->supply($this->___________Nitrogen, $this->Home_______Space1_9, 'Empty Canister');
		$this->supply($this->___________Nitrogen, $this->Home_______Space1_9, 'Empty Fluid Tank');
		
		// Recipe_SpaceElevatorPart 1 - 9
		$this->supply($this->ELSEWHERE_ELSEWHERE, $this->Home_______Space1_9, 'Smart Plating');
		$this->supply($this->ELSEWHERE_ELSEWHERE, $this->Home_______Space1_9, 'Versatile Framework');
		$this->supply($this->ELSEWHERE_ELSEWHERE, $this->Home_______Space1_9, 'Automated Wiring');
		$this->supply($this->ELSEWHERE_ELSEWHERE, $this->Home_______Space1_9, 'Modular Engine');
		$this->supply($this->ELSEWHERE_ELSEWHERE, $this->Home_______Space1_9, 'Adaptive Control Unit');
		$this->supply($this->ELSEWHERE_ELSEWHERE, $this->Home_______Space1_9, 'Magnetic Field Generator');
		$this->supply($this->ELSEWHERE_ELSEWHERE, $this->Home_______Space1_9, 'Assembly Director System');
		$this->supply($this->ELSEWHERE_ELSEWHERE, $this->Home_______Space1_9, 'Thermal Propulsion Rocket');
		$this->supply($this->ELSEWHERE_ELSEWHERE, $this->Home_______Space1_9, 'Nuclear Pasta');
	}
	
	
	//////////////////////////////////
	///// Recipe_SpaceElevatorPart_X_C
	/////

	public function addRecipesForMagneticFieldGenerator(float $amountOf_MagneticFieldGenerator) {
		$amountOf_MagneticFieldGeneratorRecipe = $amountOf_MagneticFieldGenerator / 1;
		
		// Magnetic Field Generator
		$this->Home_______Space1_9->addRecipe______________('Recipe_SpaceElevatorPart_6_C', 1*$amountOf_MagneticFieldGeneratorRecipe);
		
		// Magnetic Field Generator: Versatile Framework
		$this->Home_______Space1_9->addRecipe______________  ('Recipe_SpaceElevatorPart_2_C', 0.5*$amountOf_MagneticFieldGeneratorRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___    ('Modular Frame', 1.25*$amountOf_MagneticFieldGeneratorRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___      ('Reinforced Iron Plate', 1.875*$amountOf_MagneticFieldGeneratorRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___        ('Iron Plate', 11.25*$amountOf_MagneticFieldGeneratorRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___          ('Iron Ingot', 16.875*$amountOf_MagneticFieldGeneratorRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____            ('Miner Mk.1: Iron Ore', 'Iron Ore', 16.875*$amountOf_MagneticFieldGeneratorRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___        ('Screws', 22.5*$amountOf_MagneticFieldGeneratorRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___          ('Iron Rod', 5.625*$amountOf_MagneticFieldGeneratorRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___            ('Iron Ingot', 5.625*$amountOf_MagneticFieldGeneratorRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____              ('Miner Mk.1: Iron Ore', 'Iron Ore', 5.625*$amountOf_MagneticFieldGeneratorRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___      ('Iron Rod', 7.5*$amountOf_MagneticFieldGeneratorRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___        ('Iron Ingot', 7.5*$amountOf_MagneticFieldGeneratorRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____          ('Miner Mk.1: Iron Ore', 'Iron Ore', 7.5*$amountOf_MagneticFieldGeneratorRecipe);
		$this->Forest________Steel->addRecipeForProduce2___    ('Steel Beam', 15*$amountOf_MagneticFieldGeneratorRecipe);
		$this->Forest________Steel->addRecipeForProduce2___      ('Steel Ingot', 60*$amountOf_MagneticFieldGeneratorRecipe);
		$this->Forest________Steel->addRecipeForProduce____        ('Miner Mk.1: Coal', 'Coal', 60*$amountOf_MagneticFieldGeneratorRecipe);
		$this->Forest________Steel->addRecipeForProduce____        ('Miner Mk.1: Iron Ore', 'Iron Ore', 60*$amountOf_MagneticFieldGeneratorRecipe);
		
		// Magnetic Field Generator: Electromagnetic Control Rod
		$this->Home_______Space1_9->addRecipeForProduce2___  ('Electromagnetic Control Rod', 1*$amountOf_MagneticFieldGeneratorRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___    ('Stator', 1.5*$amountOf_MagneticFieldGeneratorRecipe);
		$this->Forest________Steel->addRecipeForProduce2___      ('Steel Pipe', 4.5*$amountOf_MagneticFieldGeneratorRecipe);
		$this->Forest________Steel->addRecipeForProduce2___        ('Steel Ingot', 6.75*$amountOf_MagneticFieldGeneratorRecipe);
		$this->Forest________Steel->addRecipeForProduce____          ('Miner Mk.1: Coal', 'Coal', 6.75*$amountOf_MagneticFieldGeneratorRecipe);
		$this->Forest________Steel->addRecipeForProduce____          ('Miner Mk.1: Iron Ore', 'Iron Ore', 6.75*$amountOf_MagneticFieldGeneratorRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___      ('Wire', 12*$amountOf_MagneticFieldGeneratorRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___        ('Copper Ingot', 6*$amountOf_MagneticFieldGeneratorRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____          ('Miner Mk.1: Copper Ore', 'Copper Ore', 6*$amountOf_MagneticFieldGeneratorRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___    ('AI Limiter', 1*$amountOf_MagneticFieldGeneratorRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___      ('Copper Sheet', 5*$amountOf_MagneticFieldGeneratorRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___        ('Copper Ingot', 10*$amountOf_MagneticFieldGeneratorRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____          ('Miner Mk.1: Copper Ore', 'Copper Ore', 10*$amountOf_MagneticFieldGeneratorRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___      ('Quickwire', 20*$amountOf_MagneticFieldGeneratorRecipe);
		$this->___________Caterium->addRecipeForProduce2___        ('Caterium Ingot', 4*$amountOf_MagneticFieldGeneratorRecipe);
		$this->___________Caterium->addRecipeForProduce____          ('Miner Mk.1: Caterium Ore', 'Caterium Ore', 12*$amountOf_MagneticFieldGeneratorRecipe);
	}

	public function addRecipesForAssemblyDirectorSystem(float $amountOf_AssemblyDirectorSystem) {
		$amountOf_AssemblyDirectorSystemRecipe = $amountOf_AssemblyDirectorSystem / .75;
		
		$this->Home_______Space1_9->addRecipe______________('Recipe_SpaceElevatorPart_7_C', 1*$amountOf_AssemblyDirectorSystemRecipe); // Assembly Director System
		$this->Home_______Space1_9->addRecipe______________  ('Recipe_SpaceElevatorPart_5_C', 1.5*$amountOf_AssemblyDirectorSystemRecipe); // Adaptive Control Unit
		
		$this->Home_______Space1_9->addRecipe______________    ('Recipe_SpaceElevatorPart_3_C', 3*$amountOf_AssemblyDirectorSystemRecipe); // Automated Wiring
		$this->Home_______Space1_9->addRecipeForProduce2___      ('Stator', 7.5*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Forest________Steel->addRecipeForProduce2___        ('Steel Pipe', 22.5*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Forest________Steel->addRecipeForProduce2___          ('Steel Ingot', 33.75*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Forest________Steel->addRecipeForProduce____            ('Miner Mk.1: Iron Ore', 'Iron Ore', 33.75*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Forest________Steel->addRecipeForProduce____            ('Miner Mk.1: Coal', 'Coal', 33.75*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___        ('Wire', 60*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___          ('Copper Ingot', 30*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____            ('Miner Mk.1: Copper Ore', 'Copper Ore', 30*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___      ('Cable', 150*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___        ('Wire', 300*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___          ('Copper Ingot', 150*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____            ('Miner Mk.1: Copper Ore', 'Copper Ore', 150*$amountOf_AssemblyDirectorSystemRecipe);
		
		$this->Home_______Space1_9->addRecipeForProduce2___    ('Circuit Board', 7.5*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___      ('Copper Sheet', 15*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___        ('Copper Ingot', 30*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____          ('Miner Mk.1: Copper Ore', 'Copper Ore', 30*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9__addRecipesForProduce2__      ('Plastic Power', 30*$amountOf_AssemblyDirectorSystemRecipe);
		
		$this->Home_______Space1_9->addRecipeForProduce2___    ('Heavy Modular Frame', 1.5*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Forest________Steel->addRecipeForProduce2___      ('Steel Pipe', 30*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Forest________Steel->addRecipeForProduce2___        ('Steel Ingot', 45*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Forest________Steel->addRecipeForProduce____          ('Miner Mk.1: Iron Ore', 'Iron Ore', 45*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Forest________Steel->addRecipeForProduce____          ('Miner Mk.1: Coal', 'Coal', 45*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___      ('Encased Industrial Beam', 7.5*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___        ('Concrete', 45*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____          ('Miner Mk.1: Limestone', 'Limestone', 135*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Forest________Steel->addRecipeForProduce2___        ('Steel Beam', 22.5*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Forest________Steel->addRecipeForProduce2___          ('Steel Ingot', 90*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Forest________Steel->addRecipeForProduce____            ('Miner Mk.1: Iron Ore', 'Iron Ore', 90*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Forest________Steel->addRecipeForProduce____            ('Miner Mk.1: Coal', 'Coal', 90*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___      ('Modular Frame', 7.5*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___        ('Reinforced Iron Plate', 11.25*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___          ('Iron Plate', 67.5*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___            ('Iron Ingot', 101.25*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____              ('Miner Mk.1: Iron Ore', 'Iron Ore', 101.25*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___          ('Screws', 135*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___            ('Iron Rod', 33.75*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___              ('Iron Ingot', 33.75*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____                ('Miner Mk.1: Iron Ore', 'Iron Ore', 33.75*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___        ('Iron Rod', 45*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___          ('Iron Ingot', 45*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____            ('Miner Mk.1: Iron Ore', 'Iron Ore', 45*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___      ('Screws', 180*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___        ('Iron Rod', 45*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___          ('Iron Ingot', 45*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____            ('Miner Mk.1: Iron Ore', 'Iron Ore', 45*$amountOf_AssemblyDirectorSystemRecipe);
		
		$this->Home_______Space1_9->addRecipeForProduce2___    ('Computer', 3*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___      ('Circuit Board', 12*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___        ('Copper Sheet', 24*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___          ('Copper Ingot', 48*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____            ('Miner Mk.1: Copper Ore', 'Copper Ore', 48*$amountOf_AssemblyDirectorSystemRecipe);
		$this->___________OilPower->addRecipeForProduce2___        ('Plastic', 48*$amountOf_AssemblyDirectorSystemRecipe);
		$this->___________OilPower->addRecipeForProduce____          ('Oil Extractor: Crude Oil', 'Crude Oil', 72000*$amountOf_AssemblyDirectorSystemRecipe);
		$this->___________OilPower->addRecipeForConsume____            ('Residual Fuel', 'Heavy Oil Residue', (72000/3)*$amountOf_AssemblyDirectorSystemRecipe);
		$this->___________OilPower->addRecipeByDisplayName_               ('Fuel Power', (((72000/3)*(2/3))/20000)*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___      ('Cable', 24*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___        ('Wire', 48*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___          ('Copper Ingot', 24*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____            ('Miner Mk.1: Copper Ore', 'Copper Ore', 24*$amountOf_AssemblyDirectorSystemRecipe);
		$this->___________OilPower->addRecipeForProduce2___      ('Plastic', 48*$amountOf_AssemblyDirectorSystemRecipe);
		$this->___________OilPower->addRecipeForProduce____        ('Oil Extractor: Crude Oil', 'Crude Oil', 72000*$amountOf_AssemblyDirectorSystemRecipe);
		$this->___________OilPower->addRecipeForConsume____          ('Residual Fuel', 'Heavy Oil Residue', (72000/3)*$amountOf_AssemblyDirectorSystemRecipe);
		$this->___________OilPower->addRecipeByDisplayName_             ('Fuel Power', (((72000/3)*(2/3))/20000)*$amountOf_AssemblyDirectorSystemRecipe);
		
		$this->Home_______Space1_9->addRecipeForProduce2___  ('Supercomputer', 0.75*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___    ('AI Limiter', 1.5*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___      ('Copper Sheet', 7.5*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___        ('Copper Ingot', 15*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____          ('Miner Mk.1: Copper Ore', 'Copper Ore', 15*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___      ('Quickwire', 30*$amountOf_AssemblyDirectorSystemRecipe);
		$this->___________Caterium->addRecipeForProduce2___        ('Caterium Ingot', 6*$amountOf_AssemblyDirectorSystemRecipe);
		$this->___________Caterium->addRecipeForProduce____          ('Miner Mk.1: Caterium Ore', 'Caterium Ore', 18*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___    ('High-Speed Connector', 2.25*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___      ('Quickwire', 126*$amountOf_AssemblyDirectorSystemRecipe);
		$this->___________Caterium->addRecipeForProduce2___        ('Caterium Ingot', 25.2*$amountOf_AssemblyDirectorSystemRecipe);
		$this->___________Caterium->addRecipeForProduce____          ('Miner Mk.1: Caterium Ore', 'Caterium Ore', 75.6*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___      ('Cable', 22.5*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___        ('Wire', 45*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___          ('Copper Ingot', 22.5*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____            ('Miner Mk.1: Copper Ore', 'Copper Ore', 22.5*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___      ('Circuit Board', 2.25*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___        ('Copper Sheet', 4.5*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___          ('Copper Ingot', 9*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____             ('Miner Mk.1: Copper Ore', 'Copper Ore', 9*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9__addRecipesForProduce2__        ('Plastic Power', 9*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___    ('Computer', 3*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9__addRecipesForProduce2__      ('Plastic Power', 69*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___      ('Circuit Board', 12*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9__addRecipesForProduce2__        ('Plastic Power', 48*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___        ('Copper Sheet', 24*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___          ('Copper Ingot', 48*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____             ('Miner Mk.1: Copper Ore', 'Copper Ore', 48*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___      ('Cable', 24*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___        ('Wire', 48*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___          ('Copper Ingot', 24*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____            ('Miner Mk.1: Copper Ore', 'Copper Ore', 24*$amountOf_AssemblyDirectorSystemRecipe);
	}

	public function addRecipesForThermalPropulsionRocket(float $amountOf_ThermalPropulsionRocket) {
		$amountOf_ThermalPropulsionRocketRecipe = $amountOf_ThermalPropulsionRocket / 1;
		
		$this->Home_______Space1_9->addRecipe______________('Recipe_SpaceElevatorPart_8_C', 1*$amountOf_ThermalPropulsionRocketRecipe); // Thermal Propulsion Rocket

		// Modular Engine
		$this->Home_______Space1_9->addRecipe______________  ('Recipe_SpaceElevatorPart_4_C', 2.5*$amountOf_ThermalPropulsionRocketRecipe); // Modular Engine
		$this->Home_______Space1_9->addRecipeForProduce2___    ('Motor', 5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___      ('Rotor', 10*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___        ('Iron Rod', 50*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___          ('Iron Ingot', 50*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____            ('Miner Mk.1: Iron Ore', 'Iron Ore', 50*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___        ('Screws', 250*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___          ('Iron Rod', 62.5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___            ('Iron Ingot', 62.5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____              ('Miner Mk.1: Iron Ore', 'Iron Ore', 62.5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___      ('Stator', 10*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Forest________Steel->addRecipeForProduce2___        ('Steel Pipe', 30*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Forest________Steel->addRecipeForProduce2___          ('Steel Ingot', 45*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Forest________Steel->addRecipeForProduce____            ('Miner Mk.1: Iron Ore', 'Iron Ore', 45*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Forest________Steel->addRecipeForProduce____            ('Miner Mk.1: Coal', 'Coal', 45*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___        ('Wire', 80*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___          ('Copper Ingot', 40*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____            ('Miner Mk.1: Copper Ore', 'Copper Ore', 40*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9__addRecipesForProduce2__    ('Rubber Power', 37.5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipe______________    ('Recipe_SpaceElevatorPart_1_C', 2.5*$amountOf_ThermalPropulsionRocketRecipe); // Smart Plating
		$this->Home_______Space1_9->addRecipeForProduce2___      ('Rotor', 5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___        ('Iron Rod', 25*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___          ('Iron Ingot', 25*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____            ('Miner Mk.1: Iron Ore', 'Iron Ore', 25*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___        ('Screws', 125*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___          ('Iron Rod', 31.25*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___            ('Iron Ingot', 31.25*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____              ('Miner Mk.1: Iron Ore', 'Iron Ore', 31.25*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___      ('Reinforced Iron Plate', 5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___        ('Iron Plate', 30*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___          ('Iron Ingot', 45*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____            ('Miner Mk.1: Iron Ore', 'Iron Ore', 45*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___        ('Screws', 60*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___          ('Iron Rod', 15*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___            ('Iron Ingot', 15*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____              ('Miner Mk.1: Iron Ore', 'Iron Ore', 15*$amountOf_ThermalPropulsionRocketRecipe);

		// Turbo Motor
		$this->Home_______Space1_9->addRecipeForProduce2___  ('Turbo Motor', 1*$amountOf_ThermalPropulsionRocketRecipe);

		// Turbo Motor: Motor
		$this->Home_______Space1_9->addRecipeForProduce2___    ('Motor', 4*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___      ('Rotor', 8*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___        ('Iron Rod', 40*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___          ('Iron Ingot', 40*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____            ('Miner Mk.1: Iron Ore', 'Iron Ore', 40*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___        ('Screws', 200*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___          ('Iron Rod', 50*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___            ('Iron Ingot', 50*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____              ('Miner Mk.1: Iron Ore', 'Iron Ore', 50*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___      ('Stator', 8*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Forest________Steel->addRecipeForProduce2___        ('Steel Pipe', 24*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Forest________Steel->addRecipeForProduce2___          ('Steel Ingot', 36*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Forest________Steel->addRecipeForProduce____            ('Miner Mk.1: Iron Ore', 'Iron Ore', 36*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Forest________Steel->addRecipeForProduce____            ('Miner Mk.1: Coal', 'Coal', 36*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___        ('Wire', 64*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___          ('Copper Ingot', 32*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____            ('Miner Mk.1: Copper Ore', 'Copper Ore', 32*$amountOf_ThermalPropulsionRocketRecipe);

		// Turbo Motor: Rubber
		$this->Home_______Space1_9__addRecipesForProduce2__    ('Rubber Power', 24*$amountOf_ThermalPropulsionRocketRecipe);

		// Turbo Motor: Cooling System
		$this->Home_______Space1_9->addRecipeForProduce2___    ('Cooling System', 4*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9__addRecipesForProduce2__      ('Rubber Power', 8*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___      ('Heat Sink', 8*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9__addRecipesForProduce2__        ('Alclad Aluminum Sheet', 40*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___        ('Copper Sheet', 24*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___          ('Copper Ingot', 48*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____            ('Miner Mk.1: Copper Ore', 'Copper Ore', 48*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____      ('Unpackage Water', 'Water', 20000*$amountOf_ThermalPropulsionRocketRecipe);
		$this->___________Nitrogen->addRecipeForConsume____        ('Packaged Water', 'Water', 20000*$amountOf_ThermalPropulsionRocketRecipe);
		$this->___________Nitrogen->addRecipeForProduce____          ('Water Extractor: Water', 'Water', 20000*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____      ('Unpackage Nitrogen Gas', 'Nitrogen Gas', 100000*$amountOf_ThermalPropulsionRocketRecipe);
		$this->___________Nitrogen->addRecipeForConsume____        ('Packaged Nitrogen Gas', 'Nitrogen Gas', 100000*$amountOf_ThermalPropulsionRocketRecipe);
		$this->___________Nitrogen->addRecipeForProduce____          ('Resource Well Extractor: Nitrogen Gas', 'Nitrogen Gas', 100000*$amountOf_ThermalPropulsionRocketRecipe);

		// Turbo Motor: Radio Control Unit
		$this->Home_______Space1_9->addRecipeForProduce2___    ('Radio Control Unit', 2*$amountOf_ThermalPropulsionRocketRecipe);
		$this->___________Aluminum->addRecipeForProduce2___      ('Aluminum Casing', 32*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9__addRecipesForProduce2__        ('Aluminum Ingot', 48*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___      ('Crystal Oscillator', 1*$amountOf_ThermalPropulsionRocketRecipe);
		$this->_____________Quartz->addRecipeForProduce2___        ('Quartz Crystal', 18*$amountOf_ThermalPropulsionRocketRecipe);
		$this->_____________Quartz->addRecipeForProduce____          ('Miner Mk.1: Raw Quartz', 'Raw Quartz', 30*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___        ('Cable', 14*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___          ('Wire', 28*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___            ('Copper Ingot', 14*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____              ('Miner Mk.1: Copper Ore', 'Copper Ore', 14*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___        ('Reinforced Iron Plate', 2.5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___          ('Iron Plate', 15*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___            ('Iron Ingot', 22.5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____              ('Miner Mk.1: Iron Ore', 'Iron Ore', 22.5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___          ('Screws', 30*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___            ('Iron Rod', 7.5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___              ('Iron Ingot', 7.5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____                ('Miner Mk.1: Iron Ore', 'Iron Ore', 7.5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___      ('Computer', 2*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___        ('Circuit Board', 8*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___          ('Copper Sheet', 16*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___            ('Copper Ingot', 32*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____              ('Miner Mk.1: Copper Ore', 'Copper Ore', 32*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___        ('Cable', 16*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___          ('Wire', 32*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___            ('Copper Ingot', 16*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____              ('Miner Mk.1: Copper Ore', 'Copper Ore', 16*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9__addRecipesForProduce2__        ('Plastic Power', 64*$amountOf_ThermalPropulsionRocketRecipe);

		// Cooling System
		$this->Home_______Space1_9->addRecipeForProduce2___    ('Cooling System', 3*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9__addRecipesForProduce2__      ('Rubber Power', 6*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___      ('Heat Sink', 6*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9__addRecipesForProduce2__        ('Alclad Aluminum Sheet', 30*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___        ('Copper Sheet', 18*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___          ('Copper Ingot', 36*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____             ('Miner Mk.1: Copper Ore', 'Copper Ore', 36*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____      ('Unpackage Water', 'Water', 15000*$amountOf_ThermalPropulsionRocketRecipe);
		$this->___________Nitrogen->addRecipeForConsume____        ('Packaged Water', 'Water', 15000*$amountOf_ThermalPropulsionRocketRecipe);
		$this->___________Nitrogen->addRecipeForProduce____          ('Water Extractor: Water', 'Water', 15000*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____      ('Unpackage Nitrogen Gas', 'Nitrogen Gas', 75000*$amountOf_ThermalPropulsionRocketRecipe);
		$this->___________Nitrogen->addRecipeForConsume____        ('Packaged Nitrogen Gas', 'Nitrogen Gas', 75000*$amountOf_ThermalPropulsionRocketRecipe);
		$this->___________Nitrogen->addRecipeForProduce____          ('Resource Well Extractor: Nitrogen Gas', 'Nitrogen Gas', 75000*$amountOf_ThermalPropulsionRocketRecipe);

		// Fused Modular Frame
		$this->Home_______Space1_9->addRecipeForProduce2___  ('Fused Modular Frame', 1*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____    ('Unpackage Nitrogen Gas', 'Nitrogen Gas', 25000*$amountOf_ThermalPropulsionRocketRecipe);
		$this->___________Nitrogen->addRecipeForConsume____      ('Packaged Nitrogen Gas', 'Nitrogen Gas', 25000*$amountOf_ThermalPropulsionRocketRecipe);
		$this->___________Nitrogen->addRecipeForProduce____        ('Resource Well Extractor: Nitrogen Gas', 'Nitrogen Gas', 25000*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___    ('Heavy Modular Frame', 1*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Forest________Steel->addRecipeForProduce2___       ('Steel Pipe', 20*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Forest________Steel->addRecipeForProduce2___         ('Steel Ingot', 30*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Forest________Steel->addRecipeForProduce____          ('Miner Mk.1: Iron Ore', 'Iron Ore', 30*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Forest________Steel->addRecipeForProduce____          ('Miner Mk.1: Coal', 'Coal', 30*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___      ('Encased Industrial Beam', 5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___        ('Concrete', 30*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____           ('Miner Mk.1: Limestone', 'Limestone', 90*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Forest________Steel->addRecipeForProduce2___        ('Steel Beam', 15*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Forest________Steel->addRecipeForProduce2___          ('Steel Ingot', 60*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Forest________Steel->addRecipeForProduce____             ('Miner Mk.1: Iron Ore', 'Iron Ore', 60*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Forest________Steel->addRecipeForProduce____             ('Miner Mk.1: Coal', 'Coal', 60*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___       ('Modular Frame', 5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___         ('Reinforced Iron Plate', 7.5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___           ('Iron Plate', 45*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___             ('Iron Ingot', 67.5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____              ('Miner Mk.1: Iron Ore', 'Iron Ore', 67.5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___           ('Screws', 90*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___             ('Iron Rod', 22.5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___               ('Iron Ingot', 22.5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____                ('Miner Mk.1: Iron Ore', 'Iron Ore', 22.5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___         ('Iron Rod', 30*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___           ('Iron Ingot', 30*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____            ('Miner Mk.1: Iron Ore', 'Iron Ore', 30*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___       ('Screws', 120*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___         ('Iron Rod', 30*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___           ('Iron Ingot', 30*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____            ('Miner Mk.1: Iron Ore', 'Iron Ore', 30*$amountOf_ThermalPropulsionRocketRecipe);
		$this->___________Aluminum->addRecipeForProduce2___    ('Aluminum Casing', 50*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Home_______Space1_9__addRecipesForProduce2__      ('Aluminum Ingot', 75*$amountOf_ThermalPropulsionRocketRecipe);
	}

	public function addRecipesForNuclearPasta(float $amountOf_NuclearPasta) {
		$amountOf_NuclearPastaRecipe = $amountOf_NuclearPasta / .5;
		
		$this->Home_______Space1_9->addRecipe______________  ('Recipe_SpaceElevatorPart_9_C', 1*$amountOf_NuclearPastaRecipe); // Nuclear Pasta

		$this->Home_______Space1_9->addRecipeForProduce2___  ('Copper Powder', 100*$amountOf_NuclearPastaRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___    ('Copper Ingot', 600*$amountOf_NuclearPastaRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____       ('Miner Mk.1: Copper Ore', 'Copper Ore', 600*$amountOf_NuclearPastaRecipe);

		$this->Home_______Space1_9->addRecipeForProduce2___  ('Pressure Conversion Cube', 0.5*$amountOf_NuclearPastaRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___    ('Radio Control Unit', 1*$amountOf_NuclearPastaRecipe);
		$this->___________Aluminum->addRecipeForProduce2___      ('Aluminum Casing', 16*$amountOf_NuclearPastaRecipe);
		$this->Home_______Space1_9__addRecipesForProduce2__        ('Aluminum Ingot', 24*$amountOf_NuclearPastaRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___      ('Crystal Oscillator', 0.5*$amountOf_NuclearPastaRecipe);
		$this->_____________Quartz->addRecipeForProduce2___         ('Quartz Crystal', 9*$amountOf_NuclearPastaRecipe);
		$this->_____________Quartz->addRecipeForProduce____            ('Miner Mk.1: Raw Quartz', 'Raw Quartz', 15*$amountOf_NuclearPastaRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___        ('Cable', 7*$amountOf_NuclearPastaRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___          ('Wire', 14*$amountOf_NuclearPastaRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___            ('Copper Ingot', 7*$amountOf_NuclearPastaRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____               ('Miner Mk.1: Copper Ore', 'Copper Ore', 7*$amountOf_NuclearPastaRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___        ('Reinforced Iron Plate', 1.25*$amountOf_NuclearPastaRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___          ('Iron Plate', 7.5*$amountOf_NuclearPastaRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___            ('Iron Ingot', 11.25*$amountOf_NuclearPastaRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____               ('Miner Mk.1: Iron Ore', 'Iron Ore', 11.25*$amountOf_NuclearPastaRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___          ('Screws', 15*$amountOf_NuclearPastaRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___            ('Iron Rod', 3.75*$amountOf_NuclearPastaRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___              ('Iron Ingot', 3.75*$amountOf_NuclearPastaRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____                 ('Miner Mk.1: Iron Ore', 'Iron Ore', 3.75*$amountOf_NuclearPastaRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___      ('Computer', 1*$amountOf_NuclearPastaRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___        ('Circuit Board', 4*$amountOf_NuclearPastaRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___          ('Copper Sheet', 8*$amountOf_NuclearPastaRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___            ('Copper Ingot', 16*$amountOf_NuclearPastaRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____               ('Miner Mk.1: Copper Ore', 'Copper Ore', 16*$amountOf_NuclearPastaRecipe);
		$this->Home_______Space1_9__addRecipesForProduce2__          ('Plastic Power', 16*$amountOf_NuclearPastaRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___        ('Cable', 8*$amountOf_NuclearPastaRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___          ('Wire', 16*$amountOf_NuclearPastaRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___            ('Copper Ingot', 8*$amountOf_NuclearPastaRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____               ('Miner Mk.1: Copper Ore', 'Copper Ore', 8*$amountOf_NuclearPastaRecipe);
		$this->Home_______Space1_9__addRecipesForProduce2__        ('Plastic Power', 16*$amountOf_NuclearPastaRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___    ('Fused Modular Frame', 0.5*$amountOf_NuclearPastaRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___      ('Heavy Modular Frame', 0.5*$amountOf_NuclearPastaRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___        ('Modular Frame', 2.5*$amountOf_NuclearPastaRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___          ('Reinforced Iron Plate', 3.75*$amountOf_NuclearPastaRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___            ('Iron Plate', 22.5*$amountOf_NuclearPastaRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___              ('Iron Ingot', 33.75*$amountOf_NuclearPastaRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____                ('Miner Mk.1: Iron Ore', 'Iron Ore', 33.75*$amountOf_NuclearPastaRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___            ('Screws', 45*$amountOf_NuclearPastaRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___              ('Iron Rod', 11.25*$amountOf_NuclearPastaRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___                ('Iron Ingot', 11.25*$amountOf_NuclearPastaRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____                  ('Miner Mk.1: Iron Ore', 'Iron Ore', 11.25*$amountOf_NuclearPastaRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___          ('Iron Rod', 15*$amountOf_NuclearPastaRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___            ('Iron Ingot', 15*$amountOf_NuclearPastaRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____              ('Miner Mk.1: Iron Ore', 'Iron Ore', 15*$amountOf_NuclearPastaRecipe);
		$this->Forest________Steel->addRecipeForProduce2___        ('Steel Pipe', 10*$amountOf_NuclearPastaRecipe);
		$this->Forest________Steel->addRecipeForProduce2___          ('Steel Ingot', 15*$amountOf_NuclearPastaRecipe);
		$this->Forest________Steel->addRecipeForProduce____            ('Miner Mk.1: Iron Ore', 'Iron Ore', 15*$amountOf_NuclearPastaRecipe);
		$this->Forest________Steel->addRecipeForProduce____            ('Miner Mk.1: Coal', 'Coal', 15*$amountOf_NuclearPastaRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___        ('Encased Industrial Beam', 2.5*$amountOf_NuclearPastaRecipe);
		$this->Forest________Steel->addRecipeForProduce2___          ('Steel Beam', 7.5*$amountOf_NuclearPastaRecipe);
		$this->Forest________Steel->addRecipeForProduce2___            ('Steel Ingot', 30*$amountOf_NuclearPastaRecipe);
		$this->Forest________Steel->addRecipeForProduce____              ('Miner Mk.1: Iron Ore', 'Iron Ore', 30*$amountOf_NuclearPastaRecipe);
		$this->Forest________Steel->addRecipeForProduce____              ('Miner Mk.1: Coal', 'Coal', 30*$amountOf_NuclearPastaRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___          ('Concrete', 15*$amountOf_NuclearPastaRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____            ('Miner Mk.1: Limestone', 'Limestone', 45*$amountOf_NuclearPastaRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___        ('Screws', 60*$amountOf_NuclearPastaRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___          ('Iron Rod', 15*$amountOf_NuclearPastaRecipe);
		$this->Home_______Space1_9->addRecipeForProduce2___            ('Iron Ingot', 15*$amountOf_NuclearPastaRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____              ('Miner Mk.1: Iron Ore', 'Iron Ore', 15*$amountOf_NuclearPastaRecipe);
		$this->___________Aluminum->addRecipeForProduce2___      ('Aluminum Casing', 25*$amountOf_NuclearPastaRecipe);
		$this->Home_______Space1_9__addRecipesForProduce2__        ('Aluminum Ingot', 37.5*$amountOf_NuclearPastaRecipe);
		$this->Home_______Space1_9->addRecipeForProduce____      ('Unpackage Nitrogen Gas', 'Nitrogen Gas', 12500*$amountOf_NuclearPastaRecipe);
		$this->___________Nitrogen->addRecipeForConsume____        ('Packaged Nitrogen Gas', 'Nitrogen Gas', 12500*$amountOf_NuclearPastaRecipe);
		$this->___________Nitrogen->addRecipeForProduce____          ('Resource Well Extractor: Nitrogen Gas', 'Nitrogen Gas', 12500*$amountOf_NuclearPastaRecipe);
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
		$this->ELSEWHERE_ELSEWHERE__addRecipesForProduce2__      ('Plastic Power', 28*$amountOf_AIExpansionServer);
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
		$this->ELSEWHERE_ELSEWHERE__addRecipesForProduce2__          ('Plastic Power', 12*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___      ('Computer', (4/3)*3*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE__addRecipesForProduce2__        ('Plastic Power', 64*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___        ('Circuit Board', (4/3)*12*$amountOf_AIExpansionServer);
		$this->ELSEWHERE_ELSEWHERE__addRecipesForProduce2__          ('Plastic Power', 64*$amountOf_AIExpansionServer);
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
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____('Synthetic Power Shard', 'Power Shard',  $amountOf_PowerShard);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___  ('Time Crystal', 2 * $amountOf_PowerShard);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___    ('Diamonds', 6 * $amountOf_PowerShard);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____      ('Miner Mk.1: Coal', 'Coal', 120 * $amountOf_PowerShard);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___  ('Dark Matter Crystal', 2 * $amountOf_PowerShard);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___  ('Quartz Crystal', 12 * $amountOf_PowerShard);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____    ('Miner Mk.1: Raw Quartz', 'Raw Quartz', 20 * $amountOf_PowerShard);
		$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___  ('Excited Photonic Matter', 12000 * $amountOf_PowerShard);
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
		} elseif ('Plastic Power' == $expectedProductDisplayName) {
			$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___('Plastic', $expectedProductAmount);
			$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____  ('Oil Extractor: Crude Oil', 'Crude Oil', 1500*$expectedProductAmount);
			$this->ELSEWHERE_ELSEWHERE->addRecipeForConsume____    ('Residual Fuel', 'Heavy Oil Residue', 500*$expectedProductAmount);
			$this->ELSEWHERE_ELSEWHERE->addRecipeByDisplayName_      ('Fuel Power', (.5/30)*$expectedProductAmount);
		} elseif ('Recycled Plastic Power' == $expectedProductDisplayName) {
			$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____('Alternate: Recycled Plastic', 'Plastic', $expectedProductAmount);
			$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___  ('Rubber', 0.5*$expectedProductAmount);
			$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____    ('Oil Extractor: Crude Oil', 'Crude Oil', 750*$expectedProductAmount);
			$this->ELSEWHERE_ELSEWHERE->addRecipeForConsume____  ('Alternate: Diluted Packaged Fuel', 'Heavy Oil Residue', 500*$expectedProductAmount);
			$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce2___    ('Packaged Water', 1*$expectedProductAmount);
			$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____      ('Water Extractor: Water', 'Water', 1000*$expectedProductAmount);
			$this->ELSEWHERE_ELSEWHERE->addRecipeForProduce____    ('Unpackage Fuel', 'Fuel', 1000*$expectedProductAmount);
			$this->ELSEWHERE_ELSEWHERE->addRecipeForConsume____      ('Fuel Power', 'Fuel', 500*$expectedProductAmount);
		} elseif ('Rubber Power' == $expectedProductDisplayName) {
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

	private function Home_______Space1_9__addRecipesForProduce2__(string $expectedProductDisplayName, float $expectedProductAmount) {
		if ('Alclad Aluminum Sheet' == $expectedProductDisplayName) {
			$this->___________Aluminum->addRecipeForProduce2___('Alclad Aluminum Sheet', $expectedProductAmount);
			$this->___________Aluminum->addRecipeForProduce2___  ('Copper Ingot', (1/3)*$expectedProductAmount);
			$this->___________Aluminum->addRecipeForProduce____     ('Miner Mk.1: Copper Ore', 'Copper Ore', (1/3)*$expectedProductAmount);
			$this->___________Aluminum->addRecipeForProduce2___  ('Aluminum Ingot', $expectedProductAmount);
			$this->___________Aluminum->addRecipeForProduce2___    ('Aluminum Scrap', 1.5*$expectedProductAmount);
			$this->___________Aluminum->addRecipeForProduce____      ('Miner Mk.1: Coal', 'Coal', 0.5*$expectedProductAmount);
			$this->___________Aluminum->addRecipeForProduce2___      ('Alumina Solution', 1000*$expectedProductAmount); // Residue : Silica
			$this->___________Aluminum->addRecipeForProduce____         ('Miner Mk.1: Bauxite', 'Bauxite', 1*$expectedProductAmount);
			$this->___________Aluminum->addRecipeForProduce____         ('Water Extractor: Water', 'Water', 1000*$expectedProductAmount);
			$this->___________Aluminum->addRecipeForProduce2___     ('Silica', (5/6)*$expectedProductAmount); // Soustraire la quantite produite par la recette : Alumina Solution
			$this->___________Aluminum->addRecipeForProduce____        ('Miner Mk.1: Raw Quartz', 'Raw Quartz', 0.5*$expectedProductAmount);
		} elseif ('Aluminum Ingot' == $expectedProductDisplayName) {
			$this->___________Aluminum->addRecipeForProduce2___('Aluminum Ingot', $expectedProductAmount);
			$this->___________Aluminum->addRecipeForProduce2___  ('Aluminum Scrap', 1.5*$expectedProductAmount);
			$this->___________Aluminum->addRecipeForProduce____    ('Miner Mk.1: Coal', 'Coal', 0.5*$expectedProductAmount);
			$this->___________Aluminum->addRecipeForProduce2___    ('Alumina Solution', 1000*$expectedProductAmount); // Residue : Silica
			$this->___________Aluminum->addRecipeForProduce____       ('Miner Mk.1: Bauxite', 'Bauxite', 1*$expectedProductAmount);
			$this->___________Aluminum->addRecipeForProduce____       ('Water Extractor: Water', 'Water', 1000*$expectedProductAmount);
			$this->___________Aluminum->addRecipeForProduce2___   ('Silica', (5/6)*$expectedProductAmount); // Soustraire la quantite produite par la recette : Alumina Solution
			$this->___________Aluminum->addRecipeForProduce____      ('Miner Mk.1: Raw Quartz', 'Raw Quartz', 0.5*$expectedProductAmount);
		} elseif ('Plastic Power' == $expectedProductDisplayName) {
			$this->___________OilPower->addRecipeForProduce2___('Plastic', $expectedProductAmount);
			$this->___________OilPower->addRecipeForProduce____  ('Oil Extractor: Crude Oil', 'Crude Oil', 1500*$expectedProductAmount);
			$this->___________OilPower->addRecipeForConsume____    ('Residual Fuel', 'Heavy Oil Residue', 500*$expectedProductAmount);
			$this->___________OilPower->addRecipeByDisplayName_      ('Fuel Power', (.5/30)*$expectedProductAmount);
		} elseif ('Rubber Power' == $expectedProductDisplayName) {
			$this->___________OilPower->addRecipeForProduce2___    ('Rubber', $expectedProductAmount);
			$this->___________OilPower->addRecipeForProduce____       ('Oil Extractor: Crude Oil', 'Crude Oil', 1500*$expectedProductAmount);
			$this->___________OilPower->addRecipeForConsume____         ('Residual Fuel', 'Heavy Oil Residue', 1000*$expectedProductAmount);
			$this->___________OilPower->addRecipeByDisplayName_           ('Fuel Power', (1.25/37.5)*$expectedProductAmount);
		} else {
			throw new Exception($expectedProductDisplayName);
		}
	}

}

$marais = new KemenyendeTheForest(false);
$marais->proceed();
