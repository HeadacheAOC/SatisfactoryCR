<?php
namespace FactoryGame;

use Exception;

abstract class SToryJsonDocs {
    
    /**
     * Obtenir l'adresse du fichier
     * @param string $dir repertoire ou se situe, notamment, le fichier Docs.json
     * <br> ex: 'C:\SteamLibrary\steamapps\common\Satisfactory\CommunityResources\Docs'
     * @param string $name Nom du fichier, sans son extension, contenant la description des elements du jeux.
     * <br>ex: 'Docs'
     * @return string
     */
    static function getJsonFilePath(string $dir, string $name): string {
        return "{$dir}\\CommunityResources\\Docs\\{$name}.json";
    }
    
    /**
     * Obtenir le contenu du fichier Docs.json
     * @return string
     */
    static function getJsonFileContent(string $dir, string $name): string {
        // Anomalie: le fichier Docs.json est encode en UTF-16 au lieu de l'UTF-8 standard pour du json.
        return mb_convert_encoding(file_get_contents(self::getJsonFilePath($dir, $name)), "UTF-8", "UTF-16");
    }
    
    /**
     * Obtenir le contenu du fichier Docs.json
     * @return array
     */
    static function getDecodedJsonFile(string $dir, string $name): array {
        return json_decode(self::getJsonFileContent($dir, $name));
    }
    
    /**
     * Collecter les donnees du fichier Docs.json
     * @throws Exception
     */
    static function parseJsonFile(string $dir, string $name) {
        $excludes_ProductIn = array(
            'BP_BuildGun_C' // Outil de base du jeux tenu en main
            , 'FGBuildGun' // Outil de base du jeux tenu en main
            , 'BP_WorkshopComponent_C' // Equipment Workshop, Build_Workshop_C
            , 'BP_WorkBenchComponent_C' // Craft Bench, Build_WorkBench_C
            , 'FGBuildableAutomatedWorkBench' // Craft Bench, Build_WorkBench_C
            , 'Build_AutomatedWorkBench_C' // Craft Bench, Build_WorkBench_C
        );
        
        $docs = self::getDecodedJsonFile($dir, $name);
        
        $recipes = array(); // Liste des recettes
        $items = array(); // Liste des objets
        $buildings = array(); // Manufacturer
        $schematics = array(); // Schémas
        
        // Extraire les elements utiles du fichier
        foreach($docs as $doc) {
            
            //Assertions
            if (!is_object($doc)) throw new Exception();
            if (!isset($doc->NativeClass)) throw new Exception();
            if (!isset($doc->Classes)) throw new Exception();
            
            $outAll = false;
            $outNativeClass = false;
            $outClasses_Count = false;
            $outClassname_Count = false;
            
            // 2024/05/04 Exemple - "NativeClass":"/Script/CoreUObject.Class'/Script/FactoryGame.FGItemDescriptor'"
            $elementNativeClass = $doc->NativeClass;
            
            switch ($elementNativeClass) {
                
                /* Les recettes */
                
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGRecipe'":
                    foreach($doc->Classes as $recipeDesc) {
                        $recipe = FGRecipe::parse($elementNativeClass, $recipeDesc);
                        
                        // Ignorer les recettes qui produisent exactement ce qui entre.
                        if ($recipe->isPassThrough()) continue;
                        
                        // Supprimer les constructeurs ne pouvant pas faire partie d'une chaine de production.
                        foreach ($excludes_ProductIn as $className) {
                            if (false !== ($k = array_search($className, $recipe->mProducedIn))) {
                                unset($recipe->mProducedIn[$k]);
                            }
                        }
                        
                        // Ignorer les recettes sans moyen de production
                        if (empty($recipe->mProducedIn)) continue;
                        if (array_key_exists($recipe->getClassName(), $recipes)) throw new Exception();
                        $recipes[$recipe->getClassName()] = $recipe;
                    }
                    break;
                
                
                /* Les Objets de type ingredients/produits */
                    
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGItemDescriptor'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGResourceDescriptor'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGItemDescriptorBiomass'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGConsumableDescriptor'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGItemDescriptorNuclearFuel'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGItemDescAmmoTypeProjectile'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGItemDescAmmoTypeColorCartridge'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGEquipmentDescriptor'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGItemDescAmmoTypeInstantHit'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGAmmoTypeProjectile'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGAmmoTypeInstantHit'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGAmmoTypeSpreadshot'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGPowerShardDescriptor'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGItemDescriptorPowerBoosterFuel'":
                    foreach($doc->Classes as $itemDesc) {
                        $item = FGItem::parse($elementNativeClass, $itemDesc);
                        if (array_key_exists($item->getClassName(), $items)) throw new Exception();
                        $items[$item->getClassName()] = $item;
                    }
                    break;
                    
                
                /* Les batiments : Extracteurs de ressources naturelles + Recettes (implicite) */
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableResourceExtractor'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableWaterPump'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableFrackingExtractor'":
                    
                /* Les batiments : Fabriques */
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableManufacturer'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableManufacturerVariablePower'":
                    
                /* Les batiments : Generateurs + Recettes (implicite) */
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableGeneratorFuel'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableGeneratorNuclear'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableGeneratorGeoThermal'":
                    foreach($doc->Classes as $buildingDesc) {
                        $building = FGBuilding::parse($elementNativeClass, $buildingDesc);
                        if (array_key_exists($building->getClassName(), $buildings)) throw new Exception();
                        $buildings[$building->getClassName()] = $building;
                    }
                    break;
                    
                    
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGSchematic'":
                    foreach($doc->Classes as $schematicDesc) {
                        $schematic = FGSchematic::parse($elementNativeClass, $schematicDesc);
                        
                        // Ignorer les recettes inutiles
                        if (!$schematic->unlocksRecipe() || !$schematic->isAlternate()) continue;
                        
                        if (array_key_exists($schematic->getClassName(), $schematics)) throw new Exception();
                        $schematics[$schematic->getClassName()] = $schematic;
                    }
                    break;
                    
                    
                // Elements ignores...
                    
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildingDescriptor'":
                    
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildablePole'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableConveyorBelt'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableWire'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildablePowerPole'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableTradingPost'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableSpaceElevator'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableStorage'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildable'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableWall'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableStair'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableConveyorLift'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildablePipelineSupport'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildablePipeline'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildablePipelineJunction'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildablePipelinePump'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildablePipeReservoir'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableFoundation'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableFactory'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableAttachmentMerger'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableAttachmentSplitter'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableResourceSink'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableResourceSinkShop'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableDockingStation'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildablePipeHyper'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableTrainPlatformCargo'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableTrainPlatformEmpty'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableRailroadStation'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableRailroadTrack'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableSplitterSmart'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableWalkway'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableDoor'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableCornerWall'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableMAM'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableBeam'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildablePillar'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableDroneStation'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableFrackingActivator'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableRamp'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableJumppad'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildablePowerStorage'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableRailroadSignal'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableCircuitSwitch'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableRadarTower'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableFactorySimpleProducer'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableSnowDispenser'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableFactoryBuilding'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableWidgetSign'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableLightSource'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableLadder'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableFloodlight'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableLightsControlPanel'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildablePassthrough'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableWallLightweight'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableBlueprintDesigner'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildablePoleLightweight'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableBeamLightweight'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildablePillarLightweight'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableWalkwayLightweight'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableFoundationLightweight'":
                    
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGConsumableEquipment'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGPoleDescriptor'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGChainsaw'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGGolfCartDispenser'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGSuitBase'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGJetPack'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGJumpingStilts'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGWeaponProjectileFire'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGWeaponInstantFire'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGEquipmentStunSpear'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGGasMask'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGPortableMinerDispenser'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGVehicleDescriptor'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGConsumableDescriptor'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGObjectScanner'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGConveyorPoleStackable'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGPipeHyperStart'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGColorGun'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGParachute'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGNobeliskDetonator'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGCustomizationRecipe'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGWeapon'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGHoverPack'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGEquipmentZipline'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGChargedWeapon'":
                    
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildablePriorityPowerSwitch'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildablePassthroughPipeHyper'":
                    
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildablePoleBase'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildablePortal'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildablePortalSatellite'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableRampLightweight'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildablePowerBooster'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGCentralStorageContainer'":
                case "/Script/CoreUObject.Class'/Script/FactoryGame.FGBuildableCornerWallLightweight'":
                    
                    // SKIP
                    break;
                    
                    
                default:
                    echo '<h1>Unknown NativeClass: ', $doc->NativeClass, '</h1>';
                    //throw new Exception('Unknown NativeClass: '. $doc->NativeClass);
                    break;
            }
            
            // DEBUG
            if ($outAll || $outNativeClass) echo '<h1>',$doc->NativeClass,'</h1>';
            if ($outAll || $outClasses_Count) echo '<h2>',count($doc->Classes),'</h2>';
            if ($outAll || $outClassname_Count) {
                $tmp_cnCnts = array();
                foreach($doc->Classes as $tmp_elements) {
                    foreach(array_keys(get_object_vars($tmp_elements)) as $tmp_ClassName) {
                        if (!array_key_exists($tmp_ClassName, $tmp_cnCnts)) $cnCnts[$tmp_ClassName] = 0;
                        $cnCnts[$tmp_ClassName]++;
                    }
                }
                var_dump($tmp_cnCnts);
            }
            
        }
        
        // FIX: Ajout des recettes induites par les batiments.
        
        
        // FIX: Ajout des recettes induites par les batiments.
        foreach($buildings as $building) {
            $buildingRecipes = FGRecipe::parseFromBuilding($building, $items);
            foreach($buildingRecipes as $buildingRecipe) {
                if (array_key_exists($buildingRecipe->getClassName(), $recipes)) throw new Exception($buildingRecipe->getClassName());
                $recipes[$buildingRecipe->getClassName()] = $buildingRecipe;
            }
        }
        
        // Assertions - Recettes
        $dblDNames = array(); // ClassName => DisplayName
        $dnames = array(); // DisplayName => ClassName
        FGRecipe::fixDblDNames($recipes);
        foreach($recipes as $recipeClassName => $recipe) {
            
            // Requis : S'assurer que les bâtiments de production sont connus
            foreach($recipe->mProducedIn as $ClassName) {
                if (!array_key_exists($ClassName, $buildings)) throw new Exception($ClassName);
            }
            
            // Postulat : Un seul bâtiments de production par recette
            if (count($recipe->mProducedIn) !== 1) throw new Exception($recipe);
            
            // Requis : S'assurer que les ingredients sont connus
            foreach(array_keys($recipe->mIngredients) as $ClassName) {
                if (!array_key_exists($ClassName, $items)) throw new Exception($ClassName);
            }
            
            // Requis : S'assurer que les produits sont connus
            foreach(array_keys($recipe->mProduct) as $ClassName) {
                if (!array_key_exists($ClassName, $items)) throw new Exception($ClassName);
            }
            
            // Lister les doublons de DisplayName
            $dname = $recipe->getDisplayName();
            if (isset($dnames[$dname])) {
                if (!in_array($dname, $dblDNames)) {
                    $dblDNames[$dnames[$dname]] = $dname;
                }
                $dblDNames[$recipe->getClassName()] = $dname;
            } else {
                $dnames[$dname] = $recipeClassName;
            }
        }
        // Requis : Chaque recette doit disposer d'un nom unique.
        if (!empty($dblDNames)) {
            ksort($dblDNames);
            asort($dblDNames);
            foreach($dblDNames as $ClassName => $dname) {
                echo "'{$ClassName}' => '{$dname}',\r\n";
            }
            throw new Exception("Duplicate DisplayName");
        }
        
        uasort($items, [SToryJsonDocs::class, 'assocSort']);
        uasort($recipes, [SToryJsonDocs::class, 'assocSort']);
        uasort($schematics, [SToryJsonDocs::class, 'assocSort']);
        uasort($buildings, [SToryJsonDocs::class, 'assocSort']);
        
        FGElement::setAll('FGItem', $items);
        FGElement::setAll('FGRecipe', $recipes);
        FGElement::setAll('FGSchematic', $schematics);
        FGElement::setAll('FGBuilding', $buildings);
        
    }
    
    static function assocSort(FGElement $a, FGElement $b): int {
        return strcmp($a->getDisplayName(), $b->getDisplayName());
    }
}

