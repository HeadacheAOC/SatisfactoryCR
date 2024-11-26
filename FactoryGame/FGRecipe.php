<?php
namespace FactoryGame;

use Exception;

class FGRecipe extends FGElement
{
	private string $FullName = '';
	private array $mIngredients = array();
	private array $mProduct = array();
	private float $mManufactoringDuration = 0;
	private array $mProducedIn = array();

	function __toString2(int $format=0) {
		$str = parent::__toString2($format);

		$items = FGElement::getCat('FGItem');
		$buildings = FGElement::getCat('FGBuilding');

		switch($format) {
		case FGElement::TS_HTML_INNERTAG:
			break;

		// Alternative
		case FGElement::TS_HTML_BLOCKTAG:

			// 50 Non-fissile Uranium, 15000 Water <= Blender(Non-fissile Uranium) <= 37.5 Uranium Waste, 25 Silican, 15000 Nitric Acid, 15000 Sulfuric Acid

			// ProduceIn - ex: "Blender(Non-fissile Uranium)"
			$lst = array();
			foreach ($this->mProducedIn as $className) {
				$lst[] = $buildings[$className]->mDisplayName;
			}
			$strRecipe = htmlspecialchars(implode(', ', $lst)) .'('.$str.')';
			$str = '';

			// Output - ex: "50 Non-fissile Uranium, 15000 Water"
			$lst = array();
			foreach ($this->mProduct as $className => $amount) {
				$lst[] = htmlspecialchars(round($this->getProductPM($className),3).' '.$items[$className]->mDisplayName);
			}
			$str .= htmlspecialchars(implode(', ', $lst));

			// ProduceIn - ex: " <= Blender(Non-fissile Uranium) <= "
			$str .= htmlspecialchars(" <= {$strRecipe} <= ");

			// Input
			$lst = array();
			foreach ($this->mIngredients as $className => $amount) {
				$lst[] = htmlspecialchars(round($this->getIngredientPM($className),3).' '.$items[$className]->mDisplayName);
			}
			$str .= htmlspecialchars(implode(', ', $lst));


			break;

		// Alternative
		case FGElement::TS_HTML_TAGATTR_TITLE:

			// "Non-fissile Uranium&#10;PRODUCEIN - Blender&#10;CYCLE - 24s (2.5pm)&#10;&#10;OUTPUT - 20 Non-fissile Uranium (50pm)&#10;OUTPUT - 6000 Water (15000pm)&#10;&#10;INTPUT - 15 Uranium Waste (37.5pm)&#10;INTPUT - 10 Silica (25pm)&#10;INTPUT - 6000 Nitric Acid (15000pm)&#10;INTPUT - 6000 Sulfuric Acid (15000pm)"

			// ProduceIn
			$lst = array();
			foreach ($this->mProducedIn as $className) {
				$lst[] = $buildings[$className]->mDisplayName;
			}
			$str .= '&#10;PRODUCEIN - '.htmlspecialchars(implode(', ', $lst));

			// Cycle
			$str .= '&#10;CYCLE - '.htmlspecialchars($this->mManufactoringDuration .'s ('.$this->getCyclePM().'pm)');

			// HR
			$str .= '&#10;';

			// Output
			$lst = array();
			foreach ($this->mProduct as $className => $amount) {
				$lst[] = htmlspecialchars($amount.' '.$items[$className]->mDisplayName.' ('.round($this->getProductPM($className),3).'pm)');
			}
			foreach ($lst as $desc) {
				$str .= '&#10;OUTPUT - '. $desc;
			}

			// HR
			$str .= '&#10;';

			// Input
			$lst = array();
			foreach ($this->mIngredients as $className => $amount) {
				$lst[] = htmlspecialchars($amount.' '.$items[$className]->mDisplayName.' ('.round($this->getIngredientPM($className),3).'pm)');
			}
			foreach ($lst as $desc) {
				$str .= '&#10;INTPUT - '. $desc;
			}
			break;
		default:

			$str .= ' : ';

			$lst = array();
			foreach ($this->mProduct as $className => $amount) {
				$lst[] = $amount.' '.$items[$className]->mDisplayName.' ('.round($this->getProductPM($className),3).'pm)';
			}
			$str .= implode(', ', $lst);

			$str .= ' <= '.$this->mManufactoringDuration .'s ('.$this->getCyclePM().'pm) <= ';

			$lst = array();
			foreach ($this->mIngredients as $className => $amount) {
				$lst[] = $amount.' '.$items[$className]->mDisplayName.' ('.round($this->getIngredientPM($className),3).'pm)';
			}
			$str .= implode(', ', $lst);

			$str .= ' : ';

			$lst = array();
			foreach ($this->mProducedIn as $className) {
				$lst[] = $buildings[$className]->mDisplayName;
			}
			$str .= implode(', ', $lst);
		}

		return $str;
	}

	static function parse(string $NativeClass, object $recipeDesc): FGRecipe {

		$recipe = new FGRecipe($NativeClass, $recipeDesc);

		foreach($recipeDesc as $varname => $varvalue) {
			switch ($varname) {
				case "ClassName": //Identifiant ex: "Recipe_ConveyorPole_C"
					$recipe->ClassName = $varvalue;
					break;
				case "mDisplayName": //Nom de la recette ex: "Conveyor Pole"
					$recipe->mDisplayName = $varvalue;
					break;
				case "FullName": //Nom interne complet de la recette ex: "BlueprintGeneratedClass /Game/FactoryGame/Recipes/AlternateRecipes/New_Update3/Recipe_Alternate_AdheredIronPlate.Recipe_Alternate_AdheredIronPlate_C"
					$recipe->FullName = $varvalue;
					break;
				case "mIngredients": // 20241509: ((ItemClass="/Script/Engine.BlueprintGeneratedClass'/Game/FactoryGame/Resource/Parts/Cement/Desc_Cement.Desc_Cement_C'",Amount=2))
					if ('' === $varvalue) break; // FIX - 20241509

					$matches = array();
					if (0 == preg_match('/^\((?<Items>(,?\((?P<Item>ItemClass="\/Script\/Engine\.BlueprintGeneratedClass\'(?P<BlueprintClassName>[^\']+)\'",Amount=(?P<Amount>[^\)]+))\))+)\)$/', $varvalue, $matches)) throw new Exception($varvalue);
					$recipeComponents_serialized = $matches['Items'];
					if (0 == preg_match_all('/,?\((?P<Item>ItemClass="\/Script\/Engine\.BlueprintGeneratedClass\'(?P<BlueprintClassName>[^\']+)\'",Amount=(?P<Amount>[^\)]+))/', $recipeComponents_serialized, $matches)) throw new Exception($recipeComponents_serialized);

					$classNames = array();
					foreach($matches['BlueprintClassName'] as $k => $bpClassName) {
						$classNames[$k] = FGElement::extractClassNameFromBPCN($bpClassName);
					}

					$amounts = array();
					foreach($matches['Amount'] as $k => $amount) {
						$amounts[$k] = (int) $amount;
					}

					$recipe->mIngredients = array_combine($classNames, $amounts);
					break;
				case "mProduct": // 20241509: ((ItemClass="/Script/Engine.BlueprintGeneratedClass'/Game/FactoryGame/Buildable/Building/Wall/ConcreteWallSet/Desc_Wall_Concrete_8x1.Desc_Wall_Concrete_8x1_C'",Amount=1))
					$matches = array();
					if (0 == preg_match('/^\((?<Items>(,?\((?P<Item>ItemClass="\/Script\/Engine\.BlueprintGeneratedClass\'(?P<BlueprintClassName>[^\']+)\'",Amount=(?P<Amount>[^\)]+))\))+)\)$/', $varvalue, $matches)) throw new Exception($varvalue);
					$recipeProducts_serialized = $matches['Items'];
					if (0 == preg_match_all('/,?\((?P<Item>ItemClass="\/Script\/Engine\.BlueprintGeneratedClass\'(?P<BlueprintClassName>[^\']+)\'",Amount=(?P<Amount>[^\)]+))/', $recipeProducts_serialized, $matches)) throw new Exception($recipeProducts_serialized);

					$classNames = array();
					foreach($matches['BlueprintClassName'] as $k => $bpClassName) {
						$classNames[$k] = FGElement::extractClassNameFromBPCN($bpClassName);
					}

					$amounts = array();
					foreach($matches['Amount'] as $k => $amount) {
						$amounts[$k] = (int) $amount;
					}

					$recipe->mProduct = array_combine($classNames, $amounts);
					break;
				case "mManufactoringDuration": //"1.000000"
					$varvalue_AsFloat = $varvalue;
					if (!settype($varvalue_AsFloat, 'float')) throw new Exception();
					$recipe->mManufactoringDuration = $varvalue_AsFloat;
					break;
				case "mProducedIn": // ("/Game/FactoryGame/Equipment/BuildGun/BP_BuildGun.BP_BuildGun_C")
					$varvalue_AsArray = preg_split('/[,\(\)"]/', $varvalue, -1, PREG_SPLIT_NO_EMPTY);
					$classNames = array();
					foreach($varvalue_AsArray as $bpClassName) {
						$classNames[] = FGElement::extractClassNameFromBPCN($bpClassName);
					}
					$recipe->mProducedIn = $classNames;
					break;
			}
		}

		return $recipe;
	}

	public static function setPseudoIdentity(FGRecipe $recipe, FGBuilding $building, array &$items, ?String $DisplayNameSuffixe=null) {
		/* @var FGItem $primaryItem */
		$buildingType = null;
		$primaryItem = null;
		if ($building->isResourceExtractor()) {
			$buildingType = 'Extractor';
			$primaryItem = $items[array_key_first($recipe->mProduct)];
			$primaryItemPM = $recipe->getProductPM($primaryItem->getClassName());
			$primaryItemAmount = $recipe->mProduct[$primaryItem->getClassName()];
			$DisplayNamePrefix = $building->getDisplayName();
		} elseif ($building->isPowerGenerator()) {
			$buildingType = 'Generator';
			$primaryItem = $items[array_key_first($recipe->mIngredients)];
			$primaryItemPM = $recipe->getIngredientPM($primaryItem->getClassName());
			$primaryItemAmount = $recipe->mIngredients[$primaryItem->getClassName()];
			$DisplayNamePrefix = null;
			$DisplayNameSuffixe = "Power";
		} else {
			$buildingType = $building->getShortName();
			$primaryItem = $items[array_key_first($recipe->mProduct)];
			$primaryItemPM = $recipe->getProductPM($primaryItem->getClassName());
			$primaryItemAmount = $recipe->mProduct[$primaryItem->getClassName()];
			$DisplayNamePrefix = $building->getDisplayName();
		}

		 // "Plutonium Fuel Rod Power"
		if (empty($recipe->mDisplayName)) {
			$foo = array();
			if (!empty($DisplayNamePrefix)) $foo[] = "{$DisplayNamePrefix}:";
			$foo[] = $primaryItem->getDisplayName();
			if (!empty($DisplayNameSuffixe)) $foo[] = $DisplayNameSuffixe;
			
			$recipe->mDisplayName = implode(' ', $foo);
		}
		
		// "ClassName": "Recipe_SteelBeam",
		// "ClassName": "Recipe_Caterium_Copper",
		// "ClassName": "Recipe_SAMFluctuator",
		$ClassName = array();
		$ClassName[] = 'Recipe';
		$ClassName[] = $building->getShortName();
		$ClassName[] = $primaryItem->getName();
		if (!empty($DisplayNameSuffixe)) $ClassName[] = $DisplayNameSuffixe;
		$ClassName = implode('_', $ClassName);

		// "ClassName": "Recipe_SteelBeam_C",
		// "ClassName": "Recipe_Caterium_Copper_C",
		// "ClassName": "Recipe_SAMFluctuator_C",
		if (empty($recipe->ClassName)) {
			$recipe->ClassName = "{$ClassName}_C";
		}

		// "FullName": "BlueprintGeneratedClass /Game/FactoryGame/Recipes/Constructor/Recipe_SteelBeam.Recipe_SteelBeam_C",
		// "FullName": "BlueprintGeneratedClass /Game/FactoryGame/Recipes/Converter/ResourceConversion/Recipe_Caterium_Copper.Recipe_Caterium_Copper_C",
		// "FullName": "BlueprintGeneratedClass /Game/FactoryGame/Recipes/Assembler/Recipe_SAMFluctuator.Recipe_SAMFluctuator_C",
		if (empty($recipe->FullName)) {
			$foo = array();
			$foo[] = 'BlueprintGeneratedClass /Game/FactoryGame/Recipes';
			$foo[] = 'InducedRecipes';
			$foo[] = $buildingType;
			$foo[] = "{$ClassName}.{$recipe->ClassName}";
			
			$ClassName = array();
			
			$recipe->FullName = implode('/', $foo);
		}

	}

	static function fixDblDNames(array &$recipes) {
		$fix = array(
			'Turbo Rifle Ammo' => array(
				'Recipe_CartridgeChaos_C' => 'Turbo Rifle Ammo',
				'Recipe_CartridgeChaos_Packaged_C' => 'Turbo Rifle Ammo Packaged'
			)
		);
		foreach($fix as $dblDNames) {

			// S'assurer que le correctif soit applicable
			$isFixable = true;
			$dblDName = null;
			foreach(array_keys($dblDNames) as $ClassName) {
				if (!array_key_exists($ClassName, $recipes)) $isFixable = false;

				if (is_null($dblDName)) $dblDName = $recipes[$ClassName]->mDisplayName;
				else if ($recipes[$ClassName]->mDisplayName != $dblDName) $isFixable = false;
			}
			if (!$isFixable) continue;

			// Appliquer le correctif
			$id = 0;
			foreach(array_keys($dblDNames) as $ClassName) {
				$recipes[$ClassName]->mDisplayName = $dblDName . ($id++>0?' '.$id:'');
			}
		}

	}
	
	/**
	 * Definir la liste des ingredients consommes par cycle
	 * @param array $items
	 */
	function setIngredients(array $items) {
	    $this->mIngredients = $items;
	}
	
	/**
	 * Obtenir la liste des ingredients consommes par cycle
	 * @return array
	 */
	function getIngredients(): array {
	    return $this->mIngredients;
	}
	
	/**
	 * Definir la liste des elements produits par cycle
	 * @param array $items
	 */
	function setProducts(array $items) {
	    $this->mProduct = $items;
	}
	
	/**
	 * Obtenir la liste des elements produits par cycle
	 * @return array
	 */
	function getProducts(): array {
	    return $this->mProduct;
	}
	
	/**
	 * Definir la liste des batiments dans lesquels cette recette peut etre mise en oeuvre.
	 * @param array $buildings
	 */
	function setProducedIn(array $buildings) {
	    $this->mProducedIn = $buildings;
	}
	
	/**
	 * Obtenir la liste des batiments dans lesquels cette recette peut etre mise en oeuvre.
	 * @return array
	 */
	function getProducedIn(): array {
	    return $this->mProducedIn;
	}
	
	/**
	 * Definir le nombre de Tick de production par minute
	 * @param float $value
	 */
	function setCyclePM(float $value) {
		$this->mManufactoringDuration = 60/$value;
	}

	/**
	 * Obtenir le nombre de Tick de production par minute
	 * @return float
	 */
	function getCyclePM(): float {
		return 60/$this->mManufactoringDuration;
	}

	/**
	 * Obtenir le nombre d'exemplaire produit par minute
	 * @param string $itemClassName ClassName du produit
	 * @return float
	 */
	function getProductPM(string $ClassName): float {
		$amount = $this->mProduct[$ClassName] ?? 0;
		return $amount * $this->getCyclePM();
	}

	/**
	 * Obtenir le nombre d'exemplaire consomme par minute
	 * @param string $itemClassName ClassName de l'ingredient
	 * @return float
	 */
	function getIngredientPM(string $ClassName): float {
		$amount = $this->mIngredients[$ClassName] ?? 0;
		return $amount * $this->getCyclePM();
	}

	/**
	 * Determiner si la liste des ingredients correspond a la liste des produits.
	 * <br>Autrement dit : Cette recette est de type pass-through.
	 * <br>Autrement dit : Cette recette produit exactement ce qui entre...
	 * <br>Autrement dit : A quoi sert une telle recette ?
	 */
	function isPassThrough(): bool {
		if (count($this->mIngredients) != count($this->mProduct)) return false;

		foreach(array_keys($this->mIngredients) as $className) {
			if (!array_key_exists($className, $this->mProduct)) return false;
		}

		return true;
	}

	/**
	 * Determiner s'il s'agit d'une recette Altermative.
	 * @return bool
	 */
	function isAlternate(): bool {
		//TODO Se referer a FGSchematics semble etre plus juste
		//return (false !== stripos($this->ClassName, 'ALTERNATE')) || (false !== stripos($this->mDisplayName, 'ALTERNATE'));
		return 0 === strpos($this->FullName, "BlueprintGeneratedClass /Game/FactoryGame/Recipes/AlternateRecipes");
	}
	
	function isInduced(): bool {
		return 0 === strpos($this->FullName, "BlueprintGeneratedClass /Game/FactoryGame/Recipes/InducedRecipes");
	}

}

