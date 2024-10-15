<?php
namespace FactoryGame;

use Exception;

class FGBuilding extends FGElement
{
    
    public float $mPowerConsumption; // ex: "15.000000"
    
    // Variable Manufacturer
    private float $mEstimatedMininumPowerConsumption = 0; // ex: 250.000000"
    private float $mEstimatedMaximumPowerConsumption = 0; // ex: 1500.000000"
    
    // Extractor
    public int $mItemsPerCycle = 0; // ex: "1"
    public float $mExtractCycleTime = 1; // ex: "1.000000"
    public array $mAllowedResourceForms = array(); // array(string) "(RF_SOLID)" ou "(RF_LIQUID)" ou "(RF_LIQUID,RF_GAS)"
    public bool $mOnlyAllowCertainResources = false; // bool "True" ou "False"
    public array $mAllowedResources = array(); // array(string) ex: "(/Script/Engine.BlueprintGeneratedClass'\"/Game/FactoryGame/Resource/RawResources/CrudeOil/Desc_LiquidOil.Desc_LiquidOil_C\"',/Script/Engine.BlueprintGeneratedClass'\"/Game/FactoryGame/Resource/RawResources/NitrogenGas/Desc_NitrogenGas.Desc_NitrogenGas_C\"',/Script/Engine.BlueprintGeneratedClass'\"/Game/FactoryGame/Resource/RawResources/Water/Desc_Water.Desc_Water_C\"')",
    
    // Constant & Variable Generator
    public float $mPowerProduction = 0; // ex: "75.000000"
    
    // Constant Generator
    public int $mFuelLoadAmount = 0; // ex: "1"
    public bool $mRequiresSupplementalResource = false; // ex: "True"
    public int $mSupplementalLoadAmount = 0; // ex: "1000"
    public float $mSupplementalToPowerRatio = 0; // ex: "1.600000"
    public string $mFuelResourceForm = 'RF_INVALID'; // ex: "RF_SOLID"
    public array $mFuel = array(); // 
    
    // Variable Generator
    private float $mVariablePowerProductionFactor = 0; // ex: "200.000000"
    
    
    
    function __toString2(int $format=0) {
        $str = parent::__toString2($format);
        switch($format) {
        case FGElement::TS_ENC_SPAN:
            $str .= '<br><br>';
            if ($this->isItemExtractor()) $str .= htmlspecialchars(' ItemExtractionPM('.$this->getItemExtractionPM().')');
            if ($this->isPowerGenerator()) {
                $str .= htmlspecialchars(' PowerGenerationPM('.-$this->getPowerConsumptionPM().')');
            } else {
                $str .= htmlspecialchars(' PowerConsumptionPM('.$this->getPowerConsumptionPM().')');
            }
            break;
        case FGElement::TS_ENC_SPAN_TITLE:
            $str .= '&#10;&#10;';
            if ($this->isItemExtractor()) $str .= htmlspecialchars(' ItemExtractionPM('.$this->getItemExtractionPM().')');
            if ($this->isPowerGenerator()) {
                $str .= htmlspecialchars(' PowerGenerationPM('.-$this->getPowerConsumptionPM().')');
            } else {
                $str .= htmlspecialchars(' PowerConsumptionPM('.$this->getPowerConsumptionPM().')');
            }
            break;
        default:
            $str .= ' : ';
            if ($this->isItemExtractor()) $str .= ' ItemExtractionPM('.$this->getItemExtractionPM().')';
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
                        $varvalue_AsArray = array_map(function($val) {return FGElement::convBPCNtoClassName($val);}, $varvalue_AsArray);
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
    
    public function isItemExtractor(): bool {
        return !empty($this->mItemsPerCycle);
    }
    
    /**
     * Dans le cas d'un filon de qualite Normal
     * @param float $modif 0.5:impure, 1:normal, 2:Pure
     * @return float
     */
    public function getItemExtractionPM(float $modif=1): float {
        return $this->isItemExtractor() ? $modif * $this->mItemsPerCycle*60/$this->mExtractCycleTime : 0;
    }
    
    public function isPowerGenerator(): bool {
        return $this->getPowerConsumptionPM() < 0;
    }
    
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

