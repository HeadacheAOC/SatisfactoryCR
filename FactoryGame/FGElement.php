<?php
namespace FactoryGame;

use Exception;

abstract class FGElement
{
	/////////////////////////
	///// Constantes
	///// Identifiants des formats de sortie
	///// geres par la fonction __toString2().

	/**
	 * (CSV) Comma-Separated Values.
	 * @var integer
	 */
	public const TS_CSV = 0;

	/**
	 * (JSON) Encoder avec json_encode()
	 * @var int
	 */
	public const TS_JSON = 1;

	/**
	 * (HTML) A destination du contenu d'une balise HTML de type inline (ex: SPAN).
	 * @var int
	 */
	public const TS_HTML_INNERTAG = 2;

	/**
	 * (HTML) A destination de l'attribut TITLE d'une balise HTML.
	 * @var int
	 */
	public const TS_HTML_TAGATTR_TITLE = 3;

	/**
	 * (HTML) A destination du contenu d'une balise HTML de type block (ex DIV).
	 * @var int
	 */
	public const TS_HTML_BLOCKTAG = 4;



	/////////////////////////
	///// Definition de l'objet

	/**
	 * Source - Definition de l'objet. Provient du jeux Satisfactory.
	 * @var object
	 */
	private ?object $srcData;

	/**
	 * 2024/05/04 Exemple - /Script/CoreUObject.Class'/Script/FactoryGame.FGItemDescriptor'
	 * @var string
	 */
	protected string $NativeClass;

	/**
	 * 2024/05/04 Exemple - Desc_NuclearWaste_C
	 * @var string
	 */
	protected string $ClassName = '';

	/**
	 * 2024/05/04 Exemple - Uranium Waste
	 * @var string
	 */
	protected string $mDisplayName = '';

	/**
	 * 2024/05/04 Exemple - The by-product of consuming Uranium Fuel Rods in the Nuclear Power Plant.\r\nNon-fissile Uranium can be extracted. Handle with caution.\r\n\r\nCaution: HIGHLY Radioactive.
	 * @var string
	 */
	protected string $mDescription = '';



	/////////////////////////
	///// Construction
	/////

	function __construct(string $NativeClass, $srcData) {
		$this->NativeClass = $NativeClass;
		$this->srcData = $srcData;
	}



	/////////////////////////
	///// Consultation
	/////

	/**
	 * Obtenir la designation complete du type de cet objet.
	 * @example (2024/05/04)
	 * <br>/Script/CoreUObject.Class'/Script/FactoryGame.FGRecipe'
	 * <br>/Script/CoreUObject.Class'/Script/FactoryGame.FGItemDescriptor'
	 * @return string
	 */
	function getNativeClass(): string {
		return $this->NativeClass;
	}

	/**
	 * Obtenir la categorie "naturel" a laquel appartient cet objet.
	 * @example (2024/05/04)
	 * <br>FGRecipe, FGItemDescriptor, FGItemDescriptorBiomass, FGBuildableGeneratorFuel, FGBuildingDescriptor
	 * @return string
	 */
	function getNativeName(): string {
		return substr($this->NativeClass, strrpos($this->NativeClass, '.') + 1, -1);
	}

	/**
	 * Obtenir l'identifiant unique de cet objet.
	 * @example (2024/05/04)
	 * <br>Desc_NuclearWaste_C, Recipe_Biomass_Leaves_C
	 * @return string
	 */
	function getClassName(): string {
		return $this->ClassName;
	}

	/**
	 * Extraire, de l'identifiant unique de cet objet, son nom.
	 * @example (2024/05/04)
	 * <br>NuclearWaste_C, Biomass_Leaves_C
	 * @return string
	 */
	function getName(): string {
		return self::extractNameFromClassName($this->ClassName);
	}

	/**
	 * Extraire, de l'identifiant unique de cet objet, sa version courte.
	 * @example (2024/14/10)
	 * <br>NuclearWaste, Biomass_Leaves
	 * @return string
	 */
	function getShortName(): string {
		return self::extractShortNameFromClassName($this->ClassName);
	}

	/**
	 * Obtenir le nom convivial de cet objet.
	 * @example (2024/05/04)
	 * <br>Uranium Waste, Biomass (Leaves)
	 * @return string
	 */
	function getDisplayName(): string {
		return $this->mDisplayName;
	}

	/**
	 * Obtenir l'eventuelle description de cet objet.
	 * @example (2024/05/04)
	 * <br>Fuel, packaged for alternative transport. Can be used as fuel for Vehicles or the Jetpack.
	 * @return string
	 */
	function getDescription(): string {
		return $this->mDescription;
	}



	/////////////////////////
	///// Affichage/Output
	/////

	function __toString() {
		return $this->__toString2();
	}

	function __toString2(int $format=0) {
		switch($format) {
		case self::TS_HTML_INNERTAG:
			$str = htmlspecialchars($this->mDisplayName);
			break;
		case self::TS_HTML_BLOCKTAG:
		case self::TS_HTML_TAGATTR_TITLE:
			$str = htmlentities($this->mDisplayName);
			break;
		case self::TS_JSON:
			$str = json_encode($this->srcData);
			break;
		case self::TS_CSV:
		default:
			$str = $this->NativeClass;
			$str .= ', ' . $this->ClassName;
			$str .= ', ' . $this->mDisplayName;
			$str .= ', ' . $this->mDescription;
		}
		return $str;
	}



	/////////////////////////
	///// Interface statique
	/////


	private static array $all;

	/**
	 * Definir la liste integrale des elements d'une categorie.
	 * @param string $cat Categorie des elements (FGItem, FGBuilding, FGRecipe, ...)
	 * @param array $elements Liste des elements
	 * <br>Format : array(string ClassName => FGElement)
	 * @throws Exception Si deux elements ont le meme DisplayName
	 */
	static function setCat(string $cat, array &$elements) {
		/* @var $element FGElement */

		$dnames = array();
		foreach($elements as $ClassName => $element) {
			$dname = $element->getDisplayName();

			// Assertion - Dans une catégorie, chaque élément doit disposer d'un nom unique.
			if (isset($dnames[$dname])) throw new Exception("'{$ClassName}' => '{$dname}'");
			$dnames[$dname] = $ClassName;
		}

		self::$all[$cat] = &$elements;
	}

	/**
	 * Obtenir la liste des elements d'une categorie.
	 * @return array array(string ClassName => FGElement)
	 */
	static function &getAll(): array {
		return self::$all;
	}

	static function &getCat(string $cat): array {
		return self::$all[$cat];
	}


	/**
	 * @param string $bpClassName ex: /Game/FactoryGame/Resource/Parts/GenericBiomass/Desc_Leaves.Desc_Leaves_C
	 * @return string ex: retourne Desc_Leaves_C
	 */
	static function convBPCNtoClassName(string $bpClassName): string {
		$pos = strrpos($bpClassName, '.');
		if ($pos === false) throw new Exception($bpClassName);
		return substr($bpClassName, $pos+1);
	}

	/**
	 * @param string $ClassName ex: Desc_Leaves_C
	 * @return string ex: retourne Leaves_C
	 */
	static function extractNameFromClassName($ClassName) {
		return substr($ClassName, strpos($ClassName, '_') + 1);
	}

	/**
	 * @param string $ClassName ex: Desc_Leaves_C
	 * @return string ex: retourne Leaves
	 */
	static function extractShortNameFromClassName($ClassName) {
		$start = strpos($ClassName, '_');
		$end = strrpos($ClassName, '_');
		if (($end-$start) <= 2) throw new Exception($ClassName);

		return substr($ClassName, $start+1, $end-$start-1);
	}

	static function getClassNameByDisplayName(string $cat, string $needle): string {
		$fge = FGElement::getByDisplayName($cat, $needle);
		return $fge->getClassName();
	}

	static function getByClassName(string $cat, string $needle): object {
		$elements = self::getCat($cat);

		$res = array();
		foreach($elements as $fge) {
			if ($needle === $fge->ClassName) $res[] = $fge;
		}

		if (count($res)==1) {
			return reset($res);
		} else {
			throw new Exception("{$cat}({$needle}) count=". count($res));
		}
	}

	static function getByDisplayName(string $cat, string $needle): object {
		$elements = self::getCat($cat);

		$res = array();
		foreach($elements as $fge) {
			if ($needle === $fge->mDisplayName) $res[] = $fge;
		}

		if (count($res)==1) {
			return reset($res);
		} else {
			throw new Exception("{$cat}({$needle}) count=". count($res));
		}
	}

	static function getByName(string $cat, string $needle): object {
		$elements = self::getCat($cat);

		$res = array();
		foreach($elements as $fge) {
			if ($needle === $fge->getName()) $res[] = $fge;
		}

		if (count($res)==1) {
			return reset($res);
		} else {
			throw new Exception("{$cat}({$needle}) count=". count($res));
		}
	}

}

