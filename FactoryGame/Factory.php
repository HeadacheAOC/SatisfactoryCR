<?php
namespace FactoryGame;

use Exception;

class Factory
{
    /**
     * 
     * @var null|string (Affichage) Nom de l'usine
     */
    private ?string $name;
    
    /**
     * Objets fournis "genereusement" a cette usine.
     * @var array
     * <ul>
     * <li>KEY string ClassName d'identifaction de l'objet.</li>
     * <li>VAL float Quantite par minute.</li>
     * </ul>
     */
    private array $supplies = array();
    
    /**
     * Recettes utilisees par cette usine.
     * @var array
     * <ul>
     * <li>KEY string ClassName d'identifaction de l'objet.</li>
     * <li>VAL float Pourcentage d'exploitation. ex: Une valeur de 5.5 signifie une exploitation a 550% de cette recette et necessite donc au moins 6 batiments.</li>
     * </ul>
     */
    private array $recipes = array();
    
    /**
     * Liste des objets consommés, par minute, dans cette usine.
     * @var array
     * <ul>
     * <li>KEY string ClassName d'identifaction de l'objet.</li>
     * <li>VAL float Quantite par minute.</li>
     * </ul>
     */
    private array $ingredients = array();
    
    /**
     * Liste des objets produits, par minute, dans cette usine.
     * @var array
     * <ul>
     * <li>KEY string ClassName d'identifaction de l'objet.</li>
     * <li>VAL float Quantite par minute.</li>
     * </ul>
     */
    private array $products = array();
    
    function __construct(?string $name = null) {
        $this->name = $name;
    }
    
    function getName(): string {
        return is_null($this->name) ? 'Unnamed' : $this->name;
    }
    
    function setName(?string $name) {
        $this->name = $name;
    }
    
    
    
    //////////////////////////////////////////////////////////////////////
    // Recettes
    
    /**
     * Obtenir la liste des recettes utilisées par l'usine
     * @return array
     */
    function getRecipes(): array {
        return $this->recipes;
    }
    
    function &getFGRecipes(): array {
        $fgRecipes = array();
        foreach (array_keys($this->recipes) as $ClassName) {
            $fgRecipes[$ClassName] = FGElement::getByClassName('FGRecipe', $ClassName);
        }
        return $fgRecipes;
    }
    
    /**
     * Ajouter la recette designée a la liste des recettes qui DOIVENT etre utilisées par l'usine.
     * @param FGRecipe $recipe Recette a ajouter
     * @param float $amount Nombre d'exemplaires a ajouter
     */
    function addRecipeByObjet(FGRecipe $recipe, float $amount) {
        $recipeClassName = $recipe->getClassName();
        if (!array_key_exists($recipeClassName, $this->recipes)) $this->recipes[$recipeClassName] = 0;
        $this->recipes[$recipeClassName] += $amount;
        
        $multiplier = $amount * $recipe->getCyclesPM();
        
        // Ajouter les ingrédients
        foreach ($recipe->mIngredients as $ingrClassName => $ingrAmount) {
            $this->_addIngredient($ingrClassName, $multiplier * $ingrAmount);
        }
        
        // Ajouter la production
        foreach ($recipe->mProduct as $prodClassName => $prodAmount) {
            $this->_addProduct($prodClassName, $multiplier * $prodAmount);
        }
        
    }
    
    function addRecipe(string $ClassName, float $amount) {
        $this->addRecipeByObjet(FGElement::getByClassName('FGRecipe', $ClassName), $amount);
    }
    
    function addRecipeByDisplayName(string $DisplayName, float $amount) {
        $this->addRecipeByObjet(FGElement::getByDisplayName('FGRecipe', $DisplayName), $amount);
    }
    
    function addRecipeByDisplayName2(string $DisplayName, array $expectedProducts) {
        $recipe = FGElement::getByDisplayName('FGRecipe', $DisplayName);
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
    
    function addRecipeByDisplayName3(string $recipeDisplayName, string $expectedProductDisplayName, float $expectedProductAmount) {
        $this->addRecipeByDisplayName2($recipeDisplayName, array($expectedProductDisplayName => $expectedProductAmount));
    }
    
    function addRecipeByDisplayName4(string $DisplayName, array $supply) {
        $recipe = FGElement::getByDisplayName('FGRecipe', $DisplayName);
        $amount_max = null;
        foreach($supply as $expectedItemDisplayName => $expectedIngredientPM) {
            if ($expectedIngredientPM == 0) continue;
            $productClassName = FGElement::getClassNameByDisplayName('FGItem', $expectedItemDisplayName);
            $ingredientPM = $recipe->getIngredientPM($productClassName);
            if (0 == $ingredientPM) continue;
            $amount = $expectedIngredientPM / $ingredientPM;
            if (!isset($amount_max) || ($amount<$amount_max)) $amount_max = $amount;
        }
        $this->addRecipeByObjet($recipe, isset($amount_max) ? $amount_max : 0);
    }
    
    function addRecipeByDisplayName5(string $recipeDisplayName, string $ingredientDisplayName, float $ingredientAmount) {
        $this->addRecipeByDisplayName4($recipeDisplayName, array($ingredientDisplayName => $ingredientAmount));
    }
    
    function addRecipeByDisplayName6(string $recipeAndProductDisplayName, float $expectedProductAmount) {
        $this->addRecipeByDisplayName2($recipeAndProductDisplayName, array($recipeAndProductDisplayName => $expectedProductAmount));
    }
    
    //////////////////////////////////////////////////////////////////////
    // Consommation
    
    function getIngredients() {
        return $this->ingredients;
    }
    
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
     * Obtenir la liste des objets produits dans l'usine
     * @return array
     */
    function getProducts() {
        return $this->products;
    }
    
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
    
    function getSupplies() {
        return $this->supplies;
    }
    
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
     * @param array<string> $supplies 
     * @see Factory::addSupply()
     */
    function addSupplies(array $supplies) {
        foreach($supplies as $ClassName => $amount) {
            $this->addSupply($ClassName, $amount);
        }
    }
    
    function addFactory(Factory $factory) {
        foreach($factory->recipes as $ClassName => $amount) {
            $this->addRecipe($ClassName, $amount);
        }
        
        foreach($factory->supplies as $ClassName => $amount) {
            $this->addSupply($ClassName, $amount);
        }
    }
    
    function addSuppliesByFactory(Factory $factory) {
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
        if (is_null($allowedRecipes)) $allowedRecipes = $custom ? FGElement::getAll('FGRecipe') : $this->getFGRecipes();
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
                    foreach ($recipe->mProduct as $prodClassName => $prodPM) {
                        if ($prodClassName === $ingrClassName) {
                            $this->addRecipeByObjet($recipe, ($missingIngrPM/$prodPM) / $recipe->getCyclesPM());
                            $awake = true;
                        }
                    }
                }
            }
        } while ($awake);
        
    }
    
    function tryToDiversifyProd(array $allowedRecipes = null) {
        if (is_null($allowedRecipes)) $allowedRecipes = FGElement::getAll('FGRecipe');
        
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
    
    function calcSurplus(): array {
        $products_consumed = array();
        $products_surplus = array();
        $supplies_consumed = array();
        $supplies_surplus = array();
        $supplies_missing = array();
        $this->calcProduction($products_consumed, $products_surplus, $supplies_consumed, $supplies_surplus, $supplies_missing);
        
        $surplus = $products_surplus;
        foreach($supplies_surplus as $className => $amount) {
            if (!array_key_exists($className, $surplus)) {
                $surplus[$className] = 0;
            }
            $surplus[$className] += $amount;
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
            echo '<li>x'.round($amount, 3).' ', View::echoFGElement(FGElement::getByClassName('FGItem', $ClassName)), '</li>';
        }
        echo '</ul>';
        
        echo '<h3>', count($supplies_consumed), ' Fourni</h3><ul>';
        foreach($supplies_consumed as $ClassName => $amount) {
            echo '<li>x'.round($amount, 3).' ', View::echoFGElement(FGElement::getByClassName('FGItem', $ClassName)), '</li>';
        }
        echo '</ul>';
        
        echo '<h3>', count($products_consumed), ' Produit</h3><ul>';
        foreach($products_consumed as $ClassName => $amount) {
            echo '<li>x'.round($amount, 3).' ', View::echoFGElement(FGElement::getByClassName('FGItem', $ClassName)), '</li>';
        }
        echo '</ul>';
        
        echo '</ul>';
        
        ///// Sortie
        
        echo '<h2>Production</h2><ul>';
        
        echo '<h3>', count($products_surplus) , ' Produit</h3><ul>';
        foreach($products_surplus as $ClassName => $amount) {
            echo '<li>x'.round($amount, 3).' ', View::echoFGElement(FGElement::getByClassName('FGItem', $ClassName)), '</li>';
        }
        echo '</ul>';
        
        echo '<h3>', count($supplies_surplus) , ' Fourni</h3><ul>';
        foreach($supplies_surplus as $ClassName => $amount) {
            echo '<li>x'.round($amount, 3).' ', View::echoFGElement(FGElement::getByClassName('FGItem', $ClassName)), '</li>';
        }
        echo '</ul>';
        
        echo '</ul>';
        
        ///// Usine - Batiments/Recettes
        
        echo '<h2>', count($this->recipes), ' Recettes</h2><ul>';
        $buildings = FGElement::getAll('FGBuilding');
        $buildingsMaxConsumption = 0;
        foreach($this->recipes as $ClassName => $amount) {
            $recipe = FGElement::getByClassName('FGRecipe', $ClassName);
            
            // Rechercher le bâtiment chargé d'utiliser la recette
            $building = null;
            foreach ($recipe->mProducedIn as $buildingClassName) {
                if (!is_null($building)) break;
                if (array_key_exists($buildingClassName, $buildings)) $building = FGElement::getByClassName('FGBuilding', $buildingClassName);
            }
            if (is_null($building)) throw new Exception();
            
            $buildingsMaxConsumption += ($building->getPowerConsumptionPM()) * ceil($amount);
            
            
            
            echo '<li>x'.ceil($amount).' ('.($amount != 0 ? round(($amount/ceil($amount))*100,2) : 'na').'%)'.' ', View::echoFGElement($building),'(',View::echoFGElement($recipe),')</li>';
        }
        echo '</ul>';
        
        echo '<h2>Consommation : ', $buildingsMaxConsumption, ' MW</h2>';
        
        
        echo '</fieldset>';
    }
    
    
    
    
    //////////////////////////////////////////////////////////////////////
    // Outils internes
}

