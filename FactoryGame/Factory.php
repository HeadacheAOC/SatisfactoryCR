<?php
namespace FactoryGame;

use Exception;

class Factory
{
	/**
	 * @var null|string (Affichage) Nom de l'usine
	 */
	private string $name;

	/**
	 * @var array Objets mis a la disposition de cette usine.
	 * <ul>
	 * <li>KEY string ClassName de l'objet.</li>
	 * <li>VAL float Quantite par minute.</li>
	 * </ul>
	 */
	private array $supplies = array();

	/**
	 * @var array Recettes utilisees dans cette usine.
	 * <ul>
	 * <li>KEY string ClassName de la recette.</li>
	 * <li>VAL float Pourcentage d'exploitation. ex: Une valeur de 5.5 signifie une exploitation a 550% de cette recette et necessite donc 6 batiments.</li>
	 * </ul>
	 */
	private array $recipes = array();

	/**
	 * @var array Objets requis par les recettes de cette usine.
	 * <ul>
	 * <li>KEY string ClassName de l'objet.</li>
	 * <li>VAL float Quantite par minute.</li>
	 * </ul>
	 */
	private array $ingredients = array();

	/**
	 * @var array Objets produits par les recettes cette usine.
	 * <ul>
	 * <li>KEY string ClassName de l'objet.</li>
	 * <li>VAL float Quantite par minute.</li>
	 * </ul>
	 */
	private array $products = array();

	function __construct(string $name = 'Unnamed') {
		$this->setName($name);
	}

	/**
	 * Obtenir le nom de cette usine
	 * @return string
	 */
	function getName(): string {
		return $this->name;
	}

	/**
	 * Definir le nom de cette usine
	 * @param string $name
	 */
	function setName(string $name) {
		$this->name = $name;
	}

	/**
	 * Ajouter les fournitures et les recettes d'une autre usine
	 * @param Factory $factory
	 */
	function addFactory(Factory $factory) {
		foreach($factory->recipes as $ClassName => $amount) {
			$this->addRecipe______________($ClassName, $amount);
		}

		foreach($factory->supplies as $ClassName => $amount) {
			$this->addSupply($ClassName, $amount);
		}
	}


	//////////////////////////////////////////////////////////////////////
	// Recettes

	/**
	 * Augmenter le taux d'exploitation d'une recette.
	 * @param FGRecipe $recipe
	 * @param float $amount Facteur d'exploitation
	 */
	function addRecipeByObjet(FGRecipe $recipe, float $amount) {
		$recipeClassName = $recipe->getClassName();

		if (!array_key_exists($recipeClassName, $this->recipes)) $this->recipes[$recipeClassName] = 0;
		$this->recipes[$recipeClassName] += $amount;

		// Repercuter sur la consommation/production

		$multiplier = $amount * $recipe->getCyclePM();

		// Ajouter les ingrédients
		foreach ($recipe->getIngredients() as $ingrClassName => $ingrAmount) {
			$this->_addIngredient($ingrClassName, $multiplier * $ingrAmount);
		}

		// Ajouter les produis
		foreach ($recipe->getProducts() as $prodClassName => $prodAmount) {
			$this->_addProduct($prodClassName, $multiplier * $prodAmount);
		}

	}

	function addRecipe______________(string $ClassName, float $amount) {
		$this->addRecipeByObjet(FGElement::getByClassName('FGRecipe', $ClassName), $amount);
	}

	function addRecipeByDisplayName_(string $DisplayName, float $amount) {
		$this->addRecipeByObjet(FGElement::getByDisplayName('FGRecipe', $DisplayName), $amount);
	}

	function addRecipeForProduceSome(string $recipeDisplayName, array $expectedProducts) {
		$recipe = FGElement::getByDisplayName('FGRecipe', $recipeDisplayName);
		$amount_min = 0;
		foreach($expectedProducts as $expectedItemDisplayName => $expectedProductPM) {
			if ($expectedProductPM == 0) continue;
			$productClassName = FGElement::getClassNameByDisplayName('FGItem', $expectedItemDisplayName);
			$productPM = $recipe->getProductPM($productClassName);
			if (0 == $productPM) throw new Exception('Objet non produit par la recette designee');
			$amount = $expectedProductPM / $productPM;
			if ($amount>$amount_min) $amount_min = $amount;
		}
		$this->addRecipeByObjet($recipe, $amount_min);
	}

	function addRecipeForProduce____(string $recipeDisplayName, string $expectedProductDisplayName, float $expectedProductAmount) {
		$this->addRecipeForProduceSome($recipeDisplayName, array($expectedProductDisplayName => $expectedProductAmount));
	}

	function addRecipeForProduce2___(string $recipeAndProductDisplayName, float $expectedProductAmount) {
		$this->addRecipeForProduceSome($recipeAndProductDisplayName, array($recipeAndProductDisplayName => $expectedProductAmount));
	}

	/**
	 * Ajouter une recette au maximum de sa capacite de production d'apres les ingredients fournis.
	 * @param string $recipeDisplayName Nom de la recette
	 * @param array $availableIngredients array(string DisplayName => float amount)
	 */
	function addRecipeForConsumeSome(string $recipeDisplayName, array $availableIngredients) {
		$recipe = FGElement::getByDisplayName('FGRecipe', $recipeDisplayName);
		$amount_max = null;
		foreach($availableIngredients as $ingredientDisplayName => $maxIngredientPM) {
			if ($maxIngredientPM == 0) continue;
			$ingredientClassName = FGElement::getClassNameByDisplayName('FGItem', $ingredientDisplayName);
			$ingredientPM = $recipe->getIngredientPM($ingredientClassName);
			if (0 == $ingredientPM) continue;
			$amount = $maxIngredientPM / $ingredientPM;
			if (!isset($amount_max) || ($amount<$amount_max)) $amount_max = $amount;
		}
		$this->addRecipeByObjet($recipe, isset($amount_max) ? $amount_max : 0);
	}

	function addRecipeForConsume____(string $recipeDisplayName, string $ingredientDisplayName, float $ingredientAmount) {
		$this->addRecipeForConsumeSome($recipeDisplayName, array($ingredientDisplayName => $ingredientAmount));
	}

	function addRecipesFromFactory(Factory $factory) {
		foreach($factory->recipes as $ClassName => $amount) {
			$this->addRecipe______________($ClassName, $amount);
		}
	}

	/*
	 * addRecipeByDisplayName_  addRecipeByDisplayName_
	 * addRecipeForProduceSome addRecipeForProduceSome
	 * addRecipeForProduce____     addRecipeForProduce____
	 * addRecipeForProduce2___    addRecipeForProduce2___
	 * addRecipeForConsumeSome addRecipeForConsumeSome
	 * addRecipeForConsume____     addRecipeForConsume____
	 */

	//////////////////////////////////////////////////////////////////////
	// Consommation

	/**
	 * Ajouter l'objet a la liste des ingredients consommes par l'usine
	 * @param string $ClassName
	 * @param float $amount
	 */
	private function _addIngredient(string $ClassName, float $amount) {
		if (!array_key_exists($ClassName, $this->ingredients)) $this->ingredients[$ClassName] = 0;
		$this->ingredients[$ClassName] += $amount;
	}



	//////////////////////////////////////////////////////////////////////
	// Production

	/**
	 * Ajouter l'objet a la liste des objets produits par l'usine
	 * @param string $ClassName
	 * @param float $amount
	 */
	private function _addProduct(string $ClassName, float $amount) {
		if (!array_key_exists($ClassName, $this->products)) $this->products[$ClassName] = 0;
		$this->products[$ClassName] += $amount;
	}



	//////////////////////////////////////////////////////////////////////
	// Apport exterieure

	/**
	 * Ajouter l'objet a la liste des objets mis a la disposition de l'usine.
	 * @param string $ClassName
	 * @param float $amount
	 */
	function addSupply(string $ClassName, float $amount) {
		$this->addSupplyByObject(FGElement::getByClassName('FGItem', $ClassName), $amount);
	}

	function addSupplyByDisplayName(string $displayName, float $amount) {
		$this->addSupplyByObject(FGElement::getByDisplayName('FGItem', $displayName), $amount);
	}

	function addSupplyByObject(FGItem $item, float $amount) {
		$ClassName = $item->getClassName();
		if (!array_key_exists($ClassName, $this->supplies)) $this->supplies[$ClassName] = 0;
		$this->supplies[$ClassName] += $amount;
	}

	/**
	 * Ajouter les objets a la liste des objets mis a la disposition de l'usine.
	 * @param array $supplies array(string ClassName => float amount)
	 */
	function addSupplies(array $supplies) {
		foreach($supplies as $ClassName => $amount) {
			$this->addSupply($ClassName, $amount);
		}
	}

	function addSuppliesFromFactory(Factory $factory) {
		$this->addSupplies($factory->calcSurplus());
	}



	//////////////////////////////////////////////////////////////////////
	// SCENARIOS

	/**
	 * Augmenter le niveau d'exploitation des recettes en place pour produire, autant que faire ce peut, les ingredients manquants.
	 * @param bool $custom FALSE si cette fonction doit se limiter aux recettes en place.
	 * @param array $allowedRecipes (Ignored if custom=false)
	 */
	function tryToProdMissingIngredients(bool $custom = false, array $allowedRecipes = null) {

		if (is_null($allowedRecipes)) {
			if ($custom) {
				$allowedRecipes = FGElement::getCat('FGRecipe');
			} else {
				$allowedRecipes = array();
				foreach (array_keys($this->recipes) as $ClassName) {
					$allowedRecipes[$ClassName] = FGElement::getByClassName('FGRecipe', $ClassName);
				}
			}
		}

		Pattern::initialize($allowedRecipes);

		// Créer les bâtiments nécessaires pour produire les ingrédients nécessaires à la mise en production de l'usine
		do {
			$awake = false;

			// Parcourir la liste des ingredients necessaires a la mise en service de l'usine,
			// et ajouter les recettes qui permettraient de combler un eventuel deficite.
			foreach($this->ingredients as $ingrClassName => $ingrPM) {
				$ingredient = FGElement::getByClassName('FGItem', $ingrClassName);

				// Ignorer les ressources naturelles dont l'extraction
				// peut etre automatisee plus efficassement qu'au travers d'une recette.
				// Ex: Iron Ore, Water, Nitrogen Gaz, ...
				if ($ingredient->isRawRessource()) continue;

				// Ignorer les ressources naturelles dont l'extraction
				// se fait, le plus rentablement, a la main.
				// Ex: Leaves, Wood, Beryl Nut, ...
				if ($ingredient->isPickUpRessource()) continue;

				// Calculer le diferentiel entre l'offre et la demande
				$currentSupplyPM = array_key_exists($ingrClassName, $this->products) ? $this->products[$ingrClassName] : 0;
				$currentSupplyPM += array_key_exists($ingrClassName, $this->supplies) ? $this->supplies[$ingrClassName] : 0;
				$missingIngrPM = $ingrPM - $currentSupplyPM;

				if ($missingIngrPM>0) {
					// Tenter de combler le deficite

					// Rechercher la recette la plus adequate
					$recipe = Pattern::searchBestRecipeByProduct($allowedRecipes, $ingrClassName, true);
					if (is_null($recipe)) continue; // Aucune recette adaptee

					// Combler le deficite
					foreach ($recipe->getProducts() as $prodClassName => $prodPM) {
						if ($prodClassName === $ingrClassName) {
							$this->addRecipeByObjet($recipe, ($missingIngrPM/$prodPM) / $recipe->getCyclePM());
							$awake = true;
						}
					}
				}
			}
		} while ($awake);

	}

	function tryToDiversifyProd(array $allowedRecipes = null) {
		if (is_null($allowedRecipes)) $allowedRecipes = FGElement::getCat('FGRecipe');

		do {
			$more = false;

			$supplyable = array();
			foreach(array_keys($this->ingredients) as $ClassName) {
				if (!array_key_exists($ClassName, $supplyable)) $supplyable[$ClassName] = 0;
			}
			foreach(array_keys($this->products) as $ClassName) {
				if (!array_key_exists($ClassName, $supplyable)) $supplyable[$ClassName] = 0;
			}
			foreach(array_keys($this->supplies) as $ClassName) {
				if (!array_key_exists($ClassName, $supplyable)) $supplyable[$ClassName] = 0;
			}


			$newRecipes = Pattern::searchRecipesByIngredients($supplyable, $allowedRecipes, true);

			foreach($newRecipes as $recipe) {
				$more = true;
				$this->addRecipeByObjet($recipe, 0);
			}

		} while ($more);
	}



	//////////////////////////////////////////////////////////////////////
	// ANALYSE

	private static function consume(string $ClassName, array &$items_order, array &$items_consumable, array &$items_consumed): float {

		// Checkpoint - Cet objet doit figurer sur le bon de commande
		if (!array_key_exists($ClassName, $items_order)) return 0;
		$amount_ordered = $items_order[$ClassName];

		// Checkpoint - Cet objet doit etre reference dans le stock disponible
		if (!array_key_exists($ClassName, $items_consumable)) return $amount_ordered;
		$amount_available = $items_consumable[$ClassName];

		// Tenter d'honnorer la commande
		$amount_satisfied = 0;
		if (!isset($items_consumed[$ClassName])) $items_consumed[$ClassName] = 0;
		if (round($amount_available, 3) == round($amount_ordered, 3)) {

			// Juste ce qu'il faut en stock
			$amount_satisfied += $amount_available;

			$items_consumed[$ClassName] += $amount_available;
			$items_consumable[$ClassName] = 0; //Vider le stock

		} else if ($amount_available > $amount_ordered) {

			// Plus qu'il n'en faut en stock
			$amount_satisfied += $amount_ordered;

			$items_consumed[$ClassName] += $amount_ordered;
			$items_consumable[$ClassName] -= $amount_ordered;

		} else if ($amount_available > 0) {

			// Pas assez en stock
			$amount_satisfied += $amount_available;

			$items_consumed[$ClassName] += $amount_available;
			$items_consumable[$ClassName] = 0; //Vider le stock

		}
		$items_order[$ClassName] -= $amount_satisfied;

		return $amount_ordered - $amount_satisfied;
	}

	function calcSurplus(bool $includeSupplies = true): array {
		$products_consumed = array();
		$products_surplus = array();
		$supplies_consumed = array();
		$supplies_surplus = array();
		$supplies_missing = array();
		$this->calcProduction($products_consumed, $products_surplus, $supplies_consumed, $supplies_surplus, $supplies_missing);

		$surplus = $products_surplus;
		if ($includeSupplies) {
			foreach($supplies_surplus as $className => $amount) {
				if (!array_key_exists($className, $surplus)) {
					$surplus[$className] = 0;
				}
				$surplus[$className] += $amount;
			}
		}

		return $surplus;
	}

	/**
	 * @param array $products_consumed Liste des objets produits et consommes
	 * @param array $products_surplus Liste des objets produits mais pas consommes
	 * @param array $supplies_consumed Liste des objets mis a disposition et consommes
	 * @param array $supplies_surplus Liste des objets mis a disposition mais pas consommes
	 * @param array $supplies_missing Liste des objets manquants (a fournir)
	 */
	function calcProduction(
		array &$products_consumed,
		array &$products_surplus,
		array &$supplies_consumed,
		array &$supplies_surplus,
		array &$supplies_missing) {

		// Vider les listes
		while (!empty($products_consumed)) array_pop($products_consumed);
		while (!empty($products_surplus)) array_pop($products_surplus);
		while (!empty($supplies_consumed)) array_pop($supplies_consumed);
		while (!empty($supplies_surplus)) array_pop($supplies_surplus);
		while (!empty($supplies_missing)) array_pop($supplies_missing);

		$order = $this->ingredients;
		$products_consumable = $this->products;
		$supplies_consumable = $this->supplies;

		//
		foreach($this->ingredients as $ClassName => $amount) {

			// Consommer les objets produits
			$amount = self::consume($ClassName, $order, $products_consumable, $products_consumed);

			// Consommer les objets mis a disposition
			self::consume($ClassName, $order, $supplies_consumable, $supplies_consumed);
		}

		// Basculer les ingredients non fournis dans la liste des objets manquants
		foreach($order as $ClassName => $amount) {
			if (round($amount, 3)==0) continue;
			$supplies_missing[$ClassName] = $amount;
		}

		// Basculer les produits non consommes dans la liste des objets produits en exces
		foreach($products_consumable as $ClassName => $amount) {
			if (round($amount, 3)==0) continue;
			$products_surplus[$ClassName] = $amount;
		}

		// Basculer les objets mis a disposition mais non consommes dans la liste des objets fournis en exces
		foreach($supplies_consumable as $ClassName => $amount) {
			if (round($amount, 3)==0) continue;
			$supplies_surplus[$ClassName] = $amount;
		}

	}


	//////////////////////////////////////////////////////////////////////
	// AFFICHAGE

	function show(string $style_bgc=null) {

		$products_consumed = array();
		$products_surplus = array();
		$supplies_consumed = array();
		$supplies_surplus = array();
		$supplies_missing = array();
		$this->calcProduction($products_consumed, $products_surplus, $supplies_consumed, $supplies_surplus, $supplies_missing);

		echo '<fieldset';
		if (isset($style_bgc)) {
			echo ' style="';
			if (isset($style_bgc)) {
				echo 'background-color:', $style_bgc, ';';
			}
			echo '"';
		}
		echo '><legend>FACTORY - ', $this->getName(), '</legend>';

		///// Consommation

		echo '<h2>Consommation</h2><ul>';

		echo '<h3>', count($supplies_missing), ' Manquant</h3><ul>';
		foreach($supplies_missing as $ClassName => $amount) {
			echo '<li>'.round($amount, 3).' ', View::echoFGElement(FGElement::getByClassName('FGItem', $ClassName)), '</li>';
		}
		echo '</ul>';

		echo '<h3>', count($supplies_consumed), ' Fourni</h3><ul>';
		foreach($supplies_consumed as $ClassName => $amount) {
			echo '<li>'.round($amount, 3).' ', View::echoFGElement(FGElement::getByClassName('FGItem', $ClassName)), '</li>';
		}
		echo '</ul>';

		echo '<h3>', count($products_consumed), ' Produit</h3><ul>';
		foreach($products_consumed as $ClassName => $amount) {
			echo '<li>'.round($amount, 3).' ', View::echoFGElement(FGElement::getByClassName('FGItem', $ClassName)), '</li>';
		}
		echo '</ul>';

		echo '</ul>';

		///// Sortie

		echo '<h2>Production</h2><ul>';

		echo '<h3>', count($products_surplus) , ' Produit</h3><ul>';
		foreach($products_surplus as $ClassName => $amount) {
			echo '<li>'.round($amount, 3).' ', View::echoFGElement(FGElement::getByClassName('FGItem', $ClassName)), '</li>';
		}
		echo '</ul>';

		echo '<h3>', count($supplies_surplus) , ' Fourni</h3><ul>';
		foreach($supplies_surplus as $ClassName => $amount) {
			echo '<li>'.round($amount, 3).' ', View::echoFGElement(FGElement::getByClassName('FGItem', $ClassName)), '</li>';
		}
		echo '</ul>';

		echo '</ul>';

		///// Usine - Batiments/Recettes

		echo '<h2>', count($this->recipes), ' Recettes</h2><ul>';
		$buildings = FGElement::getCat('FGBuilding');
		$buildingsMaxConsumption = 0;
		foreach($this->recipes as $ClassName => $amount) {
			$recipe = FGElement::getByClassName('FGRecipe', $ClassName);

			// Rechercher le bâtiment chargé d'utiliser la recette
			$building = null;
			foreach ($recipe->getProducedIn() as $buildingClassName) {
				if (array_key_exists($buildingClassName, $buildings)) $building = FGElement::getByClassName('FGBuilding', $buildingClassName);
				if (!is_null($building)) break;
			}
			if (is_null($building)) throw new Exception();

			$buildingsMaxConsumption += ($building->getPowerConsumptionPM($this->recipes)) * ceil($amount);



			echo '<li>'.ceil($amount).' ('.($amount != 0 ? round(($amount/ceil($amount))*100,4) : 'na').'%)'.' ', View::echoFGElement($building),'(',View::echoFGElement($recipe),')</li>';
		}
		echo '</ul>';

		echo '<h2>Consommation : ', $buildingsMaxConsumption, ' MW</h2>';


		echo '</fieldset>';
	}

}

