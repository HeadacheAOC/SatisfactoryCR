<?php
namespace FactoryGame;

class FGSchematic extends FGElement
{
    private string $mType;
    private array $mUnlocks;
    
    function __toString2(int $format=0) {
        $str = parent::__toString2($format);
        
        $ext = ' (';
        $ext .= var_export($this->mUnlocks, true);
        $ext .= ')';
        
        switch($format) {
        case FGElement::TS_ENC_SPAN:
            break;
        case FGElement::TS_ENC_SPAN_TITLE:
            $str .= htmlspecialchars($ext);
            break;
        default:
            $str .= $ext;
        }
        
        return $str;
    }
    
    static function parse(string $NativeClass, object $schematicDesc): FGSchematic {
        
        $schematic = new FGSchematic($NativeClass, $schematicDesc);
        
        foreach($schematicDesc as $varname => $varvalue) {
            switch ($varname) {
                
                case "ClassName": // ex: "Schematic_Alternate_PureAluminumIngot_C"
                    $schematic->ClassName = $varvalue;
                    break;
                case "mDisplayName": // ex: "Alternate: Pure Aluminum Ingot"
                    $schematic->mDisplayName = $varvalue;
                    break;
                    
                case "mType": // ex: "EST_Alternate"
                    $schematic->mType = $varvalue;
                    break;
                case "mUnlocks": // ex: "[{"Class":"BP_UnlockRecipe_C","mRecipes":"(BlueprintGeneratedClass'\"/Game/FactoryGame/Recipes/AlternateRecipes/New_Update3/Recipe_PureAluminumIngot.Recipe_PureAluminumIngot_C\"')"}]"
                    $schematic->mUnlocks = $varvalue;
                    break;
            }
        }
        
        return $schematic;
    }
    
    function unlocksRecipe(): bool {
        $res = false;
        foreach($this->mUnlocks as $unlock) {
            if ('BP_UnlockRecipe_C' == $unlock->Class) $res = true;
            if ($res) break;
        }
        return $res;
    }
    
    function isAlternate(): bool {
        return 'EST_Alternate' == $this->mType;
    }
    
}

