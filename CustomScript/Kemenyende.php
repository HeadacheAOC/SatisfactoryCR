<?php
use FactoryGame\Factory;
use FactoryGame\Region;

class Kemenyende extends Region {

	private ?Factory $DesertS__CoppPwdr = null;
	private ?Factory $DesertE___AutoWir = null;
	private ?Factory $DesertNE____MFGen = null;
	private ?Factory $DesertNO_CompCoal = null;
	private ?Factory $DesertSO___Canyon = null;
	private ?Factory $LitoralN__Derrick = null;

	private ?Factory $HUB___________HUB = null;

	private ?Factory $MaraisNO___Quartz = null;
	private ?Factory $MaraisE___Bauxite = null;
	private ?Factory $MaraisSE__CrudOil = null;
	private ?Factory $MaraisS__Nitrogen = null;

	protected function step1_addFactories() {
		$this->DesertS__CoppPwdr = $this->addFactory('Desert: Copper Powder (Sud)');
		$this->DesertE___AutoWir = $this->addFactory('Desert: Automated Wiring (Est)');
		$this->DesertNE____MFGen = $this->addFactory('Desert: Magnetic Field Generator (Nord-Est)');
		$this->DesertNO_CompCoal = $this->addFactory('Desert: Compacted Coal (Nord-Ouest)');
		$this->DesertSO___Canyon = $this->addFactory('Canyon: Adaptive Control Unit & Modular Engine');
		$this->LitoralN__Derrick = $this->addFactory('Derrick: Power Fuel');

		$this->HUB___________HUB = $this->addFactory('Relais (HUB)');

		$this->MaraisNO___Quartz = $this->addFactory('Marais: Quartz (Nord-Ouest)');
		$this->MaraisE___Bauxite = $this->addFactory('Marais: Bauxite (Est)');
		$this->MaraisS__Nitrogen = $this->addFactory('Marais: Nitrogen (Sud)');
		$this->MaraisSE__CrudOil = $this->addFactory('Marais: Crud Oil (Sud-Est)');
	}

	protected function step2_addRecipes() {
		$this->addRecipesForLitoralDerrickFactory(480/13.5);

		$this->addRecipesForAssemblyDirectorSystem(1/0.75);
		$this->addRecipesForMagneticFieldGenerator(480/96.75);
		$this->addRecipesForThermalPropulsionRocket(1);
		$this->addRecipesForNuclearPasta(2);


		$this->addRecipesForBiochemicalScultor(0.5);
		$this->addRecipesForBallisticWarpDrive(0.5);
		$this->addRecipesForAIExpansionServer(0.5);

		// Transformer l'excedent liquide pour le transport par train
		$this->MaraisS__Nitrogen->addRecipeForConsume____('Dark Matter Crystal', 'Dark Matter Residue', 50000);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___  ('Diamonds', 10);
		$this->MaraisS__Nitrogen->addRecipeForProduce____  ('Miner Mk.1: Coal', 'Coal', 200);
	}

	protected function step4_Supply() {

		// Nord-Express :  'Relais (HUB)' -> 'Desert: Copper Powder (Sud)' -> 'Desert: Automated Wiring (Est)' -> 'Desert: Magnetic Field Generator (Nord-Est)' -> 'Desert: Compacted Coal (Nord-Ouest)' -> 'Canyon: Adaptive Control Unit & Modular Engine' -> 'Derrick: Power Fuel'
		$this->supply($this->DesertSO___Canyon, $this->DesertNE____MFGen, 'Coal');
		$this->supply($this->DesertSO___Canyon, $this->DesertE___AutoWir, 'Automated Wiring');
		$this->supply($this->LitoralN__Derrick, $this->DesertNO_CompCoal, 'Compacted Coal');


		// Nord-Express -> Marais
		$this->supply($this->MaraisE___Bauxite, $this->DesertS__CoppPwdr, 'Copper Powder');
		$this->supply($this->MaraisE___Bauxite, $this->DesertSO___Canyon, 'Adaptive Control Unit');
		$this->supply($this->MaraisE___Bauxite, $this->DesertSO___Canyon, 'Modular Engine');
		$this->supply($this->MaraisS__Nitrogen, $this->DesertNE____MFGen, 'Magnetic Field Generator');


		// Marais : 'Relais (HUB)' -> 'Marais: Quartz (Nord-Ouest)' -> 'Marais: Bauxite (Est)' -> 'Marais: Nitrogen (Sud)' -> 'Marais: Crud Oil (Sud-Est)' -> 'Marais: Bauxite (Est)'

		$this->supply($this->MaraisE___Bauxite, $this->MaraisNO___Quartz, 'Silica');
		$this->supply($this->MaraisE___Bauxite, $this->MaraisNO___Quartz, 'Quartz Crystal');

		$this->supply($this->MaraisS__Nitrogen, $this->MaraisE___Bauxite, 'Concrete');
		$this->supply($this->MaraisS__Nitrogen, $this->MaraisE___Bauxite, 'Aluminum Casing');
		$this->supply($this->MaraisS__Nitrogen, $this->MaraisE___Bauxite, 'Empty Fluid Tank');

		$this->supply($this->MaraisE___Bauxite, $this->MaraisS__Nitrogen, 'Coal');
		$this->supply($this->MaraisE___Bauxite, $this->MaraisS__Nitrogen, 'Steel Pipe');
		$this->supply($this->MaraisE___Bauxite, $this->MaraisS__Nitrogen, 'Fused Modular Frame');
		$this->supply($this->MaraisE___Bauxite, $this->MaraisS__Nitrogen, 'Packaged Nitrogen Gas');

		$this->supply($this->MaraisE___Bauxite, $this->MaraisSE__CrudOil, 'Plastic');
		$this->supply($this->MaraisE___Bauxite, $this->MaraisSE__CrudOil, 'Rubber');
		$this->supply($this->MaraisE___Bauxite, $this->MaraisSE__CrudOil, 'Caterium Ingot');

		//-----

		$this->supply($this->MaraisS__Nitrogen, $this->MaraisE___Bauxite, 'Nuclear Pasta');
		$this->supply($this->MaraisS__Nitrogen, $this->MaraisE___Bauxite, 'Thermal Propulsion Rocket');
		$this->supply($this->MaraisS__Nitrogen, $this->MaraisE___Bauxite, 'Crystal Oscillator');
		$this->supply($this->MaraisS__Nitrogen, $this->MaraisE___Bauxite, 'Alclad Aluminum Sheet');
		$this->supply($this->MaraisS__Nitrogen, $this->MaraisE___Bauxite, 'Supercomputer');
		
		$this->supply($this->MaraisSE__CrudOil, $this->MaraisE___Bauxite, 'Assembly Director System');
		$this->supply($this->MaraisSE__CrudOil, $this->MaraisS__Nitrogen, 'Reanimated SAM');

		$this->supply($this->HUB___________HUB, $this->MaraisSE__CrudOil, 'Biochemical Sculptor');
		$this->supply($this->HUB___________HUB, $this->MaraisS__Nitrogen, 'Ballistic Warp Drive');
		$this->supply($this->HUB___________HUB, $this->MaraisS__Nitrogen, 'Dark Matter Crystal');
		$this->supply($this->HUB___________HUB, $this->MaraisS__Nitrogen, 'AI Expansion Server');
	}

	public function addRecipesForLitoralDerrickFactory(float $amountOf_TurbofuelPowerRecipe) {
		$this->LitoralN__Derrick->addRecipeByDisplayName_('Turbofuel Power', 1*$amountOf_TurbofuelPowerRecipe);
		$this->LitoralN__Derrick->addRecipeForProduce2___  ('Turbofuel', 7500*$amountOf_TurbofuelPowerRecipe);
		$this->LitoralN__Derrick->addRecipeForProduce2___    ('Fuel', 9000*$amountOf_TurbofuelPowerRecipe);
		$this->LitoralN__Derrick->addRecipeForProduce____      ('Oil Extractor: Crude Oil', 'Crude Oil', 13500*$amountOf_TurbofuelPowerRecipe);
		$this->DesertNO_CompCoal->addRecipeForProduce____    ('Alternate: Compacted Coal', 'Compacted Coal', 6*$amountOf_TurbofuelPowerRecipe);
		$this->DesertNO_CompCoal->addRecipeForProduce____      ('Miner Mk.1: Coal', 'Coal', 6*$amountOf_TurbofuelPowerRecipe);
		$this->DesertNO_CompCoal->addRecipeForProduce____      ('Miner Mk.1: Sulfur', 'Sulfur', 6*$amountOf_TurbofuelPowerRecipe);

		// Consommer le Polymer Resin
		$this->LitoralN__Derrick->addRecipeForConsume____('Alternate: Polyester Fabric', 'Polymer Resin', 1*(6.75/6)*$amountOf_TurbofuelPowerRecipe);
		$this->LitoralN__Derrick->addRecipeForProduce____  ('Water Extractor: Water', 'Water', 1125*$amountOf_TurbofuelPowerRecipe);
		$this->LitoralN__Derrick->addRecipeForConsume____('Residual Rubber', 'Polymer Resin', 2*(6.75/6)*$amountOf_TurbofuelPowerRecipe);
		$this->LitoralN__Derrick->addRecipeForProduce____  ('Water Extractor: Water', 'Water', 2250*$amountOf_TurbofuelPowerRecipe);
		$this->LitoralN__Derrick->addRecipeForConsume____('Residual Plastic', 'Polymer Resin', 3*(6.75/6)*$amountOf_TurbofuelPowerRecipe);
		$this->LitoralN__Derrick->addRecipeForProduce____  ('Water Extractor: Water', 'Water', 1125*$amountOf_TurbofuelPowerRecipe);
	}

	public function addRecipesForMagneticFieldGenerator(float $amountOf_MagneticFieldGeneratorRecipe) {
		$this->DesertNE____MFGen->addRecipe______________('Recipe_SpaceElevatorPart_6_C', 1*$amountOf_MagneticFieldGeneratorRecipe); // Magnetic Field Generator
		$this->DesertNE____MFGen->addRecipe______________  ('Recipe_SpaceElevatorPart_2_C', 0.5*$amountOf_MagneticFieldGeneratorRecipe); // Versatile Framework
		$this->DesertNE____MFGen->addRecipeForProduce2___    ('Modular Frame', 1.25*$amountOf_MagneticFieldGeneratorRecipe);
		$this->DesertNE____MFGen->addRecipeForProduce2___      ('Reinforced Iron Plate', 1.875*$amountOf_MagneticFieldGeneratorRecipe);
		$this->DesertNE____MFGen->addRecipeForProduce2___        ('Iron Plate', 11.25*$amountOf_MagneticFieldGeneratorRecipe);
		$this->DesertNE____MFGen->addRecipeForProduce2___          ('Iron Ingot', 16.875*$amountOf_MagneticFieldGeneratorRecipe);
		$this->DesertNE____MFGen->addRecipeForProduce____            ('Miner Mk.3: Iron Ore', 'Iron Ore', 16.875*$amountOf_MagneticFieldGeneratorRecipe);
		$this->DesertNE____MFGen->addRecipeForProduce2___        ('Screw', 22.5*$amountOf_MagneticFieldGeneratorRecipe);
		$this->DesertNE____MFGen->addRecipeForProduce2___          ('Iron Rod', 5.625*$amountOf_MagneticFieldGeneratorRecipe);
		$this->DesertNE____MFGen->addRecipeForProduce2___            ('Iron Ingot', 5.625*$amountOf_MagneticFieldGeneratorRecipe);
		$this->DesertNE____MFGen->addRecipeForProduce____              ('Miner Mk.3: Iron Ore', 'Iron Ore', 5.625*$amountOf_MagneticFieldGeneratorRecipe);
		$this->DesertNE____MFGen->addRecipeForProduce2___      ('Iron Rod', 7.5*$amountOf_MagneticFieldGeneratorRecipe);
		$this->DesertNE____MFGen->addRecipeForProduce2___        ('Iron Ingot', 7.5*$amountOf_MagneticFieldGeneratorRecipe);
		$this->DesertNE____MFGen->addRecipeForProduce____          ('Miner Mk.3: Iron Ore', 'Iron Ore', 7.5*$amountOf_MagneticFieldGeneratorRecipe);
		$this->DesertNE____MFGen->addRecipeForProduce2___    ('Steel Beam', 15*$amountOf_MagneticFieldGeneratorRecipe);
		$this->DesertNE____MFGen->addRecipeForProduce2___      ('Steel Ingot', 60*$amountOf_MagneticFieldGeneratorRecipe);
		$this->DesertNE____MFGen->addRecipeForProduce____        ('Miner Mk.3: Coal', 'Coal', 60*$amountOf_MagneticFieldGeneratorRecipe);
		$this->DesertNE____MFGen->addRecipeForProduce____        ('Miner Mk.3: Iron Ore', 'Iron Ore', 60*$amountOf_MagneticFieldGeneratorRecipe);
		$this->DesertNE____MFGen->addRecipeForProduce2___  ('Electromagnetic Control Rod', 1*$amountOf_MagneticFieldGeneratorRecipe);
		$this->DesertNE____MFGen->addRecipeForProduce2___    ('Stator', 1.5*$amountOf_MagneticFieldGeneratorRecipe);
		$this->DesertNE____MFGen->addRecipeForProduce2___      ('Steel Pipe', 4.5*$amountOf_MagneticFieldGeneratorRecipe);
		$this->DesertNE____MFGen->addRecipeForProduce2___        ('Steel Ingot', 6.75*$amountOf_MagneticFieldGeneratorRecipe);
		$this->DesertNE____MFGen->addRecipeForProduce____          ('Miner Mk.3: Coal', 'Coal', 6.75*$amountOf_MagneticFieldGeneratorRecipe);
		$this->DesertNE____MFGen->addRecipeForProduce____          ('Miner Mk.3: Iron Ore', 'Iron Ore', 6.75*$amountOf_MagneticFieldGeneratorRecipe);
		$this->DesertNE____MFGen->addRecipeForProduce2___      ('Wire', 12*$amountOf_MagneticFieldGeneratorRecipe);
		$this->DesertNE____MFGen->addRecipeForProduce2___        ('Copper Ingot', 6*$amountOf_MagneticFieldGeneratorRecipe);
		$this->DesertNE____MFGen->addRecipeForProduce____          ('Miner Mk.3: Copper Ore', 'Copper Ore', 6*$amountOf_MagneticFieldGeneratorRecipe);
		$this->DesertNE____MFGen->addRecipeForProduce2___    ('AI Limiter', 1*$amountOf_MagneticFieldGeneratorRecipe);
		$this->DesertNE____MFGen->addRecipeForProduce2___      ('Copper Sheet', 5*$amountOf_MagneticFieldGeneratorRecipe);
		$this->DesertNE____MFGen->addRecipeForProduce2___        ('Copper Ingot', 10*$amountOf_MagneticFieldGeneratorRecipe);
		$this->DesertNE____MFGen->addRecipeForProduce____          ('Miner Mk.3: Copper Ore', 'Copper Ore', 10*$amountOf_MagneticFieldGeneratorRecipe);
		$this->DesertNE____MFGen->addRecipeForProduce2___      ('Quickwire', 20*$amountOf_MagneticFieldGeneratorRecipe);
		$this->DesertNE____MFGen->addRecipeForProduce2___        ('Caterium Ingot', 4*$amountOf_MagneticFieldGeneratorRecipe);
		$this->DesertNE____MFGen->addRecipeForProduce____          ('Miner Mk.3: Caterium Ore', 'Caterium Ore', 12*$amountOf_MagneticFieldGeneratorRecipe);
	}

	public function addRecipesForAssemblyDirectorSystem(float $amountOf_AssemblyDirectorSystemRecipe) {
		$this->MaraisE___Bauxite->addRecipe______________('Recipe_SpaceElevatorPart_7_C', 1*$amountOf_AssemblyDirectorSystemRecipe); // Assembly Director System
		$this->DesertSO___Canyon->addRecipe______________  ('Recipe_SpaceElevatorPart_5_C', 1.5*$amountOf_AssemblyDirectorSystemRecipe); // Adaptive Control Unit
		$this->DesertE___AutoWir->addRecipe______________    ('Recipe_SpaceElevatorPart_3_C', 3*$amountOf_AssemblyDirectorSystemRecipe); // Automated Wiring
		$this->DesertE___AutoWir->addRecipeForProduce2___      ('Stator', 7.5*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertE___AutoWir->addRecipeForProduce2___        ('Steel Pipe', 22.5*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertE___AutoWir->addRecipeForProduce2___          ('Steel Ingot', 33.75*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertE___AutoWir->addRecipeForProduce____            ('Miner Mk.1: Iron Ore', 'Iron Ore', 33.75*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertE___AutoWir->addRecipeForProduce____            ('Miner Mk.1: Coal', 'Coal', 33.75*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertE___AutoWir->addRecipeForProduce2___        ('Wire', 60*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertE___AutoWir->addRecipeForProduce2___          ('Copper Ingot', 30*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertE___AutoWir->addRecipeForProduce____            ('Miner Mk.1: Copper Ore', 'Copper Ore', 30*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertE___AutoWir->addRecipeForProduce2___      ('Cable', 150*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertE___AutoWir->addRecipeForProduce2___        ('Wire', 300*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertE___AutoWir->addRecipeForProduce2___          ('Copper Ingot', 150*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertE___AutoWir->addRecipeForProduce____            ('Miner Mk.1: Copper Ore', 'Copper Ore', 150*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___      ('Circuit Board', 7.5*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___        ('Copper Sheet', 15*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___          ('Copper Ingot', 30*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce____            ('Miner Mk.1: Copper Ore', 'Copper Ore', 30*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___        ('Plastic', 30*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce____           ('Oil Extractor: Crude Oil', 'Crude Oil', 45000*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertSO___Canyon->addRecipeForConsume____             ('Residual Fuel', 'Heavy Oil Residue', (45000/3)*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertSO___Canyon->addRecipeByDisplayName_               ('Fuel Power', (((45000/3)*(2/3))/20000)*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___      ('Heavy Modular Frame', 1.5*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___        ('Steel Pipe', 30*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___          ('Steel Ingot', 45*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce____            ('Miner Mk.1: Iron Ore', 'Iron Ore', 45*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertNE____MFGen->addRecipeForProduce____            ('Miner Mk.1: Coal', 'Coal', 45*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___        ('Encased Industrial Beam', 7.5*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___          ('Concrete', 45*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce____            ('Miner Mk.1: Limestone', 'Limestone', 135*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___          ('Steel Beam', 22.5*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___            ('Steel Ingot', 90*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce____              ('Miner Mk.1: Iron Ore', 'Iron Ore', 90*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertNE____MFGen->addRecipeForProduce____              ('Miner Mk.1: Coal', 'Coal', 90*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___       ('Modular Frame', 7.5*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___         ('Reinforced Iron Plate', 11.25*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___           ('Iron Plate', 67.5*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___             ('Iron Ingot', 101.25*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce____               ('Miner Mk.1: Iron Ore', 'Iron Ore', 101.25*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___           ('Screw', 135*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___             ('Iron Rod', 33.75*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___               ('Iron Ingot', 33.75*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce____                 ('Miner Mk.1: Iron Ore', 'Iron Ore', 33.75*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___         ('Iron Rod', 45*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___           ('Iron Ingot', 45*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce____             ('Miner Mk.1: Iron Ore', 'Iron Ore', 45*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___       ('Screw', 180*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___         ('Iron Rod', 45*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___           ('Iron Ingot', 45*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce____             ('Miner Mk.1: Iron Ore', 'Iron Ore', 45*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___      ('Computer', 3*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___        ('Circuit Board', 12*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___          ('Copper Sheet', 24*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___            ('Copper Ingot', 48*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce____              ('Miner Mk.1: Copper Ore', 'Copper Ore', 48*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___          ('Plastic', 48*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce____            ('Oil Extractor: Crude Oil', 'Crude Oil', 72000*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertSO___Canyon->addRecipeForConsume____              ('Residual Fuel', 'Heavy Oil Residue', (72000/3)*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertSO___Canyon->addRecipeByDisplayName_                 ('Fuel Power', (((72000/3)*(2/3))/20000)*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___        ('Cable', 24*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___          ('Wire', 48*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___            ('Copper Ingot', 24*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce____              ('Miner Mk.1: Copper Ore', 'Copper Ore', 24*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___        ('Plastic', 48*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce____          ('Oil Extractor: Crude Oil', 'Crude Oil', 72000*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertSO___Canyon->addRecipeForConsume____            ('Residual Fuel', 'Heavy Oil Residue', (72000/3)*$amountOf_AssemblyDirectorSystemRecipe);
		$this->DesertSO___Canyon->addRecipeByDisplayName_               ('Fuel Power', (((72000/3)*(2/3))/20000)*$amountOf_AssemblyDirectorSystemRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___  ('Supercomputer', 0.75*$amountOf_AssemblyDirectorSystemRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___    ('AI Limiter', 1.5*$amountOf_AssemblyDirectorSystemRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___      ('Copper Sheet', 7.5*$amountOf_AssemblyDirectorSystemRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___        ('Copper Ingot', 15*$amountOf_AssemblyDirectorSystemRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce____          ('Miner Mk.1: Copper Ore', 'Copper Ore', 15*$amountOf_AssemblyDirectorSystemRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___      ('Quickwire', 30*$amountOf_AssemblyDirectorSystemRecipe);
		$this->MaraisSE__CrudOil->addRecipeForProduce2___        ('Caterium Ingot', 6*$amountOf_AssemblyDirectorSystemRecipe);
		$this->MaraisSE__CrudOil->addRecipeForProduce____          ('Miner Mk.1: Caterium Ore', 'Caterium Ore', 18*$amountOf_AssemblyDirectorSystemRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___    ('High-Speed Connector', 2.25*$amountOf_AssemblyDirectorSystemRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___      ('Quickwire', 126*$amountOf_AssemblyDirectorSystemRecipe);
		$this->MaraisSE__CrudOil->addRecipeForProduce2___        ('Caterium Ingot', 25.2*$amountOf_AssemblyDirectorSystemRecipe);
		$this->MaraisSE__CrudOil->addRecipeForProduce____          ('Miner Mk.1: Caterium Ore', 'Caterium Ore', 75.6*$amountOf_AssemblyDirectorSystemRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___      ('Cable', 22.5*$amountOf_AssemblyDirectorSystemRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___        ('Wire', 45*$amountOf_AssemblyDirectorSystemRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___          ('Copper Ingot', 22.5*$amountOf_AssemblyDirectorSystemRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce____            ('Miner Mk.1: Copper Ore', 'Copper Ore', 22.5*$amountOf_AssemblyDirectorSystemRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___      ('Circuit Board', 2.25*$amountOf_AssemblyDirectorSystemRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___        ('Copper Sheet', 4.5*$amountOf_AssemblyDirectorSystemRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___          ('Copper Ingot', 9*$amountOf_AssemblyDirectorSystemRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce____             ('Miner Mk.1: Copper Ore', 'Copper Ore', 9*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Marais_____________addRecipesForProduce2__        ('Plastic', 9*$amountOf_AssemblyDirectorSystemRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___    ('Computer', 3*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Marais_____________addRecipesForProduce2__      ('Plastic', 69*$amountOf_AssemblyDirectorSystemRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___      ('Circuit Board', 12*$amountOf_AssemblyDirectorSystemRecipe);
		$this->Marais_____________addRecipesForProduce2__        ('Plastic', 48*$amountOf_AssemblyDirectorSystemRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___        ('Copper Sheet', 24*$amountOf_AssemblyDirectorSystemRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___          ('Copper Ingot', 48*$amountOf_AssemblyDirectorSystemRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce____             ('Miner Mk.1: Copper Ore', 'Copper Ore', 48*$amountOf_AssemblyDirectorSystemRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___      ('Cable', 24*$amountOf_AssemblyDirectorSystemRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___        ('Wire', 48*$amountOf_AssemblyDirectorSystemRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___          ('Copper Ingot', 24*$amountOf_AssemblyDirectorSystemRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce____            ('Miner Mk.1: Copper Ore', 'Copper Ore', 24*$amountOf_AssemblyDirectorSystemRecipe);
	}

	public function addRecipesForThermalPropulsionRocket(float $amountOf_ThermalPropulsionRocketRecipe) {
		$this->MaraisE___Bauxite->addRecipe______________('Recipe_SpaceElevatorPart_8_C', 1*$amountOf_ThermalPropulsionRocketRecipe); // Thermal Propulsion Rocket

		// Modular Engine
		$this->DesertSO___Canyon->addRecipeForProduce2___  ('Modular Engine', 2.5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___    ('Motor', 5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___      ('Rotor', 10*$amountOf_ThermalPropulsionRocketRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___        ('Iron Rod', 50*$amountOf_ThermalPropulsionRocketRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___          ('Iron Ingot', 50*$amountOf_ThermalPropulsionRocketRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce____            ('Miner Mk.1: Iron Ore', 'Iron Ore', 50*$amountOf_ThermalPropulsionRocketRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___        ('Screw', 250*$amountOf_ThermalPropulsionRocketRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___          ('Iron Rod', 62.5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___            ('Iron Ingot', 62.5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce____              ('Miner Mk.1: Iron Ore', 'Iron Ore', 62.5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___      ('Stator', 10*$amountOf_ThermalPropulsionRocketRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___        ('Steel Pipe', 30*$amountOf_ThermalPropulsionRocketRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___          ('Steel Ingot', 45*$amountOf_ThermalPropulsionRocketRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce____            ('Miner Mk.1: Iron Ore', 'Iron Ore', 45*$amountOf_ThermalPropulsionRocketRecipe);
		$this->DesertNE____MFGen->addRecipeForProduce____            ('Miner Mk.1: Coal', 'Coal', 45*$amountOf_ThermalPropulsionRocketRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___        ('Wire', 80*$amountOf_ThermalPropulsionRocketRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___          ('Copper Ingot', 40*$amountOf_ThermalPropulsionRocketRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce____            ('Miner Mk.1: Copper Ore', 'Copper Ore', 40*$amountOf_ThermalPropulsionRocketRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___    ('Rubber', 37.5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce____       ('Oil Extractor: Crude Oil', 'Crude Oil', 56250*$amountOf_ThermalPropulsionRocketRecipe);
		$this->DesertSO___Canyon->addRecipeForConsume____         ('Residual Fuel', 'Heavy Oil Residue', (56250/(3/2))*$amountOf_ThermalPropulsionRocketRecipe);
		$this->DesertSO___Canyon->addRecipeByDisplayName_           ('Fuel Power', (((56250/(3/2))*(2/3))/20000)*$amountOf_ThermalPropulsionRocketRecipe);
		$this->DesertSO___Canyon->addRecipe______________    ('Recipe_SpaceElevatorPart_1_C', 2.5*$amountOf_ThermalPropulsionRocketRecipe); // Smart Plating
		$this->DesertSO___Canyon->addRecipeForProduce2___      ('Rotor', 5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___        ('Iron Rod', 25*$amountOf_ThermalPropulsionRocketRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___          ('Iron Ingot', 25*$amountOf_ThermalPropulsionRocketRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce____            ('Miner Mk.1: Iron Ore', 'Iron Ore', 25*$amountOf_ThermalPropulsionRocketRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___        ('Screw', 125*$amountOf_ThermalPropulsionRocketRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___          ('Iron Rod', 31.25*$amountOf_ThermalPropulsionRocketRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___            ('Iron Ingot', 31.25*$amountOf_ThermalPropulsionRocketRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce____              ('Miner Mk.1: Iron Ore', 'Iron Ore', 31.25*$amountOf_ThermalPropulsionRocketRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___      ('Reinforced Iron Plate', 5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___        ('Iron Plate', 30*$amountOf_ThermalPropulsionRocketRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___          ('Iron Ingot', 45*$amountOf_ThermalPropulsionRocketRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce____            ('Miner Mk.1: Iron Ore', 'Iron Ore', 45*$amountOf_ThermalPropulsionRocketRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___        ('Screw', 60*$amountOf_ThermalPropulsionRocketRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___          ('Iron Rod', 15*$amountOf_ThermalPropulsionRocketRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce2___            ('Iron Ingot', 15*$amountOf_ThermalPropulsionRocketRecipe);
		$this->DesertSO___Canyon->addRecipeForProduce____              ('Miner Mk.1: Iron Ore', 'Iron Ore', 15*$amountOf_ThermalPropulsionRocketRecipe);

		// Turbo Motor
		$this->MaraisE___Bauxite->addRecipeForProduce2___  ('Turbo Motor', 1*$amountOf_ThermalPropulsionRocketRecipe);

		// Turbo Motor: Motor
		$this->MaraisE___Bauxite->addRecipeForProduce2___    ('Motor', 4*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___      ('Rotor', 8*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___        ('Iron Rod', 40*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___          ('Iron Ingot', 40*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce____            ('Miner Mk.1: Iron Ore', 'Iron Ore', 40*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___        ('Screw', 200*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___          ('Iron Rod', 50*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___            ('Iron Ingot', 50*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce____              ('Miner Mk.1: Iron Ore', 'Iron Ore', 50*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___      ('Stator', 8*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___        ('Steel Pipe', 24*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___          ('Steel Ingot', 36*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce____            ('Miner Mk.1: Iron Ore', 'Iron Ore', 36*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce____            ('Miner Mk.1: Coal', 'Coal', 36*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___        ('Wire', 64*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___          ('Copper Ingot', 32*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce____            ('Miner Mk.1: Copper Ore', 'Copper Ore', 32*$amountOf_ThermalPropulsionRocketRecipe);

		// Turbo Motor: Rubber
		$this->Marais_____________addRecipesForProduce2__    ('Rubber', 24*$amountOf_ThermalPropulsionRocketRecipe);

		// Turbo Motor: Cooling System
		$this->MaraisE___Bauxite->addRecipeForProduce2___    ('Cooling System', 4*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Marais_____________addRecipesForProduce2__      ('Rubber', 8*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___      ('Heat Sink', 8*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Marais_____________addRecipesForProduce2__        ('Alclad Aluminum Sheet', 40*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___        ('Copper Sheet', 24*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___          ('Copper Ingot', 48*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce____            ('Miner Mk.1: Copper Ore', 'Copper Ore', 48*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce____       ('Water Extractor: Water', 'Water', 20000*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce____       ('Unpackage Nitrogen Gas', 'Nitrogen Gas', 100000*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisS__Nitrogen->addRecipeForConsume____         ('Packaged Nitrogen Gas', 'Nitrogen Gas', 100000*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce____            ('Resource Well Extractor: Nitrogen Gas', 'Nitrogen Gas', 100000*$amountOf_ThermalPropulsionRocketRecipe);

		// Turbo Motor: Radio Control Unit
		$this->MaraisE___Bauxite->addRecipeForProduce2___    ('Radio Control Unit', 2*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___      ('Aluminum Casing', 32*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Marais_____________addRecipesForProduce2__        ('Aluminum Ingot', 48*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___      ('Crystal Oscillator', 1*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisNO___Quartz->addRecipeForProduce2___        ('Quartz Crystal', 18*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisNO___Quartz->addRecipeForProduce____          ('Miner Mk.1: Raw Quartz', 'Raw Quartz', 30*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___        ('Cable', 14*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___          ('Wire', 28*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___            ('Copper Ingot', 14*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce____              ('Miner Mk.1: Copper Ore', 'Copper Ore', 14*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___        ('Reinforced Iron Plate', 2.5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___          ('Iron Plate', 15*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___            ('Iron Ingot', 22.5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce____              ('Miner Mk.1: Iron Ore', 'Iron Ore', 22.5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___          ('Screw', 30*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___            ('Iron Rod', 7.5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___              ('Iron Ingot', 7.5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce____                ('Miner Mk.1: Iron Ore', 'Iron Ore', 7.5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___      ('Computer', 2*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___        ('Circuit Board', 8*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___          ('Copper Sheet', 16*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___            ('Copper Ingot', 32*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce____              ('Miner Mk.1: Copper Ore', 'Copper Ore', 32*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___        ('Cable', 16*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___          ('Wire', 32*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___            ('Copper Ingot', 16*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce____              ('Miner Mk.1: Copper Ore', 'Copper Ore', 16*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Marais_____________addRecipesForProduce2__        ('Plastic', 64*$amountOf_ThermalPropulsionRocketRecipe);

		// Cooling System
		$this->MaraisE___Bauxite->addRecipeForProduce2___    ('Cooling System', 3*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Marais_____________addRecipesForProduce2__      ('Rubber', 6*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___      ('Heat Sink', 6*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Marais_____________addRecipesForProduce2__        ('Alclad Aluminum Sheet', 30*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___        ('Copper Sheet', 18*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___          ('Copper Ingot', 36*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce____             ('Miner Mk.1: Copper Ore', 'Copper Ore', 36*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce____       ('Water Extractor: Water', 'Water', 15000*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce____       ('Unpackage Nitrogen Gas', 'Nitrogen Gas', 75000*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisS__Nitrogen->addRecipeForConsume____        ('Packaged Nitrogen Gas', 'Nitrogen Gas', 75000*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce____          ('Resource Well Extractor: Nitrogen Gas', 'Nitrogen Gas', 75000*$amountOf_ThermalPropulsionRocketRecipe);

		// Fused Modular Frame
		$this->MaraisS__Nitrogen->addRecipeForProduce2___  ('Fused Modular Frame', 1*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce____    ('Resource Well Extractor: Nitrogen Gas', 'Nitrogen Gas', 25000*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___    ('Heavy Modular Frame', 1*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___       ('Steel Pipe', 20*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___         ('Steel Ingot', 30*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce____          ('Miner Mk.1: Iron Ore', 'Iron Ore', 30*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce____          ('Miner Mk.1: Coal', 'Coal', 30*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___      ('Encased Industrial Beam', 5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___        ('Concrete', 30*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce____           ('Miner Mk.1: Limestone', 'Limestone', 90*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___        ('Steel Beam', 15*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___          ('Steel Ingot', 60*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce____             ('Miner Mk.1: Iron Ore', 'Iron Ore', 60*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce____             ('Miner Mk.1: Coal', 'Coal', 60*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___       ('Modular Frame', 5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___         ('Reinforced Iron Plate', 7.5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___           ('Iron Plate', 45*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___             ('Iron Ingot', 67.5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce____              ('Miner Mk.1: Iron Ore', 'Iron Ore', 67.5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___           ('Screw', 90*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___             ('Iron Rod', 22.5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___               ('Iron Ingot', 22.5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce____                ('Miner Mk.1: Iron Ore', 'Iron Ore', 22.5*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___         ('Iron Rod', 30*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___           ('Iron Ingot', 30*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce____            ('Miner Mk.1: Iron Ore', 'Iron Ore', 30*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___       ('Screw', 120*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___         ('Iron Rod', 30*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___           ('Iron Ingot', 30*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce____            ('Miner Mk.1: Iron Ore', 'Iron Ore', 30*$amountOf_ThermalPropulsionRocketRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___    ('Aluminum Casing', 50*$amountOf_ThermalPropulsionRocketRecipe);
		$this->Marais_____________addRecipesForProduce2__      ('Aluminum Ingot', 75*$amountOf_ThermalPropulsionRocketRecipe);
	}

	public function addRecipesForNuclearPasta(float $amountOf_NuclearPastaRecipe) {
		$this->MaraisE___Bauxite->addRecipe______________  ('Recipe_SpaceElevatorPart_9_C', 1*$amountOf_NuclearPastaRecipe); // Nuclear Pasta

		$this->DesertS__CoppPwdr->addRecipeForProduce2___  ('Copper Powder', 100*$amountOf_NuclearPastaRecipe);
		$this->DesertS__CoppPwdr->addRecipeForProduce2___    ('Copper Ingot', 600*$amountOf_NuclearPastaRecipe);
		$this->DesertS__CoppPwdr->addRecipeForProduce____       ('Miner Mk.1: Copper Ore', 'Copper Ore', 600*$amountOf_NuclearPastaRecipe);

		$this->MaraisE___Bauxite->addRecipeForProduce2___  ('Pressure Conversion Cube', 0.5*$amountOf_NuclearPastaRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___    ('Radio Control Unit', 1*$amountOf_NuclearPastaRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___      ('Aluminum Casing', 16*$amountOf_NuclearPastaRecipe);
		$this->Marais_____________addRecipesForProduce2__        ('Aluminum Ingot', 24*$amountOf_NuclearPastaRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___      ('Crystal Oscillator', 0.5*$amountOf_NuclearPastaRecipe);
		$this->MaraisNO___Quartz->addRecipeForProduce2___         ('Quartz Crystal', 9*$amountOf_NuclearPastaRecipe);
		$this->MaraisNO___Quartz->addRecipeForProduce____            ('Miner Mk.1: Raw Quartz', 'Raw Quartz', 15*$amountOf_NuclearPastaRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___        ('Cable', 7*$amountOf_NuclearPastaRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___          ('Wire', 14*$amountOf_NuclearPastaRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___            ('Copper Ingot', 7*$amountOf_NuclearPastaRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce____               ('Miner Mk.1: Copper Ore', 'Copper Ore', 7*$amountOf_NuclearPastaRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___        ('Reinforced Iron Plate', 1.25*$amountOf_NuclearPastaRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___          ('Iron Plate', 7.5*$amountOf_NuclearPastaRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___            ('Iron Ingot', 11.25*$amountOf_NuclearPastaRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce____               ('Miner Mk.1: Iron Ore', 'Iron Ore', 11.25*$amountOf_NuclearPastaRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___          ('Screw', 15*$amountOf_NuclearPastaRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___            ('Iron Rod', 3.75*$amountOf_NuclearPastaRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___              ('Iron Ingot', 3.75*$amountOf_NuclearPastaRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce____                 ('Miner Mk.1: Iron Ore', 'Iron Ore', 3.75*$amountOf_NuclearPastaRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___      ('Computer', 1*$amountOf_NuclearPastaRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___        ('Circuit Board', 4*$amountOf_NuclearPastaRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___          ('Copper Sheet', 8*$amountOf_NuclearPastaRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___            ('Copper Ingot', 16*$amountOf_NuclearPastaRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce____               ('Miner Mk.1: Copper Ore', 'Copper Ore', 16*$amountOf_NuclearPastaRecipe);
		$this->Marais_____________addRecipesForProduce2__          ('Plastic', 16*$amountOf_NuclearPastaRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___        ('Cable', 8*$amountOf_NuclearPastaRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___          ('Wire', 16*$amountOf_NuclearPastaRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___            ('Copper Ingot', 8*$amountOf_NuclearPastaRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce____               ('Miner Mk.1: Copper Ore', 'Copper Ore', 8*$amountOf_NuclearPastaRecipe);
		$this->Marais_____________addRecipesForProduce2__        ('Plastic', 16*$amountOf_NuclearPastaRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___    ('Fused Modular Frame', 0.5*$amountOf_NuclearPastaRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___      ('Heavy Modular Frame', 0.5*$amountOf_NuclearPastaRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___        ('Modular Frame', 2.5*$amountOf_NuclearPastaRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___          ('Reinforced Iron Plate', 3.75*$amountOf_NuclearPastaRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___            ('Iron Plate', 22.5*$amountOf_NuclearPastaRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___              ('Iron Ingot', 33.75*$amountOf_NuclearPastaRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce____                ('Miner Mk.1: Iron Ore', 'Iron Ore', 33.75*$amountOf_NuclearPastaRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___            ('Screw', 45*$amountOf_NuclearPastaRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___              ('Iron Rod', 11.25*$amountOf_NuclearPastaRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___                ('Iron Ingot', 11.25*$amountOf_NuclearPastaRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce____                  ('Miner Mk.1: Iron Ore', 'Iron Ore', 11.25*$amountOf_NuclearPastaRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___          ('Iron Rod', 15*$amountOf_NuclearPastaRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___            ('Iron Ingot', 15*$amountOf_NuclearPastaRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce____              ('Miner Mk.1: Iron Ore', 'Iron Ore', 15*$amountOf_NuclearPastaRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___        ('Steel Pipe', 10*$amountOf_NuclearPastaRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___          ('Steel Ingot', 15*$amountOf_NuclearPastaRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce____            ('Miner Mk.1: Iron Ore', 'Iron Ore', 15*$amountOf_NuclearPastaRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce____            ('Miner Mk.1: Coal', 'Coal', 15*$amountOf_NuclearPastaRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___        ('Encased Industrial Beam', 2.5*$amountOf_NuclearPastaRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___          ('Steel Beam', 7.5*$amountOf_NuclearPastaRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___            ('Steel Ingot', 30*$amountOf_NuclearPastaRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce____              ('Miner Mk.1: Iron Ore', 'Iron Ore', 30*$amountOf_NuclearPastaRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce____              ('Miner Mk.1: Coal', 'Coal', 30*$amountOf_NuclearPastaRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___          ('Concrete', 15*$amountOf_NuclearPastaRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce____            ('Miner Mk.1: Limestone', 'Limestone', 45*$amountOf_NuclearPastaRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___        ('Screw', 60*$amountOf_NuclearPastaRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___          ('Iron Rod', 15*$amountOf_NuclearPastaRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___            ('Iron Ingot', 15*$amountOf_NuclearPastaRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce____              ('Miner Mk.1: Iron Ore', 'Iron Ore', 15*$amountOf_NuclearPastaRecipe);
		$this->MaraisE___Bauxite->addRecipeForProduce2___      ('Aluminum Casing', 25*$amountOf_NuclearPastaRecipe);
		$this->Marais_____________addRecipesForProduce2__        ('Aluminum Ingot', 37.5*$amountOf_NuclearPastaRecipe);
		$this->MaraisS__Nitrogen->addRecipeForProduce____      ('Resource Well Extractor: Nitrogen Gas', 'Nitrogen Gas', 12500*$amountOf_NuclearPastaRecipe);
	}

	public function addRecipesForBiochemicalScultor(float $amountOf_BiochemicalScultor) {
		$this->MaraisSE__CrudOil->addRecipe______________('Recipe_SpaceElevatorPart_10_C', 0.5*$amountOf_BiochemicalScultor); // Biochemical Sculptor
		$this->MaraisSE__CrudOil->addRecipeForProduce____  ('Water Extractor: Water', 'Water', 5000*$amountOf_BiochemicalScultor);
		$this->MaraisSE__CrudOil->addRecipeForProduce2___  ('Ficsite Trigon', 20*$amountOf_BiochemicalScultor);
		$this->MaraisSE__CrudOil->addRecipeForProduce____    ('Ficsite Ingot (Caterium)', 'Ficsite Ingot', (20/3)*$amountOf_BiochemicalScultor);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___      ('Reanimated SAM', 20*$amountOf_BiochemicalScultor);
		$this->MaraisS__Nitrogen->addRecipeForProduce____        ('Miner Mk.1: SAM', 'SAM', 80*$amountOf_BiochemicalScultor);
		$this->MaraisSE__CrudOil->addRecipeForProduce2___      ('Caterium Ingot', (26+(2/3))*$amountOf_BiochemicalScultor);
		$this->MaraisSE__CrudOil->addRecipeForProduce____        ('Miner Mk.1: Caterium Ore', 'Caterium Ore', 80*$amountOf_BiochemicalScultor);
	}

	public function addRecipesForBallisticWarpDrive(float $amountOf_BallisticWarpDrive) {
		$this->MaraisS__Nitrogen->addRecipe______________('Recipe_SpaceElevatorPart_11_C', 1*$amountOf_BallisticWarpDrive); // Ballistic Warp Drive

		$this->MaraisS__Nitrogen->addRecipeForProduce2___  ('Singularity Cell', 5*$amountOf_BallisticWarpDrive);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___    ('Dark Matter Crystal', 10*$amountOf_BallisticWarpDrive);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___      ('Diamonds', 10*$amountOf_BallisticWarpDrive);
		$this->MaraisS__Nitrogen->addRecipeForProduce____        ('Miner Mk.1: Coal', 'Coal', 200*$amountOf_BallisticWarpDrive);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___      ('Dark Matter Residue', 50000*$amountOf_BallisticWarpDrive);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___        ('Reanimated SAM', 25*$amountOf_BallisticWarpDrive);
		$this->MaraisS__Nitrogen->addRecipeForProduce____          ('Miner Mk.1: SAM', 'SAM', 100*$amountOf_BallisticWarpDrive);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___    ('Iron Plate', 50*$amountOf_BallisticWarpDrive);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___      ('Iron Ingot', 75*$amountOf_BallisticWarpDrive);
		$this->MaraisS__Nitrogen->addRecipeForProduce____        ('Miner Mk.1: Iron Ore', 'Iron Ore', 75*$amountOf_BallisticWarpDrive);
		$this->MaraisE___Bauxite->addRecipeForProduce2___    ('Concrete', 100*$amountOf_BallisticWarpDrive);
		$this->MaraisE___Bauxite->addRecipeForProduce____      ('Miner Mk.1: Limestone', 'Limestone', 300*$amountOf_BallisticWarpDrive);

		$this->MaraisS__Nitrogen->addRecipeForProduce2___  ('Superposition Oscillator', 2*$amountOf_BallisticWarpDrive);
		$this->Marais_____________addRecipesForProduce2__    ('Alclad Aluminum Sheet', 18*$amountOf_BallisticWarpDrive);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___    ('Excited Photonic Matter', 50000*$amountOf_BallisticWarpDrive);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___    ('Dark Matter Crystal', 12*$amountOf_BallisticWarpDrive);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___      ('Diamonds', 12*$amountOf_BallisticWarpDrive);
		$this->MaraisS__Nitrogen->addRecipeForProduce____        ('Miner Mk.1: Coal', 'Coal', 240*$amountOf_BallisticWarpDrive);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___      ('Dark Matter Residue', (60000-50000)*$amountOf_BallisticWarpDrive); // Retirer le 'Dark Matter Residue' produit par 'Excited Photonic Matter'
		$this->MaraisS__Nitrogen->addRecipeForProduce2___        ('Reanimated SAM', (30-25)*$amountOf_BallisticWarpDrive); // Retirer le 'Dark Matter Residue' produit par 'Excited Photonic Matter'
		$this->MaraisS__Nitrogen->addRecipeForProduce____          ('Miner Mk.1: SAM', 'SAM', (120-100)*$amountOf_BallisticWarpDrive); // Retirer le 'Dark Matter Residue' produit par 'Excited Photonic Matter'
		$this->MaraisE___Bauxite->addRecipeForProduce2___    ('Crystal Oscillator', 2*$amountOf_BallisticWarpDrive);
		$this->MaraisNO___Quartz->addRecipeForProduce2___       ('Quartz Crystal', 36*$amountOf_BallisticWarpDrive);
		$this->MaraisNO___Quartz->addRecipeForProduce____          ('Miner Mk.1: Raw Quartz', 'Raw Quartz', 60*$amountOf_BallisticWarpDrive);
		$this->MaraisE___Bauxite->addRecipeForProduce2___      ('Cable', 28*$amountOf_BallisticWarpDrive);
		$this->MaraisE___Bauxite->addRecipeForProduce2___        ('Wire', 56*$amountOf_BallisticWarpDrive);
		$this->MaraisE___Bauxite->addRecipeForProduce2___          ('Copper Ingot', 28*$amountOf_BallisticWarpDrive);
		$this->MaraisE___Bauxite->addRecipeForProduce____             ('Miner Mk.1: Copper Ore', 'Copper Ore', 28*$amountOf_BallisticWarpDrive);
		$this->MaraisE___Bauxite->addRecipeForProduce2___      ('Reinforced Iron Plate', 5*$amountOf_BallisticWarpDrive);
		$this->MaraisE___Bauxite->addRecipeForProduce2___        ('Iron Plate', 30*$amountOf_BallisticWarpDrive);
		$this->MaraisE___Bauxite->addRecipeForProduce2___          ('Iron Ingot', 45*$amountOf_BallisticWarpDrive);
		$this->MaraisE___Bauxite->addRecipeForProduce____             ('Miner Mk.1: Iron Ore', 'Iron Ore', 45*$amountOf_BallisticWarpDrive);
		$this->MaraisE___Bauxite->addRecipeForProduce2___        ('Screw', 60*$amountOf_BallisticWarpDrive);
		$this->MaraisE___Bauxite->addRecipeForProduce2___          ('Iron Rod', 15*$amountOf_BallisticWarpDrive);
		$this->MaraisE___Bauxite->addRecipeForProduce2___            ('Iron Ingot', 15*$amountOf_BallisticWarpDrive);
		$this->MaraisE___Bauxite->addRecipeForProduce____               ('Miner Mk.1: Iron Ore', 'Iron Ore', 15*$amountOf_BallisticWarpDrive);

		$this->MaraisS__Nitrogen->addRecipeForProduce2___  ('Dark Matter Crystal', 40*$amountOf_BallisticWarpDrive);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___    ('Diamonds', 40*$amountOf_BallisticWarpDrive);
		$this->MaraisS__Nitrogen->addRecipeForProduce____      ('Miner Mk.1: Coal', 'Coal', 800*$amountOf_BallisticWarpDrive);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___    ('Dark Matter Residue', 200000*$amountOf_BallisticWarpDrive);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___      ('Reanimated SAM', 100*$amountOf_BallisticWarpDrive);
		$this->MaraisS__Nitrogen->addRecipeForProduce____        ('Miner Mk.1: SAM', 'SAM', 400*$amountOf_BallisticWarpDrive);
	}

	public function addRecipesForAIExpansionServer(float $amountOf_AIExpansionServer) {
		$this->MaraisS__Nitrogen->addRecipe______________('Recipe_SpaceElevatorPart_12_C', 0.25*$amountOf_AIExpansionServer); // AI Expansion Server

		$this->MaraisS__Nitrogen->addRecipeForProduce2___  ('Excited Photonic Matter', 25000*$amountOf_AIExpansionServer); // + 25000 Dark Matter Residue

		$this->MaraisS__Nitrogen->addRecipeForProduce2___  ('Neural-Quantum Processor', 1*$amountOf_AIExpansionServer);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___    ('Time Crystal', 5*$amountOf_AIExpansionServer);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___      ('Diamonds', 10*$amountOf_AIExpansionServer);
		$this->MaraisS__Nitrogen->addRecipeForProduce____        ('Miner Mk.1: Coal', 'Coal', 200*$amountOf_AIExpansionServer);
		$this->MaraisE___Bauxite->addRecipeForProduce2___    ('Supercomputer', (4/3)*0.75*$amountOf_AIExpansionServer);
		$this->Marais_____________addRecipesForProduce2__      ('Plastic', 28*$amountOf_AIExpansionServer);
		$this->MaraisE___Bauxite->addRecipeForProduce2___      ('AI Limiter', (4/3)*1.5*$amountOf_AIExpansionServer);
		$this->MaraisE___Bauxite->addRecipeForProduce2___        ('Copper Sheet', (4/3)*7.5*$amountOf_AIExpansionServer);
		$this->MaraisE___Bauxite->addRecipeForProduce2___          ('Copper Ingot', (4/3)*15*$amountOf_AIExpansionServer);
		$this->MaraisE___Bauxite->addRecipeForProduce____            ('Miner Mk.1: Copper Ore', 'Copper Ore', (4/3)*15*$amountOf_AIExpansionServer);
		$this->MaraisE___Bauxite->addRecipeForProduce2___        ('Quickwire', (4/3)*30*$amountOf_AIExpansionServer);
		$this->MaraisSE__CrudOil->addRecipeForProduce2___          ('Caterium Ingot', (4/3)*6*$amountOf_AIExpansionServer);
		$this->MaraisSE__CrudOil->addRecipeForProduce____            ('Miner Mk.1: Caterium Ore', 'Caterium Ore', (4/3)*18*$amountOf_AIExpansionServer);
		$this->MaraisE___Bauxite->addRecipeForProduce2___      ('High-Speed Connector', (4/3)*2.25*$amountOf_AIExpansionServer);
		$this->MaraisE___Bauxite->addRecipeForProduce2___        ('Quickwire', (4/3)*126*$amountOf_AIExpansionServer);
		$this->MaraisSE__CrudOil->addRecipeForProduce2___          ('Caterium Ingot', (4/3)*25.2*$amountOf_AIExpansionServer);
		$this->MaraisSE__CrudOil->addRecipeForProduce____            ('Miner Mk.1: Caterium Ore', 'Caterium Ore', (4/3)*75.6*$amountOf_AIExpansionServer);
		$this->MaraisE___Bauxite->addRecipeForProduce2___        ('Cable', (4/3)*22.5*$amountOf_AIExpansionServer);
		$this->MaraisE___Bauxite->addRecipeForProduce2___          ('Wire', (4/3)*45*$amountOf_AIExpansionServer);
		$this->MaraisE___Bauxite->addRecipeForProduce2___            ('Copper Ingot', (4/3)*22.5*$amountOf_AIExpansionServer);
		$this->MaraisE___Bauxite->addRecipeForProduce____              ('Miner Mk.1: Copper Ore', 'Copper Ore', (4/3)*22.5*$amountOf_AIExpansionServer);
		$this->MaraisE___Bauxite->addRecipeForProduce2___        ('Circuit Board', (4/3)*2.25*$amountOf_AIExpansionServer);
		$this->MaraisE___Bauxite->addRecipeForProduce2___          ('Copper Sheet', (4/3)*4.5*$amountOf_AIExpansionServer);
		$this->MaraisE___Bauxite->addRecipeForProduce2___            ('Copper Ingot', 12*$amountOf_AIExpansionServer);
		$this->MaraisE___Bauxite->addRecipeForProduce____               ('Miner Mk.1: Copper Ore', 'Copper Ore', 12*$amountOf_AIExpansionServer);
		$this->Marais_____________addRecipesForProduce2__          ('Plastic', 12*$amountOf_AIExpansionServer);
		$this->MaraisE___Bauxite->addRecipeForProduce2___      ('Computer', (4/3)*3*$amountOf_AIExpansionServer);
		$this->Marais_____________addRecipesForProduce2__        ('Plastic', 64*$amountOf_AIExpansionServer);
		$this->MaraisE___Bauxite->addRecipeForProduce2___        ('Circuit Board', (4/3)*12*$amountOf_AIExpansionServer);
		$this->Marais_____________addRecipesForProduce2__          ('Plastic', 64*$amountOf_AIExpansionServer);
		$this->MaraisE___Bauxite->addRecipeForProduce2___          ('Copper Sheet', (4/3)*24*$amountOf_AIExpansionServer);
		$this->MaraisE___Bauxite->addRecipeForProduce2___            ('Copper Ingot', (4/3)*48*$amountOf_AIExpansionServer);
		$this->MaraisE___Bauxite->addRecipeForProduce____               ('Miner Mk.1: Copper Ore', 'Copper Ore', (4/3)*48*$amountOf_AIExpansionServer);
		$this->MaraisE___Bauxite->addRecipeForProduce2___        ('Cable', (4/3)*24*$amountOf_AIExpansionServer);
		$this->MaraisE___Bauxite->addRecipeForProduce2___          ('Wire', (4/3)*48*$amountOf_AIExpansionServer);
		$this->MaraisE___Bauxite->addRecipeForProduce2___            ('Copper Ingot', (4/3)*24*$amountOf_AIExpansionServer);
		$this->MaraisE___Bauxite->addRecipeForProduce____              ('Miner Mk.1: Copper Ore', 'Copper Ore', (4/3)*24*$amountOf_AIExpansionServer);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___    ('Ficsite Trigon', 15*$amountOf_AIExpansionServer);
		$this->MaraisS__Nitrogen->addRecipeForProduce____      ('Ficsite Ingot (Iron)', 'Ficsite Ingot', 5*$amountOf_AIExpansionServer);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___        ('Reanimated SAM', 20*$amountOf_AIExpansionServer);
		$this->MaraisS__Nitrogen->addRecipeForProduce____          ('Miner Mk.1: SAM', 'SAM', 80*$amountOf_AIExpansionServer);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___        ('Iron Ingot', 120*$amountOf_AIExpansionServer);
		$this->MaraisS__Nitrogen->addRecipeForProduce____          ('Miner Mk.1: Iron Ore', 'Iron Ore', 120*$amountOf_AIExpansionServer);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___    ('Excited Photonic Matter', 25000*$amountOf_AIExpansionServer); // + 25000 Dark Matter Residue

		$this->MaraisS__Nitrogen->addRecipeForProduce2___  ('Superposition Oscillator', 1*$amountOf_AIExpansionServer); // + 25000 Dark Matter Residue
		$this->Marais_____________addRecipesForProduce2__    ('Alclad Aluminum Sheet', 9*$amountOf_AIExpansionServer);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___    ('Excited Photonic Matter', 25000*$amountOf_AIExpansionServer);
	    $this->MaraisS__Nitrogen->addRecipeForProduce2___    ('Dark Matter Crystal', 6*$amountOf_AIExpansionServer);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___      ('Diamonds', 6*$amountOf_AIExpansionServer);
		$this->MaraisS__Nitrogen->addRecipeForProduce____        ('Miner Mk.1: Coal', 'Coal', 120*$amountOf_AIExpansionServer);
		$this->MaraisS__Nitrogen->addRecipeForProduce2___      ('Dark Matter Residue', (30000-25000)*$amountOf_AIExpansionServer); // - 25000 Dark Matter Residue produit par 'Excited Photonic Matter'
		$this->MaraisS__Nitrogen->addRecipeForProduce2___        ('Reanimated SAM', 2.5*$amountOf_AIExpansionServer);
		$this->MaraisS__Nitrogen->addRecipeForProduce____          ('Miner Mk.1: SAM', 'SAM', 10*$amountOf_AIExpansionServer);
		$this->MaraisE___Bauxite->addRecipeForProduce2___    ('Crystal Oscillator', 1*$amountOf_AIExpansionServer);
		$this->MaraisNO___Quartz->addRecipeForProduce2___       ('Quartz Crystal', 18*$amountOf_AIExpansionServer);
		$this->MaraisNO___Quartz->addRecipeForProduce____          ('Miner Mk.1: Raw Quartz', 'Raw Quartz', 30*$amountOf_AIExpansionServer);
		$this->MaraisE___Bauxite->addRecipeForProduce2___      ('Cable', 14*$amountOf_AIExpansionServer);
		$this->MaraisE___Bauxite->addRecipeForProduce2___        ('Wire', 28*$amountOf_AIExpansionServer);
		$this->MaraisE___Bauxite->addRecipeForProduce2___          ('Copper Ingot', 14*$amountOf_AIExpansionServer);
		$this->MaraisE___Bauxite->addRecipeForProduce____             ('Miner Mk.1: Copper Ore', 'Copper Ore', 14*$amountOf_AIExpansionServer);
		$this->MaraisE___Bauxite->addRecipeForProduce2___      ('Reinforced Iron Plate', 2.5*$amountOf_AIExpansionServer);
		$this->MaraisE___Bauxite->addRecipeForProduce2___        ('Iron Plate', 15*$amountOf_AIExpansionServer);
		$this->MaraisE___Bauxite->addRecipeForProduce2___          ('Iron Ingot', 22.5*$amountOf_AIExpansionServer);
		$this->MaraisE___Bauxite->addRecipeForProduce____             ('Miner Mk.1: Iron Ore', 'Iron Ore', 22.5*$amountOf_AIExpansionServer);
		$this->MaraisE___Bauxite->addRecipeForProduce2___        ('Screw', 30*$amountOf_AIExpansionServer);
		$this->MaraisE___Bauxite->addRecipeForProduce2___          ('Iron Rod', 7.5*$amountOf_AIExpansionServer);
		$this->MaraisE___Bauxite->addRecipeForProduce2___            ('Iron Ingot', 7.5*$amountOf_AIExpansionServer);
		$this->MaraisE___Bauxite->addRecipeForProduce____               ('Miner Mk.1: Iron Ore', 'Iron Ore', 7.5*$amountOf_AIExpansionServer);

	}

	private function Marais_____________addRecipesForProduce2__(string $expectedProductDisplayName, float $expectedProductAmount) {
		if ('Alclad Aluminum Sheet' == $expectedProductDisplayName) {
			$this->MaraisE___Bauxite->addRecipeForProduce2___('Alclad Aluminum Sheet', $expectedProductAmount);
			$this->MaraisE___Bauxite->addRecipeForProduce2___  ('Copper Ingot', (1/3)*$expectedProductAmount);
			$this->MaraisE___Bauxite->addRecipeForProduce____     ('Miner Mk.1: Copper Ore', 'Copper Ore', (1/3)*$expectedProductAmount);
			$this->MaraisE___Bauxite->addRecipeForProduce2___  ('Aluminum Ingot', $expectedProductAmount);
			$this->MaraisE___Bauxite->addRecipeForProduce2___    ('Aluminum Scrap', 1.5*$expectedProductAmount);
			$this->MaraisS__Nitrogen->addRecipeForProduce____      ('Miner Mk.1: Coal', 'Coal', 0.5*$expectedProductAmount);
			$this->MaraisE___Bauxite->addRecipeForProduce2___      ('Alumina Solution', 1000*$expectedProductAmount); // Residue : Silica
			$this->MaraisE___Bauxite->addRecipeForProduce____         ('Miner Mk.1: Bauxite', 'Bauxite', 1*$expectedProductAmount);
			$this->MaraisE___Bauxite->addRecipeForProduce____         ('Water Extractor: Water', 'Water', 1000*$expectedProductAmount);
			$this->MaraisNO___Quartz->addRecipeForProduce2___     ('Silica', (5/6)*$expectedProductAmount); // Soustraire la quantite produite par la recette : Alumina Solution
			$this->MaraisNO___Quartz->addRecipeForProduce____        ('Miner Mk.1: Raw Quartz', 'Raw Quartz', 0.5*$expectedProductAmount);
		} elseif ('Aluminum Ingot' == $expectedProductDisplayName) {
			$this->MaraisE___Bauxite->addRecipeForProduce2___('Aluminum Ingot', $expectedProductAmount);
			$this->MaraisE___Bauxite->addRecipeForProduce2___  ('Aluminum Scrap', 1.5*$expectedProductAmount);
			$this->MaraisS__Nitrogen->addRecipeForProduce____    ('Miner Mk.1: Coal', 'Coal', 0.5*$expectedProductAmount);
			$this->MaraisE___Bauxite->addRecipeForProduce2___    ('Alumina Solution', 1000*$expectedProductAmount); // Residue : Silica
			$this->MaraisE___Bauxite->addRecipeForProduce____       ('Miner Mk.1: Bauxite', 'Bauxite', 1*$expectedProductAmount);
			$this->MaraisE___Bauxite->addRecipeForProduce____       ('Water Extractor: Water', 'Water', 1000*$expectedProductAmount);
			$this->MaraisNO___Quartz->addRecipeForProduce2___   ('Silica', (5/6)*$expectedProductAmount); // Soustraire la quantite produite par la recette : Alumina Solution
			$this->MaraisNO___Quartz->addRecipeForProduce____      ('Miner Mk.1: Raw Quartz', 'Raw Quartz', 0.5*$expectedProductAmount);
		} elseif ('Plastic' == $expectedProductDisplayName) {
			$this->MaraisSE__CrudOil->addRecipeForProduce____('Alternate: Recycled Plastic', 'Plastic', $expectedProductAmount);
			$this->MaraisSE__CrudOil->addRecipeForProduce2___  ('Rubber', 0.5*$expectedProductAmount);
			$this->MaraisSE__CrudOil->addRecipeForProduce____    ('Oil Extractor: Crude Oil', 'Crude Oil', 750*$expectedProductAmount);
			$this->MaraisSE__CrudOil->addRecipeForConsume____  ('Alternate: Diluted Packaged Fuel', 'Heavy Oil Residue', 500*$expectedProductAmount);
			$this->MaraisSE__CrudOil->addRecipeForProduce2___    ('Packaged Water', 1*$expectedProductAmount);
			$this->MaraisSE__CrudOil->addRecipeForProduce____      ('Water Extractor: Water', 'Water', 1000*$expectedProductAmount);
			$this->MaraisSE__CrudOil->addRecipeForProduce____    ('Unpackage Fuel', 'Fuel', 1000*$expectedProductAmount);
			$this->MaraisSE__CrudOil->addRecipeForConsume____      ('Fuel Power', 'Fuel', 500*$expectedProductAmount);
		} elseif ('Rubber' == $expectedProductDisplayName) {
			$this->MaraisSE__CrudOil->addRecipeForProduce2___('Rubber', $expectedProductAmount);
			$this->MaraisSE__CrudOil->addRecipeForProduce____  ('Oil Extractor: Crude Oil', 'Crude Oil', 1500*$expectedProductAmount);
			$this->MaraisSE__CrudOil->addRecipeForConsume____  ('Alternate: Diluted Packaged Fuel', 'Heavy Oil Residue', 1000*$expectedProductAmount);
			$this->MaraisSE__CrudOil->addRecipeForProduce2___    ('Packaged Water', 2*$expectedProductAmount);
			$this->MaraisSE__CrudOil->addRecipeForProduce____      ('Water Extractor: Water', 'Water', 2000*$expectedProductAmount);
			$this->MaraisSE__CrudOil->addRecipeForProduce____    ('Unpackage Fuel', 'Fuel', 2000*$expectedProductAmount);
			$this->MaraisSE__CrudOil->addRecipeForConsume____      ('Fuel Power', 'Fuel', 2000*$expectedProductAmount);
		} else {
			throw new Exception($expectedProductDisplayName);
		}
	}

}

$marais = new Kemenyende(false);
$marais->proceed();
