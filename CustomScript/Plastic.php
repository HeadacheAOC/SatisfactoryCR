<?php
use Kemenyende\FactoryGame\Factory;
use Kemenyende\FactoryGame\Region;

class Marais extends Region {

	private ?Factory $MaraisSE__CrudOil = null;

	private const CateriumIngotAmount = 41.6;
	private const PlasticAmount = 296;
	private const RubberAmount = 38;



	protected function step1_addFactories() {
		$this->MaraisSE__CrudOil = $this->addFactory('Marais: Crud Oil (Sud-Est)');
	}

	protected function step2_addRecipes() {
		$this->addRecipesForAssemblyDirectorSystem(1/0.75);
		$this->addRecipesForThermalPropulsionRocket(1);
		$this->addRecipesForNuclearPasta(2);
	}

	protected function step4_Supply() {
	}

	public function addRecipesForAssemblyDirectorSystem(float $amountOf_AssemblyDirectorSystemRecipe) {
		self::prodCateriumIngot($this->MaraisSE__CrudOil, $amountOf_AssemblyDirectorSystemRecipe, 6);
		self::prodCateriumIngot($this->MaraisSE__CrudOil, $amountOf_AssemblyDirectorSystemRecipe, 25.2);
		self::prodRecycledPlastic($this->MaraisSE__CrudOil, $amountOf_AssemblyDirectorSystemRecipe, 9);
		self::prodRecycledPlastic($this->MaraisSE__CrudOil, $amountOf_AssemblyDirectorSystemRecipe, 69);
		self::prodRecycledPlastic($this->MaraisSE__CrudOil, $amountOf_AssemblyDirectorSystemRecipe, 48);
	}

	public function addRecipesForThermalPropulsionRocket(float $amountOf_ThermalPropulsionRocketRecipe) {

		// Turbo Motor: Rubber
		self::prodRubberAndFuel($this->MaraisSE__CrudOil, $amountOf_ThermalPropulsionRocketRecipe, 24);

		// Turbo Motor: Cooling System
		self::prodRubberAndFuel($this->MaraisSE__CrudOil, $amountOf_ThermalPropulsionRocketRecipe, 8);
		self::prodRecycledPlastic($this->MaraisSE__CrudOil, $amountOf_ThermalPropulsionRocketRecipe, 64);

		// Cooling System
		self::prodRubberAndFuel($this->MaraisSE__CrudOil, $amountOf_ThermalPropulsionRocketRecipe, 6);
	}

	public function addRecipesForNuclearPasta(float $amountOf_NuclearPastaRecipe) {
		self::prodRecycledPlastic($this->MaraisSE__CrudOil, $amountOf_NuclearPastaRecipe, 16);
		self::prodRecycledPlastic($this->MaraisSE__CrudOil, $amountOf_NuclearPastaRecipe, 16);
	}

	///// Alternatives de production

	private static function prodCateriumIngot(Factory $factory, float $ratio, float $CateriumIngot_amountToProduce) {
		$factory->addRecipeForProduce2___('Caterium Ingot', ($CateriumIngot_amountToProduce)*$ratio);
		$factory->addRecipeForProduce____  ('Miner Mk.1: Caterium Ore', 'Caterium Ore', ($CateriumIngot_amountToProduce*3)*$ratio);
	}

	private static function prodRecycledPlastic(Factory $factory, float $ratio, float $Plastic_amountToProduce) {
	$factory->addRecipeForProduce____('Alternate: Recycled Plastic', 'Plastic', ($Plastic_amountToProduce)*$ratio);
		$factory->addRecipeForProduce2___  ('Rubber', ($Plastic_amountToProduce/2)*$ratio);
		$factory->addRecipeForProduce____    ('Oil Extractor: Crude Oil', 'Crude Oil', ($Plastic_amountToProduce*750)*$ratio);
		$factory->addRecipeForConsume____  ('Alternate: Diluted Packaged Fuel', 'Heavy Oil Residue', ($Plastic_amountToProduce*500)*$ratio);
		$factory->addRecipeForProduce2___    ('Packaged Water', ($Plastic_amountToProduce)*$ratio);
		$factory->addRecipeForProduce____      ('Water Extractor: Water', 'Water', ($Plastic_amountToProduce*1000)*$ratio);
		$factory->addRecipeForProduce____    ('Unpackage Fuel', 'Fuel', ($Plastic_amountToProduce*1000)*$ratio);
		$factory->addRecipeForConsume____      ('Fuel Power', 'Fuel', ($Plastic_amountToProduce*500)*$ratio);
	}

	private static function prodRubberAndFuel(Factory $factory, float $ratio, float $Rubber_amountToProduce) {
		$factory->addRecipeForProduce2___('Rubber', ($Rubber_amountToProduce)*$ratio);
		$factory->addRecipeForProduce____  ('Oil Extractor: Crude Oil', 'Crude Oil', ($Rubber_amountToProduce*1500)*$ratio);
		$factory->addRecipeForConsume____  ('Alternate: Diluted Packaged Fuel', 'Heavy Oil Residue', ($Rubber_amountToProduce*1000)*$ratio);
		$factory->addRecipeForProduce2___    ('Packaged Water', ($Rubber_amountToProduce*2)*$ratio);
		$factory->addRecipeForProduce____      ('Water Extractor: Water', 'Water', ($Rubber_amountToProduce*2000)*$ratio);
		$factory->addRecipeForProduce____    ('Unpackage Fuel', 'Fuel', ($Rubber_amountToProduce*2000)*$ratio);
		$factory->addRecipeForConsume____      ('Fuel Power', 'Fuel', ($Rubber_amountToProduce*2000)*$ratio);
	}

}

$marais = new Marais();
$marais->proceed();

