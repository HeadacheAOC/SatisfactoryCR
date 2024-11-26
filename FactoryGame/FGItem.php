<?php
namespace FactoryGame;

use Exception;

class FGItem extends FGElement
{

	/**
	 * @var string Determine si l'objet est a l'etat liquide, solide ou gazeux.
	 * 2024/05/04 Valeurs - RF_SOLID, RF_LIQUID, RF_INVALID, RF_GAS, RF_HEAT
	 */
	private string $mForm = 'RF_INVALID';

	/**
	 * @var bool Informe le joueur si l'objet peut etre directement collecte en explorant l'univers.
	 * L'Iron Ore est collectable a la main contrairement au Water ;)
	 */
	private bool $mRememberPickUp = false;

	/**
	 * @var bool Determine si cet objet peut etre supprime.
	 * 2024/05/04 Ne peuvent pas etre supprimes - Uranium Waste, Plutonium Waste, Non-fissile Uranium, Plutonium Pellet, Encased Plutonium Cell, HUB Parts, Purple Power Slug, Yellow Power Slug, Blue Power Slug.
	 */
	private bool $mCanBeDiscarded = false;

	/**
	 * @var float Energie potentielle en KJ ou en J ?
	 * 2024/05/04 Valeurs - 1500000 (Plutonium Fuel Rod), 750000 (Uranium Fuel Rod)
	 */
	private float $mEnergyValue = 0;

	/**
	 * @var float Radioactivite de l'objet
	 * 2024/05/04 Valeurs - 0, 0.5, 0.75, 10, 15, 20, 50, 120, 200, 250
	 */
	private float $mRadioactiveDecay = 0;

	/**
	 * @var integer Nombre de dechets resultants de la consommation de cet objet.
	 * 2024/05/04 - La consommation d'une unite d'Uranium Fuel Rod produit consequemment 50 unites d'Uranium Waste.
	 */
	private int $mAmountOfWaste = 0;

	/**
	 * @var string|NULL ClassName du dechet resultant de la consommation de cet objet.
	 * 2024/05/04 - La consommation d'Uranium Fuel Rod (Desc_NuclearFuelRod_C) produit consequemment de l'Uranium Waste (Desc_NuclearWaste_C).
	 */
	private ?string $mSpentFuelClass = null;


	static function parse(string $NativeClass, object $itemDesc): FGItem {
		/*
		 * 2024/05/04
		 *
		 * Example for Non-fissile Uranium item
		 * $NativeClass <= "NativeClass":"/Script/CoreUObject.Class'/Script/FactoryGame.FGItemDescriptor'"
		 * $itemDesc <= {"ClassName":"Desc_NonFissibleUranium_C","mDisplayName":"Non-fissile Uranium","mDescription":"The isotope Uranium-238 is non-fissile, meaning it cannot be used for nuclear fission. It can, however, be converted into fissile Plutonium in the Particle Accelerator.\r\n\r\nCaution: Mildly Radioactive.","mAbbreviatedDisplayName":"","mStackSize":"SS_HUGE","mCanBeDiscarded":"False","mRememberPickUp":"False","mEnergyValue":"0.000000","mRadioactiveDecay":"0.750000","mForm":"RF_SOLID","mSmallIcon":"Texture2D /Game/FactoryGame/Resource/Parts/Non-FissibleUranium/UI/IconDesc_NonFissileUranium_256.IconDesc_NonFissileUranium_256","mPersistentBigIcon":"Texture2D /Game/FactoryGame/Resource/Parts/Non-FissibleUranium/UI/IconDesc_NonFissileUranium_256.IconDesc_NonFissileUranium_256","mCrosshairMaterial":"None","mDescriptorStatBars":"","mSubCategories":"","mMenuPriority":"0.000000","mFluidColor":"(B=0,G=0,R=0,A=0)","mGasColor":"(B=0,G=0,R=0,A=0)","mCompatibleItemDescriptors":"","mClassToScanFor":"None","mScannableType":"RTWOT_Default","mShouldOverrideScannerDisplayText":"False","mScannerDisplayText":"","mScannerLightColor":"(B=0,G=0,R=0,A=0)","mResourceSinkPoints":"0"}
		 *
		 * Example for Uranium Waste item
		 * $NativeClass <= "NativeClass":"/Script/CoreUObject.Class'/Script/FactoryGame.FGItemDescriptor'"
		 * $itemDesc <= {"ClassName":"Desc_NuclearWaste_C","mDisplayName":"Uranium Waste","mDescription":"The by-product of consuming Uranium Fuel Rods in the Nuclear Power Plant.\r\nNon-fissile Uranium can be extracted. Handle with caution.\r\n\r\nCaution: HIGHLY Radioactive.","mAbbreviatedDisplayName":"","mStackSize":"SS_HUGE","mCanBeDiscarded":"False","mRememberPickUp":"False","mEnergyValue":"0.000000","mRadioactiveDecay":"10.000000","mForm":"RF_SOLID","mSmallIcon":"Texture2D /Game/FactoryGame/Resource/Parts/NuclearWaste/UI/IconDesc_NuclearWaste_256.IconDesc_NuclearWaste_256","mPersistentBigIcon":"Texture2D /Game/FactoryGame/Resource/Parts/NuclearWaste/UI/IconDesc_NuclearWaste_256.IconDesc_NuclearWaste_256","mCrosshairMaterial":"None","mDescriptorStatBars":"","mSubCategories":"","mMenuPriority":"0.000000","mFluidColor":"(B=0,G=0,R=0,A=0)","mGasColor":"(B=0,G=0,R=0,A=0)","mCompatibleItemDescriptors":"","mClassToScanFor":"None","mScannableType":"RTWOT_Default","mShouldOverrideScannerDisplayText":"False","mScannerDisplayText":"","mScannerLightColor":"(B=0,G=0,R=0,A=0)","mResourceSinkPoints":"0"}
		 *
		 * Example for Uranium Fuel Rod item
		 * $NativeClass <= "/Script/CoreUObject.Class'/Script/FactoryGame.FGItemDescriptorNuclearFuel'"
		 * $itemDesc <= {"ClassName":"Desc_NuclearFuelRod_C","mSpentFuelClass":"/Script/Engine.BlueprintGeneratedClass'/Game/FactoryGame/Resource/Parts/NuclearWaste/Desc_NuclearWaste.Desc_NuclearWaste_C'","mAmountOfWaste":"50","mDisplayName":"Uranium Fuel Rod","mDescription":"Used as fuel for the Nuclear Power Plant.\r\n\r\nCaution: Produces radioactive Uranium Waste when consumed.\r\nCaution: Moderately Radioactive.","mAbbreviatedDisplayName":"","mStackSize":"SS_SMALL","mCanBeDiscarded":"True","mRememberPickUp":"False","mEnergyValue":"750000.000000","mRadioactiveDecay":"50.000000","mForm":"RF_SOLID","mSmallIcon":"Texture2D /Game/FactoryGame/Resource/Parts/NuclearFuelRod/UI/IconDesc_NuclearFuelRod_256.IconDesc_NuclearFuelRod_256","mPersistentBigIcon":"Texture2D /Game/FactoryGame/Resource/Parts/NuclearFuelRod/UI/IconDesc_NuclearFuelRod_256.IconDesc_NuclearFuelRod_256","mCrosshairMaterial":"None","mDescriptorStatBars":"","mSubCategories":"","mMenuPriority":"0.000000","mFluidColor":"(B=0,G=0,R=0,A=0)","mGasColor":"(B=0,G=0,R=0,A=0)","mCompatibleItemDescriptors":"","mClassToScanFor":"None","mScannableType":"RTWOT_Default","mShouldOverrideScannerDisplayText":"False","mScannerDisplayText":"","mScannerLightColor":"(B=0,G=0,R=0,A=0)","mResourceSinkPoints":"44092"}
		 *
		 * Example for Plutonium Fuel Rod
		 * $NativeClass <= "/Script/CoreUObject.Class'/Script/FactoryGame.FGItemDescriptorNuclearFuel'"
		 * $itemDesc <= {"ClassName":"Desc_PlutoniumFuelRod_C","mSpentFuelClass":"/Script/Engine.BlueprintGeneratedClass'/Game/FactoryGame/Resource/Parts/NuclearWaste/Desc_PlutoniumWaste.Desc_PlutoniumWaste_C'","mAmountOfWaste":"10","mDisplayName":"Plutonium Fuel Rod","mDescription":"Used as fuel for the Nuclear Power Plant.\r\n\r\nCaution: Produces radioactive Plutonium Waste when consumed.\r\nCaution: HIGHLY Radioactive.","mAbbreviatedDisplayName":"","mStackSize":"SS_SMALL","mCanBeDiscarded":"True","mRememberPickUp":"False","mEnergyValue":"1500000.000000","mRadioactiveDecay":"250.000000","mForm":"RF_SOLID","mSmallIcon":"Texture2D /Game/FactoryGame/Resource/Parts/PlutoniumFuelRods/UI/IconDesc_PlutoniumFuelRod_256.IconDesc_PlutoniumFuelRod_256","mPersistentBigIcon":"Texture2D /Game/FactoryGame/Resource/Parts/PlutoniumFuelRods/UI/IconDesc_PlutoniumFuelRod_256.IconDesc_PlutoniumFuelRod_256","mCrosshairMaterial":"None","mDescriptorStatBars":"","mSubCategories":"","mMenuPriority":"0.000000","mFluidColor":"(B=0,G=0,R=0,A=0)","mGasColor":"(B=0,G=0,R=0,A=0)","mCompatibleItemDescriptors":"","mClassToScanFor":"None","mScannableType":"RTWOT_Default","mShouldOverrideScannerDisplayText":"False","mScannerDisplayText":"","mScannerLightColor":"(B=0,G=0,R=0,A=0)","mResourceSinkPoints":"153184"}
		 *
		 * Example for Water
		 * $NativeClass <= "NativeClass":"/Script/CoreUObject.Class'/Script/FactoryGame.FGResourceDescriptor'"
		 * $itemDesc <= {"ClassName":"Desc_Water_C","mDecalSize":"200.000000","mPingColor":"(R=0.000000,G=0.000000,B=0.000000,A=0.000000)","mCollectSpeedMultiplier":"1.000000","mManualMiningAudioName":"Metal","mDisplayName":"Water","mDescription":"It's water.","mAbbreviatedDisplayName":"H₂O","mStackSize":"SS_FLUID","mCanBeDiscarded":"True","mRememberPickUp":"False","mEnergyValue":"0.000000","mRadioactiveDecay":"0.000000","mForm":"RF_LIQUID","mSmallIcon":"Texture2D /Game/FactoryGame/Resource/RawResources/Water/UI/LiquidWater_Pipe_512.LiquidWater_Pipe_512","mPersistentBigIcon":"Texture2D /Game/FactoryGame/Resource/RawResources/Water/UI/LiquidWater_Pipe_512.LiquidWater_Pipe_512","mCrosshairMaterial":"None","mDescriptorStatBars":"","mSubCategories":"","mMenuPriority":"0.000000","mFluidColor":"(B=212,G=176,R=122,A=255)","mGasColor":"(B=0,G=0,R=0,A=0)","mCompatibleItemDescriptors":"","mClassToScanFor":"None","mScannableType":"RTWOT_Default","mShouldOverrideScannerDisplayText":"False","mScannerDisplayText":"","mScannerLightColor":"(B=0,G=0,R=0,A=0)","mResourceSinkPoints":"5"}
		 */

		$item = new FGItem($NativeClass, $itemDesc);


		foreach($itemDesc as $varname => $varvalue) {
			switch ($varname) {
				case "ClassName":
					// 2024/05/04 - Example for Non-fissile Uranium item: "ClassName":"Desc_NonFissibleUranium_C"
					$item->ClassName = $varvalue;
					break;
				case "mDisplayName":
					// 2024/05/04 - Example for Non-fissile Uranium item: "mDisplayName":"Non-fissile Uranium"
					$item->mDisplayName = $varvalue;
					break;
				case "mDescription":
					// 2024/05/04 - Example for Non-fissile Uranium item: "mDescription":"The isotope Uranium-238 is non-fissile, meaning it cannot be used for nuclear fission. It can, however, be converted into fissile Plutonium in the Particle Accelerator.\r\n\r\nCaution: Mildly Radioactive."
					$item->mDescription = $varvalue;
					break;
				case "mRadioactiveDecay":
					// 2024/05/04 - Example for Uranium Waste item: "mRadioactiveDecay":"10.000000"
					$varvalue_AsFloat = $varvalue;
					if (!settype($varvalue_AsFloat, 'float')) throw new Exception();
					$item->mRadioactiveDecay = $varvalue_AsFloat;
					break;
				case "mForm":
					// 2024/05/04 - Example for Non-fissile Uranium item: "mForm":"RF_SOLID"
					$item->mForm = $varvalue;
					break;
				case "mRememberPickUp":
					// 2024/05/04 - Example for Non-fissile Uranium item: "mRememberPickUp":"False"
					if ($varvalue == "True") $varvalue_AsBool = true;
					else if ($varvalue == "False") $varvalue_AsBool = false;
					else throw new Exception();
					$item->mRememberPickUp = $varvalue_AsBool;
					break;
				case "mCanBeDiscarded":
					// 2024/05/04 - Example for Non-fissile Uranium item: "mCanBeDiscarded":"False"
					if ($varvalue == "True") $varvalue_AsBool = true;
					else if ($varvalue == "False") $varvalue_AsBool = false;
					else throw new Exception();
					$item->mCanBeDiscarded = $varvalue_AsBool;
					break;
				case "mEnergyValue":
					// 2024/05/04 - Example for Plutonium Fuel Rod item: "mEnergyValue":"1500000.000000"
					$varvalue_AsFloat = $varvalue;
					if (!settype($varvalue_AsFloat, 'float')) throw new Exception();
					$item->mEnergyValue = $varvalue_AsFloat;
					break;
				case "mAmountOfWaste":
					// 2024/05/04 - Example for Uranium Fuel Rod item: "mAmountOfWaste":"50"
					$varvalue_AsInt = $varvalue;
					if (!settype($varvalue_AsInt, 'int')) throw new Exception();
					$item->mAmountOfWaste = $varvalue_AsInt;
					break;
				case "mSpentFuelClass":
					// 2024/05/04 - Example for Uranium Fuel Rod item: "mSpentFuelClass":"/Script/Engine.BlueprintGeneratedClass'/Game/FactoryGame/Resource/Parts/NuclearWaste/Desc_NuclearWaste.Desc_NuclearWaste_C'"
					if ('None' === $varvalue) break; // FIX - 20241509
					$matches = array();
					if (0 == preg_match('/^(?P<Item>\/Script\/Engine\.BlueprintGeneratedClass\'(?P<BlueprintClassName>[^\']+)\')$/', $varvalue, $matches)) throw new Exception($varvalue);
					$varvalue_AsBPCN = $matches['BlueprintClassName'];
					$item->mSpentFuelClass = FGElement::extractClassNameFromBPCN($varvalue_AsBPCN);
					break;
			}
		}

		return $item;
	}



	/////////////////////////
	///// Affichage/Output
	/////

	function __toString2(int $format=0) {
		$str = parent::__toString2($format);
		switch($format) {
		case FGElement::TS_HTML_BLOCKTAG:
			if ($this->isFuel()) $str .= " <span>🗲 {$this->mEnergyValue} MJ</span>";
			if ($this->isRadioactive()) $str .= " <span>☢ {$this->mRadioactiveDecay}</span>";
			$str .= '<h2>Produced by</h2>';
			$recipes = Pattern::searchRecipesByProduct(FGElement::getCat('FGRecipe'), $this->ClassName, true);
			uasort($recipes, function ($compFGRecipe1, $compFGRecipe2) {return floor($compFGRecipe1->getProductPM($this->ClassName)*100)-floor($compFGRecipe2->getProductPM($this->ClassName)*100);});
			if (empty($recipes)) {
				$str .= '<i>none</i>';
			} else {
				$str .= '<ul>';
				foreach($recipes as $recipe) {
					$str .= '<li>'.$recipe->__toString2($format).'</li>';
				}
				$str .= '</ul>';
			}

			$str .= '<h2>Consumed by</h2>';
			$recipes = Pattern::searchRecipesByIngredient(FGElement::getCat('FGRecipe'), $this->ClassName, true);
			uasort($recipes, function ($compFGRecipe1, $compFGRecipe2) {return floor($compFGRecipe1->getIngredientPM($this->ClassName)*100)-floor($compFGRecipe2->getIngredientPM($this->ClassName)*100);});
			if (empty($recipes)) {
				$str .= '<i>none</i>';
			} else {
				$str .= '<ul>';
				foreach($recipes as $recipe) {
					$str .= '<li>'.$recipe->__toString2($format).'</li>';
				}
				$str .= '</ul>';
			}
			break;
		case FGElement::TS_HTML_INNERTAG:
			$str .= '<br>Recipes:';

			$recipes = Pattern::searchRecipesByProduct(FGElement::getCat('FGRecipe'), $this->ClassName, true);
			foreach($recipes as $recipe) {
				$str .= '<br> - '.$recipe->__toString2($format);
			}
			break;
		case FGElement::TS_HTML_TAGATTR_TITLE:
			$str .= '&#10;Recipes:';

			$recipes = Pattern::searchRecipesByProduct(FGElement::getCat('FGRecipe'), $this->ClassName, true);
			foreach($recipes as $recipe) {
				$str .= '&#10; - '.$recipe->__toString2($format);
			}
			break;
		default:
		}
		return $str;
	}



	/////////////////////////
	///// Consultation
	/////

	/**
	 * Est-ce une ressource naturelle dont l'extraction est industrialisable ?
	 * Ce qui est le cas du cuivre, du fer, du charbon, de l'eau, du petrole, de l'azote, ...
	 * @return bool
	 */
	function isRawRessource(): bool {
		return "/Script/CoreUObject.Class'/Script/FactoryGame.FGResourceDescriptor'" == $this->NativeClass;
	}

	/**
	 * Est-ce une ressource naturelle dont la collecte ne peut etre que manuelle ?
	 * Ce qui est le cas des artefacts ou du produit de la chasse/cueillette.
	 * @return bool
	 */
	function isPickUpRessource(): bool {
		return $this->mRememberPickUp && !$this->isRawRessource();
	}

	/**
	 * Determiner l'etat de l'objet (solide, liquide, gazeux, ...)
	 * @return string
	 */
	function getForm(): string {
		return $this->mForm;
	}

	/**
	 * Determiner l'objet dispose d'un potentiel energetique et pourait donc etre utilise en tant que carburant.
	 * @return bool
	 */
	function isFuel():bool {
		return $this->mEnergyValue > 0;
	}

	/**
	 * Obtenir le pouvoir energetique de l'objet.
	 * @return float
	 */
	function getFuelEnergy():float {
		return $this->mEnergyValue;
	}

	/**
	 * Est-ce canalisable ?
	 * Ce qui est le cas des ingredients/produits a l'etat solide, liquide ou gazeux.
	 * @return bool
	 */
	function isCanalizable(): bool {
		return 'RF_INVALID' !== $this->mForm;
	}

	/**
	 * Est-ce canalisable avec un pipeline ou un gazeoduc ?
	 * Ce qui est le cas des ingredients/produits a l'etat liquide ou gazeux.
	 * @return bool
	 */
	function isPipelinable(): bool {
		return ('RF_LIQUID' === $this->mForm) || ('RF_GAS' === $this->mForm);
	}

	/**
	 * Est-ce canalisable avec un tapis roulant ou un ascensseur ?
	 * Ce qui est le cas des ingredients/produits a l'etat solide.
	 * @return bool
	 */
	function isConveyable(): bool {
		return 'RF_SOLID' === $this->mForm;
	}

	/**
	 * Est-ce radioactif ?
	 * Ce qui est le cas de l'uranium et du plutonium.
	 * @return bool
	 */
	function isRadioactive(): bool {
		return 0 < $this->mRadioactiveDecay;
	}

	/**
	 * Quantite de dechets produits consequemment lors de la consommation de cet objet.
	 * @return int
	 */
	function wasteProduction(): int {
		return $this->mAmountOfWaste;
	}

	/**
	 * Obtenir le ClassName du dechet produit consequemment lors de la consommation de cet objet.
	 * @return string|NULL
	 */
	function getWasteClassName(): ?string {
		return $this->mSpentFuelClass;
	}
}