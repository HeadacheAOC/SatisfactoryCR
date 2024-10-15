<?php
namespace FactoryGame;

use Exception;

class FGRecipe extends FGElement
{
    public string $FullName = '';
    public array $mIngredients = array();
    public array $mProduct = array();
    private float $mManufactoringDuration = 0;
    public array $mProducedIn = array();
    
    function __toString2(int $format=0) {
        $str = parent::__toString2($format);
        
        $items = FGElement::getAll('FGItem');
        $buildings = FGElement::getAll('FGBuilding');
        
        switch($format) {
        case FGElement::TS_ENC_SPAN:
            break;
            
        // Alternative
        case FGElement::TS_ENC_SPAN_TITLE:
            
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
        case FGElement::TS_ENC_SPAN_TITLE:

            // "Non-fissile Uranium&#10;PRODUCEIN - Blender&#10;CYCLE - 24s (2.5pm)&#10;&#10;OUTPUT - 20 Non-fissile Uranium (50pm)&#10;OUTPUT - 6000 Water (15000pm)&#10;&#10;INTPUT - 15 Uranium Waste (37.5pm)&#10;INTPUT - 10 Silica (25pm)&#10;INTPUT - 6000 Nitric Acid (15000pm)&#10;INTPUT - 6000 Sulfuric Acid (15000pm)"
            
            // ProduceIn
            $lst = array();
            foreach ($this->mProducedIn as $className) {
                $lst[] = $buildings[$className]->mDisplayName;
            }
            $str .= '&#10;PRODUCEIN - '.htmlspecialchars(implode(', ', $lst));
            
            // Cycle
            $str .= '&#10;CYCLE - '.htmlspecialchars($this->mManufactoringDuration .'s ('.$this->getCyclesPM().'pm)');
            
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
            
            $str .= ' <= '.$this->mManufactoringDuration .'s ('.$this->getCyclesPM().'pm) <= ';
            
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
                        $classNames[$k] = FGElement::convBPCNtoClassName($bpClassName);
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
                        $classNames[$k] = FGElement::convBPCNtoClassName($bpClassName);
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
                        $classNames[] = FGElement::convBPCNtoClassName($bpClassName);
                    }
                    $recipe->mProducedIn = $classNames;
                    break;
            }
        }
        
        return $recipe;
    }
    
    /**
     * Generer les recettes induites par le batiment.
     * Concerne principalement les batiments de type generateur ou extracteur.
     * @param FGBuilding $building
     * @param array $items
     * @throws Exception
     * @return array
     */
    static function parseFromBuilding(FGBuilding $building, array &$items): array {
        /* @var $item FGItem */
        /* @var $ingredient FGItem */
        /* @var $waste FGItem */
        /* @var $product FGItem */
        
        $recipes = array();
        $NativeClass = "/Script/CoreUObject.Class'/Script/FactoryGame.FGRecipe'";
        
        if ($building->isItemExtractor()) {
            
            // Lister les ressources extractables par ce bâtiment
            $products = array();
            if ($building->mOnlyAllowCertainResources) {
                $products = array();
                foreach($building->mAllowedResources as $productClassName) {
                    $products[] = $items[$productClassName];
                }
            } else {
                foreach($items as $item) {
                    if (!$item->isRawRessource()) continue;
                    if (!in_array($item->getForm(), $building->mAllowedResourceForms)) continue;
                    $products[] = $item;
                }
            }
            
            // Créer une recette pour chaque ressources
            foreach($products as $product) {
                
                $purityBonus = 1; // array('Impure'=>0.5, ''=>1, 'Pure'=>2)
                $recipe = self::parse($NativeClass, (object) array());
                
                // Bâtiment
                $recipe->mProducedIn = array($building->getClassName());
                
                // Cycle
                $recipe->mManufactoringDuration = $building->mExtractCycleTime;
                
                // Consommation
                $recipe->mIngredients = array();
                
                // Production
                $recipe->mProduct[$product->getClassName()] = $building->mItemsPerCycle*$purityBonus;
                
                // Description
                self::setPseudoIdentity($recipe, $building, $items);
                
                $recipes[] = $recipe;
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
                        foreach($items as $item) {
                            if (false!==strpos($item->getNativeClass(), $mFuelClass)) {
                                if ($building->mFuelResourceForm != $item->getForm()) continue;
                                if (empty($item->getFuelEnergy())) continue;
                                $lstIngredientFuel[] = $item;
                            }
                        }
                    } else {
                        // Cas où un unique ingrédient est désigné
                        $lstIngredientFuel[] = $items[$fuel['mFuelClass']];
                    }
                    
                    // Créer une recette pour chaque carburant
                    foreach($lstIngredientFuel as $ingredient) {
                        $recipe = self::parse($NativeClass, (object) array());
                        
                        // Bâtiment
                        $recipe->mProducedIn = array($building->getClassName());
                        
                        // Cycle
                        $recipe->mManufactoringDuration = ($building->mFuelLoadAmount * $ingredient->getFuelEnergy()) / $building->mPowerProduction;
                        
                        // Consommation
                        $recipe->mIngredients = array();
                        $recipe->mIngredients[$ingredient->getClassName()] = $building->mFuelLoadAmount;
                        if ($building->mRequiresSupplementalResource) {
                            $ingredientSupplemental = $items[$fuel['mSupplementalResourceClass']];
                            $recipe->mIngredients[$ingredientSupplemental->getClassName()] = $building->mSupplementalToPowerRatio * $ingredient->getFuelEnergy();
                        }
                        
                        // Production
                        if ($ingredient->wasteProduction()>0) {
                            $recipe->mProduct[$ingredient->getWasteClassName()] = $building->mFuelLoadAmount * $ingredient->wasteProduction();
                            $waste = $items[$ingredient->getWasteClassName()];
                            //$DisplayName = $waste->getDisplayName(); // "Plutonium Waste"
                        }
                        
                        // Description
                        self::setPseudoIdentity($recipe, $building, $items);
                        
                        $recipes[] = $recipe;
                    }
                }
            }
        }
        return $recipes;
    }
    
    private static function setPseudoIdentity(FGRecipe $recipe, FGBuilding $building, array &$items) {
        $buildingType = null;
        $primaryItem = null;
        $DisplayNameSuffixe = null;
        if ($building->isItemExtractor()) {
            $buildingType = 'Extractor';
            $primaryItem = $items[array_key_first($recipe->mProduct)];
            $primaryItemPM = $recipe->getProductPM($primaryItem->getClassName());
            $primaryItemAmount = $recipe->mProduct[$primaryItem->getClassName()];
            $DisplayNamePrefix = $building->getDisplayName();
            $DisplayNameSuffixe = $primaryItemPM;
        } elseif ($building->isPowerGenerator()) {
            $buildingType = 'Generator';
            $primaryItem = $items[array_key_first($recipe->mIngredients)];
            $primaryItemPM = $recipe->getIngredientPM($primaryItem->getClassName());
            $primaryItemAmount = $recipe->mIngredients[$primaryItem->getClassName()];
            $DisplayNamePrefix = null;
            $DisplayNameSuffixe = "Power";
        } else {
            $buildingType = $building->getShortClassName();
            $primaryItem = $items[array_key_first($recipe->mProduct)];
            $primaryItemPM = $recipe->getProductPM($primaryItem->getClassName());
            $primaryItemAmount = $recipe->mProduct[$primaryItem->getClassName()];
            $DisplayNamePrefix = $building->getDisplayName();
            $DisplayNameSuffixe = $primaryItemPM;
        }
        
         // "Plutonium Fuel Rod Power"
        if (empty($recipe->mDisplayName)) $recipe->mDisplayName = (!empty($DisplayNamePrefix) ? "{$DisplayNamePrefix}: " : '') . $primaryItem->getDisplayName() . (!empty($DisplayNameSuffixe) ? " {$DisplayNameSuffixe}" : '');
        
        // "ClassName": "Recipe_SteelBeam_C",
        // "ClassName": "Recipe_Caterium_Copper_C",
        // "ClassName": "Recipe_SAMFluctuator_C",
        if (empty($recipe->ClassName)) $recipe->ClassName = "Recipe_{$building->getShortClassName()}_{$DisplayNameSuffixe}_{$primaryItem->getName()}";
        
        // "FullName": "BlueprintGeneratedClass /Game/FactoryGame/Recipes/Constructor/Recipe_SteelBeam.Recipe_SteelBeam_C",
        // "FullName": "BlueprintGeneratedClass /Game/FactoryGame/Recipes/Converter/ResourceConversion/Recipe_Caterium_Copper.Recipe_Caterium_Copper_C",
        // "FullName": "BlueprintGeneratedClass /Game/FactoryGame/Recipes/Assembler/Recipe_SAMFluctuator.Recipe_SAMFluctuator_C",
        if (empty($recipe->FullName)) $recipe->FullName = "BlueprintGeneratedClass /Game/FactoryGame/Recipes/{$buildingType}/{$recipe->ClassName}";
        
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
     * Obtenir le nombre de Tick de production par minute
     */
    function getCyclesPM(): float {
        return 60/$this->mManufactoringDuration;
    }
    
    /**
     * Obtenir le nombre d'exemplaire produit par minute
     */
    function getProductPM(string $itemClassName): float {
        $amount = $this->mProduct[$itemClassName] ?? 0;
        return $amount * $this->getCyclesPM();
    }
    
    /**
     * Obtenir le nombre d'exemplaire consomme par minute
     */
    function getIngredientPM(string $itemClassName): float {
        $amount = $this->mIngredients[$itemClassName] ?? 0;
        return $amount * $this->getCyclesPM();
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
    
}

