<?php
namespace FactoryGame;

use Exception;

abstract class Pattern {
    const VERBOSE = false;
    private static ?array $ingredients = null;
    
    public static function getProductors(): array {
        if (!isset(self::$ingredients)) self::initialize();
        return self::$ingredients;
    }
    
    
    public static function initialize(?array $allRecipe = null) {
        if (!isset($allRecipe)) $allRecipe = FGElement::getAll('FGRecipe');
        $allItem = FGElement::getAll('FGItem');
        
        // Obtenir le multiplicateur de base a appliquer a la quantite de chacunes des ressources.
        $allItemAmountRatio_base = self::getAllItemAmountRatio_base($allItem);
        
        // Obtenir la liste des ressources naturelles
        $worldRessources = self::getWorldRessources($allItem, true, true);
        $wasteProduction = self::getWasteProduction($allItem);
        
        // Obtenir le multiplicateur de base a appliquer a la valeur de chacunes des ressources.
        $allItemValue_base = self::getAllWorldRessourceValue_base($worldRessources);
        
        // Lister les ingredients mis a la disposition de l'usine en quantite illimite
        $ingredients = array();
        foreach(array_keys($worldRessources) as $itemClassName) {
            $ingredients[$itemClassName] = array('-' => $allItemValue_base[$itemClassName]);
        }
        
        $prevRecipeCount = 0;
        while ((($recipeCount = count($allRecipe)) != 0) && ($prevRecipeCount != $recipeCount)) {
            $prevRecipeCount = $recipeCount;
            self::try($ingredients, $allRecipe, $wasteProduction, $allItemAmountRatio_base);
        }
        
        
        
        self::$ingredients = $ingredients;
        
        
        // Affichage
        if (self::VERBOSE) {
            echo '<pre>';
            echo  htmlspecialchars(var_export($ingredients, true));
            echo '<h1>Remain recipes: ',count($allRecipe),'</h1>';
            
            if ($recipeCount > 0) {
                // Affichage
                foreach($allRecipe as $recipe) {
                    View::echoFGElement($recipe); echo "\n";
                }
            }
            echo '</pre>';
        }
        
    }
    
    static function try(array &$ingredients, array &$allRecipe, array &$wasteProduction, array $allItemAmountRatio_base) {
        
        // Lister les recettes qui peuvent etre mises en production avec les ingredients a disposition (ressources naturelles)
        $recipes = self::searchRecipesByIngredients($ingredients, $allRecipe, true);
        
        if (empty($recipes)) return;
        
        // Retirer les recettes utilisees de la liste des recettes utilisables
        foreach($recipes as $recipeClassName => $recipe) {
            unset($allRecipe[$recipeClassName]);
        }
        
        // Affichage
        if (self::VERBOSE) {
            echo '<h1>',count($recipes),' recipes</h1>';
            echo '<ul>';
            foreach($recipes as $recipe) {
                echo '<li>';
                View::echoFGElement($recipe);
                echo '</li>';
            }
            echo '</ul>';
        }
        
        foreach($recipes as $recipeClassName => $recipe) {
            
            $ingrCost = 0;
            foreach($recipe->mIngredients as $ingrClassName => $amount) {
                $ingrAmount = $amount * $allItemAmountRatio_base[$ingrClassName];
                $ingrCost += $ingrAmount * $ingredients[$ingrClassName]['-'];
            }
            
            $prodAmount = 0;
            foreach($recipe->mProduct as $prodClassName => $amount) {
                $prodAmount += $amount * $allItemAmountRatio_base[$prodClassName];
            }
            
            foreach($recipe->mProduct as $prodClassName => $amount) {
                $prodAmount = $amount * $allItemAmountRatio_base[$prodClassName];
                $prodValue = $ingrCost / $prodAmount;
                
                if (!isset($ingredients[$prodClassName])) $ingredients[$prodClassName] = array();
                
                if (!array_key_exists('-', $ingredients[$prodClassName]) || $ingredients[$prodClassName]['-'] > $prodValue) {
                    $ingredients[$prodClassName]['-'] = $prodValue;
                }
                
                $ingredients[$prodClassName][$recipe->getClassName()] = $prodValue;
                
                if (array_key_exists($prodClassName, $wasteProduction)) {
                    foreach ($wasteProduction[$prodClassName] as $wasteClassName => $amount) {
                        $wasteAmount = $amount * $allItemAmountRatio_base[$wasteClassName];
                        $wasteValue = $prodValue / $wasteAmount;
                        
                        if (!isset($ingredients[$wasteClassName])) $ingredients[$wasteClassName] = array();
                        
                        if (!array_key_exists('-', $ingredients[$wasteClassName]) || $ingredients[$wasteClassName]['-'] > $wasteValue) {
                            $ingredients[$wasteClassName]['-'] = $wasteValue;
                        }
                    }
                }
            }
        }
    }
    
    
    static function &getAllItemAmountRatio_base(array &$items): array {
        $res = array();
        foreach($items as $itemClassName => $item) {
            if ($item->isPipelinable()) {
                $rate = 0.001;
            } else {
                $rate = 1;
            }
            $res[$itemClassName] = $rate;
        }
        return $res;
    }
    
    static function &getAllWorldRessourceValue_base(array &$items): array {
        
        $res = array();
        foreach($items as $itemClassName => $item) {
            if ($item->isPickUpRessource()) {
                $rate = 10000;
            } else if ($item->isRawRessource()) {
                $rate = 1;
            } else {
                // Il s'agit probablement d'un objet manufacture
                throw new Exception($itemClassName);
            }
            $res[$itemClassName] = $rate;
        }
        return $res;
    }
    
    static function &getWasteProduction(array &$items): array {
        $res = array();
        foreach($items as $itemClassName => $item) {
            if ($item->wasteProduction() > 0) {
                $wasteClassName = $item->getWasteClassName();
                $res[$itemClassName] = array($wasteClassName => $item->wasteProduction());
            }
        }
        return $res;
    }
    
    
    static function &getWorldRessources(array &$items, bool $appendRaw, bool $appendPickUp): array {
        $res = array();
        foreach($items as $itemClassName => $item) {
            if (($appendRaw && $item->isRawRessource()) || ($appendPickUp && $item->isPickUpRessource())) {
                $res[$itemClassName] = $item;
            }
        }
        return $res;
    }
    
    /**
     * Obtenir la liste des produits des recettes fournies.
     * @return array
     * <pre>
     * array(
     *     string ItemClassName => array(
     *         string RecipeClassName => float ProductionPM
     *     )
     * )</pre>
     */
    static function &getProductionByProduct(array &$recipes): array {
        $res = array();
        foreach($recipes as $recipeClassName => $recipe) {
            foreach(array_keys($recipe->mProduct) as $itemClassName) {
                if (!isset($res[$itemClassName])) $res[$itemClassName] = array();
                $res[$itemClassName][$recipeClassName] = round($recipe->getProductPM($itemClassName), 6);
            }
        }
        return $res;
    }
    
    /**
     * Obtenir la liste des ingredients des recettes fournies.
     * @return array
     * <pre>
     * array(
     *     string ItemClassName => array(
     *         string RecipeClassName => float ConsumePM
     *     )
     * )</pre>
     */
    static function &getConsumeByIngredient(array &$recipes): array {
        $res = array();
        foreach($recipes as $recipeClassName => $recipe) {
            foreach(array_keys($recipe->mIngredients) as $itemClassName) {
                if (!isset($res[$itemClassName])) $res[$itemClassName] = array();
                $res[$itemClassName][$recipeClassName] = round($recipe->getIngredientPM($itemClassName), 6);
            }
        }
        return $res;
    }
    
    ////////////////////////////////////////////////////////////////////////////////
    ///// Outils de recherche
    
    /**
     * Obtenir la liste des recettes qui peuvent etre utilisees avec les ingredients fournis.
     * @param array $ingredients array(string ClassName => ?)
     * @param array $allowedRecipes array(string ClassName => FGRecipe)
     * @param bool $allowAlernates
     * @return array array(string ClassName => FGRecipe)
     */
    static function searchRecipesByIngredients(array &$ingredients, array &$allowedRecipes, bool $allowAlernates = false): array {
        $recipes = array();
        
        foreach($allowedRecipes as $recipeClassName => $recipe) {
            if ($recipe->isPassThrough() || (!$allowAlernates && $recipe->isAlternate())) continue;
            $ableto = true;
            foreach(array_keys($recipe->mIngredients) as $ingrClassName) {
                if (!array_key_exists($ingrClassName, $ingredients)) $ableto = false;
                if (!$ableto) break;
            }
            if ($ableto) {
                $recipes[$recipeClassName] = $recipe;
                unset($allowedRecipes[$recipeClassName]);
            }
        }
        
        return $recipes;
    }
    
    /**
     * Obtenir la recette qui produit le plus d'exemplaires de l'objet demandé, par minute.
     * @param array $allowedRecipes array(? => FGRecipe)
     * @param string $itemClassName
     * @param bool $allowAlernates
     * @return FGRecipe|NULL
     */
    static function searchBestRecipeByProduct(array &$allowedRecipes, string $itemClassName, bool $allowAlernates = false): ?FGRecipe {
        
        $products = self::getProductors();
        if (empty($products[$itemClassName])) return null;
        $item = FGElement::getByClassName('FGItem', $itemClassName);
        if ($item->isPickUpRessource() || $item->isRawRessource()) return null;
        
        $theBest = null;
        $score = PHP_INT_MAX;
        
        foreach($products[$itemClassName] as $className => $value) {
            if (isset($allowedRecipes[$className]) && ($value<$score)) {
                $candidat = $allowedRecipes[$className];
                if (!$allowAlernates && $candidat->isAlternate()) continue;
                $theBest = $candidat;
                $score = $value;
            }
        }
        
        return $theBest;
    }
    
    /**
     * Obtenir la liste des recettes qui produisent l'objet demandé
     * @param array $allowedRecipes array(? => FGRecipe)
     * @param string $itemClassName
     * @param bool $allowAlernates
     * @param bool $addIfFaster
     * @return array array(string ClassName => FGRecipe)
     */
    static function searchRecipesByProduct(array &$allowedRecipes, string $itemClassName, bool $allowAlernates = false, bool $addIfFaster = false): array {
        $res = array();
        $pmMax = 0;
        foreach ($allowedRecipes as $recipe) {
            $pm = $recipe->getProductPM($itemClassName);
            if ($pm>0 && !$recipe->isPassThrough() && ($allowAlernates || !$recipe->isAlternate())) {
                if (!$addIfFaster || $pm>$pmMax) {
                    $pmMax = $pm;
                    $res[$recipe->getClassName()] = $recipe;
                }
            }
        }
        return $res;
    }
}

