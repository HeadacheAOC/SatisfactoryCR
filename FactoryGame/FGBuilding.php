<?php
namespace FactoryGame;

use Exception;

class FGBuilding extends FGElement
{

	// Power Consumption
	private float $mPowerConsumption; // ex: "15.000000"

	// Variable Manufacturer
	private float $mEstimatedMininumPowerConsumption = 0; // ex: 250.000000"
	private float $mEstimatedMaximumPowerConsumption = 0; // ex: 1500.000000"

	// Ressource extractor
	private int $mItemsPerCycle = 0; // ex: "1"
	private float $mExtractCycleTime = 1; // ex: "1.000000"
	private array $mAllowedResourceForms = array(); // array(string) "(RF_SOLID)" ou "(RF_LIQUID)" ou "(RF_LIQUID,RF_GAS)"
	private bool $mOnlyAllowCertainResources = false; // bool "True" ou "False"
	private array $mAllowedResources = array(); // array(string) ex: "(/Script/Engine.BlueprintGeneratedClass'\"/Game/FactoryGame/Resource/RawResources/CrudeOil/Desc_LiquidOil.Desc_LiquidOil_C\"',/Script/Engine.BlueprintGeneratedClass'\"/Game/FactoryGame/Resource/RawResources/NitrogenGas/Desc_NitrogenGas.Desc_NitrogenGas_C\"',/Script/Engine.BlueprintGeneratedClass'\"/Game/FactoryGame/Resource/RawResources/Water/Desc_Water.Desc_Water_C\"')",

	// Constant & Variable Generator
	private float $mPowerProduction = 0; // ex: "75.000000"

	// Constant Generator
	private int $mFuelLoadAmount = 0; // ex: "1"
	private bool $mRequiresSupplementalResource = false; // ex: "True"
	private int $mSupplementalLoadAmount = 0; // ex: "1000"
	private float $mSupplementalToPowerRatio = 0; // ex: "1.600000"
	private string $mFuelResourceForm = 'RF_INVALID'; // ex: "RF_SOLID"
	private array $mFuel = array(); //

	// Variable Generator
	private float $mVariablePowerProductionFactor = 0; // ex: "200.000000"


	function __toString2(int $format=0) {
		$str = parent::__toString2($format);
		switch($format) {
		case FGElement::TS_HTML_BLOCKTAG:
			$str .= " <span>🗲 {$this->getPowerConsumptionPM()} MJ</span>";
			$str .= '<h2>Can produce</h2>';
			$recipes = Pattern::searchRecipesByBuilding(FGElement::getCat('FGRecipe'), $this->ClassName, true);
			$str .= '<ul>';
			foreach($recipes as $recipe) {
				$str .= '<li>'.$recipe->__toString2($format).'</li>';
			}
			$str .= '</ul>';
			break;
		case FGElement::TS_HTML_INNERTAG:
			$str .= '<br><br>';
			if ($this->isResourceExtractor()) $str .= htmlspecialchars(' ResourcePM('.$this->getResourcePM().')');
			if ($this->isPowerGenerator()) {
				$str .= htmlspecialchars(' PowerGenerationPM('.-$this->getPowerConsumptionPM().')');
			} else {
				$str .= htmlspecialchars(' PowerConsumptionPM('.$this->getPowerConsumptionPM().')');
			}
			break;
		case FGElement::TS_HTML_TAGATTR_TITLE:
			$str .= '&#10;&#10;';
			if ($this->isResourceExtractor()) $str .= htmlspecialchars(' ResourcePM('.$this->getResourcePM().')');
			if ($this->isPowerGenerator()) {
				$str .= htmlspecialchars(' PowerGenerationPM('.-$this->getPowerConsumptionPM().')');
			} else {
				$str .= htmlspecialchars(' PowerConsumptionPM('.$this->getPowerConsumptionPM().')');
			}
			break;
		default:
			$str .= ' : ';
			if ($this->isResourceExtractor()) $str .= ' ResourcePM('.$this->getResourcePM().')';
			if ($this->isPowerGenerator()) {
				$str .= ' PowerGenerationPM('.-$this->getPowerConsumptionPM().')';
			} else {
				$str .= ' PowerConsumptionPM('.$this->getPowerConsumptionPM().')';
			}
		}

		return $str;
	}

	static function parse(string $NativeClass, object $buildingDesc): FGBuilding {

		$building = new FGBuilding($NativeClass, $buildingDesc);

		foreach($buildingDesc as $varname => $varvalue) {
			switch ($varname) {
				case "ClassName": //Identifiant ex: "Build_AssemblerMk1_C"
					$building->ClassName = $varvalue;
					break;
				case "mDisplayName": // ex: "Assembler"
					$building->mDisplayName = $varvalue;
					break;
				case "mDescription": // ex: "Crafts two parts into another part.\r\n\r\nCan be automated by feeding parts into it with a conveyor belt connected to the input. The produced parts can be automatically extracted by connecting a conveyor belt to the output."
					$building->mDescription = $varvalue;
					break;


				case "mPowerConsumption": // ex: "15.000000"
					$varvalue_AsFloat = $varvalue;
					if (!settype($varvalue_AsFloat, 'float')) throw new Exception();
					$building->mPowerConsumption = $varvalue_AsFloat;
					break;

				// Variable manufacturer
				case "mEstimatedMininumPowerConsumption": // ex: 250.000000"
					$varvalue_AsFloat = $varvalue;
					if (!settype($varvalue_AsFloat, 'float')) throw new Exception();
					$building->mEstimatedMininumPowerConsumption = $varvalue_AsFloat;
					break;
				case "mEstimatedMaximumPowerConsumption": // ex: 1500.000000"
					$varvalue_AsFloat = $varvalue;
					if (!settype($varvalue_AsFloat, 'float')) throw new Exception();
					$building->mEstimatedMaximumPowerConsumption = $varvalue_AsFloat;
					break;

				// Extractor
				case "mExtractCycleTime": // ex: "5.000000"
					$varvalue_AsFloat = $varvalue;
					if (!settype($varvalue_AsFloat, 'float')) throw new Exception();
					$building->mExtractCycleTime = $varvalue_AsFloat;
					break;
				case "mItemsPerCycle": // ex: "1"
					$varvalue_AsInt = $varvalue;
					if (!settype($varvalue_AsInt, 'int')) throw new Exception();
					$building->mItemsPerCycle = $varvalue_AsInt;
					break;
				case "mAllowedResourceForms": // array(string) "(RF_SOLID)" ou "(RF_LIQUID)" ou "(RF_LIQUID,RF_GAS)"
					$building->mAllowedResourceForms = explode(',', substr($varvalue, 1, strlen($varvalue)-2));
					break;
				case "mOnlyAllowCertainResources": // bool "True" ou "False"
					if ($varvalue == "True") $varvalue_AsBool = true;
					else if ($varvalue == "False") $varvalue_AsBool = false;
					else throw new Exception();
					$building->mOnlyAllowCertainResources = $varvalue_AsBool;
					break;
				case "mAllowedResources": // array(string) ex: "(/Script/Engine.BlueprintGeneratedClass'\"/Game/FactoryGame/Resource/RawResources/CrudeOil/Desc_LiquidOil.Desc_LiquidOil_C\"',/Script/Engine.BlueprintGeneratedClass'\"/Game/FactoryGame/Resource/RawResources/NitrogenGas/Desc_NitrogenGas.Desc_NitrogenGas_C\"',/Script/Engine.BlueprintGeneratedClass'\"/Game/FactoryGame/Resource/RawResources/Water/Desc_Water.Desc_Water_C\"')",
					if (!empty($varvalue)) {
						$varvalue_AsString = preg_replace('/[\'"\(\)]/', '', $varvalue);
						$varvalue_AsArray = explode(',', $varvalue_AsString);
						$varvalue_AsArray = array_map(function($val) {return FGElement::extractClassNameFromBPCN($val);}, $varvalue_AsArray);
						$building->mAllowedResources = $varvalue_AsArray;
					}
					break;


				// Constant & Variable Generator
				case "mPowerProduction":
					$varvalue_AsFloat = $varvalue;
					if (!settype($varvalue_AsFloat, 'float')) throw new Exception();
					$building->mPowerProduction = $varvalue_AsFloat;
					break;

				// Constant Generator
				case "mFuelLoadAmount": // ex: "1"
					$varvalue_AsInt = $varvalue;
					if (!settype($varvalue_AsInt, 'int')) throw new Exception();
					$building->mFuelLoadAmount = $varvalue_AsInt;
					break;
				case "mRequiresSupplementalResource": // ex: "True"
					if ($varvalue == "True") $varvalue_AsBool = true;
					else if ($varvalue == "False") $varvalue_AsBool = false;
					else throw new Exception();
					$building->mRequiresSupplementalResource = $varvalue_AsBool;
					break;
				case "mSupplementalLoadAmount": // ex: "1000"
					$varvalue_AsInt = $varvalue;
					if (!settype($varvalue_AsInt, 'int')) throw new Exception();
					$building->mSupplementalLoadAmount = $varvalue_AsInt;
					break;
				case "mSupplementalToPowerRatio":
						$varvalue_AsFloat = $varvalue;
						if (!settype($varvalue_AsFloat, 'float')) throw new Exception();
						$building->mSupplementalToPowerRatio = $varvalue_AsFloat;
						break;
				case "mFuelResourceForm": // ex: "RF_SOLID"
					$building->mFuelResourceForm = $varvalue;
					break;
				case "mFuel": // ex: [{"mFuelClass":"Desc_Coal_C","mSupplementalResourceClass":"Desc_Water_C","mByproduct":"","mByproductAmount":""},{"mFuelClass":"Desc_CompactedCoal_C","mSupplementalResourceClass":"Desc_Water_C","mByproduct":"","mByproductAmount":""},{"mFuelClass":"Desc_PetroleumCoke_C","mSupplementalResourceClass":"Desc_Water_C","mByproduct":"","mByproductAmount":""}]
					$varvalue_AsArray = array();
					foreach ($varvalue as $id => $fuel) {
						$varvalue_AsArray[$id] = array('mFuelClass' => $fuel->mFuelClass, 'mSupplementalResourceClass' => $fuel->mSupplementalResourceClass);
					}
					$building->mFuel = $varvalue_AsArray;
					break;

				// Variable Generator
				case "mVariablePowerProductionFactor": // ex: "200.000000"
					$varvalue_AsFloat = $varvalue;
					if (!settype($varvalue_AsFloat, 'float')) throw new Exception();
					$building->mVariablePowerProductionFactor = $varvalue_AsFloat;
					break;
			}
		}

		return $building;
	}
	
	/**
	 * Generer les recettes induites par le batiment.
	 * Concerne principalement les batiments de type generateur ou extracteur.
	 * @param FGBuilding $building
	 * @param array $items
	 * @throws Exception
	 * @return array
	 */
	public static function getInducedRecipes(FGBuilding $building, array &$allItems): array {
		/* @var $item FGItem */
		/* @var $ingredient FGItem */
		/* @var $waste FGItem */
		/* @var $product FGItem */

		$recipes = array();
		$recipeNativeClass = "/Script/CoreUObject.Class'/Script/FactoryGame.FGRecipe'";

		if ($building->isResourceExtractor()) {

			// Lister les ressources extractables par ce bâtiment
			if (!$building->isResourceExtractor()) return array();
			
			// Lister les ressources extractables par ce bâtiment
			$products = array();
			if ($building->mOnlyAllowCertainResources) {
				foreach($building->mAllowedResources as $productClassName) {
					$products[$productClassName] = $allItems[$productClassName];
				}
			} else {
				foreach($allItems as $item) {
					if (!$item->isRawRessource()) continue;
					if (!in_array($item->getForm(), $building->mAllowedResourceForms)) continue;
					$products[$item->getClassName()] = $item;
				}
			}

			// Créer une recette pour chaque ressources
			foreach($products as $productClassName => $product) {
				
				$purities = array(array(0.5, 'Impure'), array(1, null), array(2, 'Pure'));
				
				foreach($purities as $purity) {
	
					$recipe = FGRecipe::parse($recipeNativeClass, (object) array());
	
					// Bâtiment
					$recipe->setProducedIn(array($building->getClassName()));
	
					// Cycle
					$recipe->setCyclePM(60/$building->mExtractCycleTime);
	
					// Consommation
					$recipe->setIngredients(array());
	
					// Production
					$recipe->setProducts(array($productClassName => $building->mItemsPerCycle*$purity[0]));
	
					// Description
					FGRecipe::setPseudoIdentity($recipe, $building, $allItems, $purity[1]);
	
					$recipes[] = $recipe;
					
				}
			}


		} elseif ($building->isPowerGenerator()) {
			if (!empty($building->mFuel)) {
				if (!is_array($building->mFuel)) throw new Exception();

				foreach($building->mFuel as $fuel) {

					// Lister les carburants compatibles avec ce générateur
					$lstIngredientFuel = array();
					$mFuelClass = $fuel['mFuelClass'];
					if ('FGItem' == substr($mFuelClass, 0, 6)) { // FGItemDescriptorBiomass
						// Cas où un groupe d'ingrédients est désigné
						foreach($allItems as $item) {
							if (false!==strpos($item->getNativeClass(), $mFuelClass)) {
								if ($building->mFuelResourceForm != $item->getForm()) continue;
								if (empty($item->getFuelEnergy())) continue;
								$lstIngredientFuel[] = $item;
							}
						}
					} else {
						// Cas où un unique ingrédient est désigné
						$lstIngredientFuel[] = $allItems[$fuel['mFuelClass']];
					}

					// Créer une recette pour chaque carburant
					foreach($lstIngredientFuel as $ingredient) {
						$recipe = FGRecipe::parse($recipeNativeClass, (object) array());

						// Bâtiment
						$recipe->setProducedIn(array($building->getClassName()));

						// Cycle
						$recipe->setCyclePM(60/(($building->mFuelLoadAmount * $ingredient->getFuelEnergy()) / $building->mPowerProduction));

						// Consommation
						$consume = array();
						$consume[$ingredient->getClassName()] = $building->mFuelLoadAmount;
						if ($building->mRequiresSupplementalResource) {
							$ingredientSupplemental = $allItems[$fuel['mSupplementalResourceClass']];
							$consume[$ingredientSupplemental->getClassName()] = $building->mSupplementalToPowerRatio * $ingredient->getFuelEnergy();
						}
						$recipe->setIngredients($consume);

						// Production
						$produce = array();
						if ($ingredient->wasteProduction()>0) {
							$produce[$ingredient->getWasteClassName()] = $building->mFuelLoadAmount * $ingredient->wasteProduction();
							$waste = $allItems[$ingredient->getWasteClassName()];
							//$DisplayName = $waste->getDisplayName(); // "Plutonium Waste"
						}
						$recipe->setProducts($produce);

						// Description
						FGRecipe::setPseudoIdentity($recipe, $building, $allItems);

						$recipes[] = $recipe;
					}
				}
			}
		}
		return $recipes;
	}
	
	/////////////////////////
	///// Ressource extractor
	/////

	/**
	 * Determiner si ce batiment est de type "Extracteur de ressource naturelle"
	 * @return bool
	 */
	public function isResourceExtractor(): bool {
		return !empty($this->mItemsPerCycle);
	}
	
	/**
	 * Obtenir la quantite de ressources extraites par minute.
	 * @param float $purity 0.5:impure, 1:normal, 2:Pure
	 * @return float
	 */
	private function getResourcePM(float $purity=1): float {
		return $this->isResourceExtractor() ? $this->mItemsPerCycle*(60/$this->mExtractCycleTime)*$purity : 0;
	}

	
	/////////////////////////
	///// Power Generator
	/////

	/**
	 * Determiner si ce batiment est un generateur d'energie electrique
	 * @return bool
	 */
	public function isPowerGenerator(): bool {
		return $this->getPowerConsumptionPM() < 0;
	}

	/**
	 * Obtenir la quantite d'energie electrique consommee par ce batiment.
	 * Dans le cas d'un generateur d'energie, la valeur retournee sera negative.
	 * @return float
	 */
	public function getPowerConsumptionPM(): float {
		if (!empty($this->mPowerProduction)) {
			return -$this->mPowerProduction;
		} else if (!empty($this->mVariablePowerProductionFactor)) {
			return -$this->mVariablePowerProductionFactor;
		} else if (!empty($this->mEstimatedMaximumPowerConsumption)) {
			return $this->mEstimatedMaximumPowerConsumption;
		} else {
			return $this->mPowerConsumption;
		}
	}
}

