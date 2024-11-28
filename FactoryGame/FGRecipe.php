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
		case FGElement::TS_HTML_INNERBLOCKTAG:
			
			$recipeDName = $str;
			$str = '';

			// 50 Non-fissile Uranium, 15000 Water <= Blender(Non-fissile Uranium) <= 37.5 Uranium Waste, 25 Silican, 15000 Nitric Acid, 15000 Sulfuric Acid

			// ProduceIn - ex: "Blender(Non-fissile Uranium)"
			$lst = array();
			foreach ($this->mProducedIn as $className) {
				/* @var $building FGBuilding */
				$building = $buildings[$className];
				$buildingPower = $building->getPowerConsumptionPM();
				
				$buildingLabel = $building->getDisplayName();
				if ($buildingPower<0) {
					$buildingLabel .= '🗲'.(-1*$buildingPower);
				}
				
				$lst[] = '<b>'. $buildingLabel .'</b>';
			}
			$strRecipe = implode(', ', $lst) .'('.$recipeDName.')';

			// Output - ex: "50 Non-fissile Uranium, 15000 Water"
			$lst = array();
			foreach ($this->mProduct as $className => $amount) {
				$lst[] = htmlspecialchars(round($this->getProductPM($className),3).' '.$items[$className]->mDisplayName);
			}
			$str .= implode(', ', $lst);

			// ProduceIn - ex: " <= Blender(Non-fissile Uranium) <= "
			$str .= htmlspecialchars(' <= ') . $strRecipe . htmlspecialchars(' <= ');

			// Input
			$lst = array();
			foreach ($this->mIngredients as $className => $amount) {
				$lst[] = htmlspecialchars(round($this->getIngredientPM($className),3).' '.$items[$className]->mDisplayName);
			}
			$str .= htmlspecialchars(implode(', ', $lst));

			break;
			
			

		// Alternative
		case FGElement::TS_HTML_BLOCKTAG:
			
			$str .= '<h2>Recipe</h2>';
			$str .= $this->__toString2(FGElement::TS_HTML_INNERBLOCKTAG);

			$primProduct = $this->getPrimaryProduct();
			$str .= '<h2>Alternative</h2>';
			$recipes = array();
			if (!is_null($primProduct)) {
				$recipes = Pattern::searchRecipesByProduct(FGElement::getCat('FGRecipe'), $primProduct->ClassName, true);
				FGRecipe::asort($recipes, FGRecipe::SORTASC, FGRecipe::SORTBY_ITEM_PRODPM, $primProduct);
			}
			unset($primProduct);
			
			if (array_key_exists($this->ClassName, $recipes)) unset($recipes[$this->ClassName]);
			
			if (empty($recipes)) {
				$str .= '<i>none</i>';
			} else {
				$str .= '<ul>';
				foreach($recipes as $recipe) {
					$str .= '<li>'.$recipe->__toString2(FGElement::TS_HTML_INNERBLOCKTAG).'</li>';
				}
				$str .= '</ul>';
			}
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
	
	
	public const SORTBY_DNAME = 1;
	public const SORTBY_ITEM_CONSPM = 2;
	public const SORTBY_ITEM_PRODPM = 3;
	public const SORTBY_PROD = 4;
	
	
	public const SORTNATURAL = 0;
	public const SORTASC = 1;
	public const SORTDESC = 2;
	
	/**
	 * 
	 * @param array $recipes
	 * @param int $asc_desc 1:ASC, 2:DESC. 0:none
	 * @param int $type 
	 * <ul>
	 * <li>0: none</li>
	 * <li>1: Trier en fonction du nom du premier element consommes.</li>
	 * <li>2: Trier en fonction de la vitesse de consommation de l'element designe.</li>
	 * <li>3: Trier en fonction de la vitesse de production de l'element designe.</li>
	 * <li>3: Trier en fonction du nom du premier element produit puis de la vitesse de production de ce dernier.</li>
	 * </ul>
	 * @param FGItem $item
	 */
	static function asort(array &$recipes, int $asc_desc, int $type, ?FGItem $item=null) {
		
		switch($type) {
			case self::SORTBY_DNAME:
				uasort($recipes, function ($compFGRecipe1, $compFGRecipe2) {
					return strcasecmp($compFGRecipe1->getPrimaryProductDisplayName(), $compFGRecipe2->getPrimaryProductDisplayName());
				});
				break;
			case self::SORTBY_ITEM_CONSPM:
				uasort($recipes, function ($compFGRecipe1, $compFGRecipe2) use ($item) {
					return floor($compFGRecipe1->getIngredientPM($item->getClassName())*100)-floor($compFGRecipe2->getIngredientPM($item->getClassName())*100);
				});
				break;
			case self::SORTBY_ITEM_PRODPM:
				uasort($recipes, function ($compFGRecipe1, $compFGRecipe2) use ($item) {
					return floor($compFGRecipe1->getProductPM($item->getClassName())*100)-floor($compFGRecipe2->getProductPM($item->getClassName())*100);
				});
				break;
			case self::SORTBY_PROD:
				uasort($recipes, function ($compFGRecipe1, $compFGRecipe2) {
					
					$primProduct1 = $compFGRecipe1->getPrimaryProduct();
					$primProduct2 = $compFGRecipe2->getPrimaryProduct();
					
					$primProductDName1 = !is_null($primProduct1) ? $primProduct1->getDisplayName() : '';
					$primProductDName2 = !is_null($primProduct2) ? $primProduct2->getDisplayName() : '';
					
					$byDName = strcasecmp($primProductDName1, $primProductDName2);
					
					if (0 != $byDName) return $byDName;
					
					$primProductPM1 = !is_null($primProduct1) ? $compFGRecipe1->getProductPM($primProduct1->getClassName()) : 0;
					$primProductPM2 = !is_null($primProduct2) ? $compFGRecipe2->getProductPM($primProduct2->getClassName()) : 0;
					
					return floor($primProductPM1*100)-floor($primProductPM2*100);
				});
				break;
		}
	}
	
	/**
	 * @return string
	 */
	function getPrimaryProductDisplayName(): string {
		/* @var $item FGItem */
		$item = $this->getPrimaryProduct();
		if (is_null($item)) return '';
	    return $item->getDisplayName();
	}
	
	function getPrimaryProduct(): ?FGItem {
		if (empty($this->mProduct)) return null;
		$ClassName = array_key_first($this->mProduct);
		return FGItem::getByClassName('FGItem', $ClassName);
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

