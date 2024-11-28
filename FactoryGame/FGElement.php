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
	 * @var int (CSV) Comma-Separated Values.
	 */
	public const TS_CSV = 0;

	/**
	 * @var int (JSON) Encoder avec json_encode()
	 */
	public const TS_JSON = 1;

	/**
	 * @var int (HTML) A destination du contenu d'une balise HTML de type inline (ex: SPAN).
	 */
	public const TS_HTML_INNERTAG = 2;

	/**
	 * @var int (HTML) A destination de l'attribut TITLE d'une balise HTML.
	 */
	public const TS_HTML_TAGATTR_TITLE = 3;

	/**
	 * @var int (HTML) A destination du contenu d'une balise HTML de type block (ex DIV).
	 */
	public const TS_HTML_BLOCKTAG = 4;
	
	public const TS_HTML_INNERBLOCKTAG = 5;
	



	/////////////////////////
	///// Definition de l'objet

	/**
	 * @var object Source - Definition de l'objet. Provient directement du fichier JSON mis a la disposition de la communaute par Satisfactory.
	 */
	private ?object $srcData;

	/**
	 * @var string 2024/05/04 Exemple - /Script/CoreUObject.Class'/Script/FactoryGame.FGItemDescriptor'
	 */
	protected string $NativeClass;

	/**
	 * @var string 2024/05/04 Exemple - Desc_NuclearWaste_C
	 */
	protected string $ClassName = '';

	/**
	 * @var string 2024/05/04 Exemple - Uranium Waste
	 */
	protected string $mDisplayName = '';

	/**
	 * @var string 2024/05/04 Exemple - The by-product of consuming Uranium Fuel Rods in the Nuclear Power Plant.\r\nNon-fissile Uranium can be extracted. Handle with caution.\r\n\r\nCaution: HIGHLY Radioactive.
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
	 * Extraire, de l'identifiant unique de cet objet, la version courte de son nom.
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
	 * Obtenir la description de cet objet.
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
		case self::TS_HTML_INNERBLOCKTAG:
		case self::TS_HTML_BLOCKTAG:
			$str = htmlspecialchars($this->mDisplayName);
			break;
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

	/**
	 * @var array Liste complete des elements extraits du fichier source.
	 * Ces elements sont organises par categories ('FGItem', 'FGBuilding', 'FGRecipe', ...).
	 * <p>Format: array(string $cat => array(string $ClassName => ? extends FGElement $element))</p>
	 */
	private static array $all;

	/**
	 * Definir la liste integrale des elements d'une categorie.
	 * @param string $cat Categorie des elements ('FGItem', 'FGBuilding', 'FGRecipe', ...).
	 * @param array $elements Liste des elements
	 * <p>Format : array(string ClassName => FGElement)</p>
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

	static function &getAll(): array {
		return self::$all;
	}

	/**
	 * Obtenir la liste des elements d'une categorie.
	 * @param string $cat Nom de la categorie ('FGItem', 'FGBuilding', 'FGRecipe', ...).
	 * @return array array(string ClassName => FGElement)
	 */
	static function &getCat(string $cat): array {
		return self::$all[$cat];
	}


	/**
	 * Extraire le ClassName d'un element a partir de son BluePrintClassName (BPCN)
	 * @param string $bpClassName ex: /Game/FactoryGame/Resource/Parts/GenericBiomass/Desc_Leaves.Desc_Leaves_C
	 * @return string ex: retourne Desc_Leaves_C
	 */
	static function extractClassNameFromBPCN(string $bpClassName): string {
		$pos = strrpos($bpClassName, '.');
		if ($pos === false) throw new Exception($bpClassName);
		return substr($bpClassName, $pos+1);
	}

	/**
	 * Extraire le nom d'un element a partir de son ClassName
	 * @param string $ClassName ex: Desc_Leaves_C
	 * @return string ex: retourne Leaves_C
	 */
	static function extractNameFromClassName($ClassName) {
		return substr($ClassName, strpos($ClassName, '_') + 1);
	}

	/**
	 * Extraire la version courte du nom d'un element a partir de son ClassName
	 * @param string $ClassName ex: Desc_Leaves_C
	 * @return string ex: retourne Leaves
	 */
	static function extractShortNameFromClassName($ClassName) {
		$start = strpos($ClassName, '_');
		$end = strrpos($ClassName, '_');
		if (($end-$start) <= 2) throw new Exception($ClassName);

		return substr($ClassName, $start+1, $end-$start-1);
	}

	/**
	 * Obtenir le ClassName d'un element a partir de son nom convivial
	 * @param string $cat Categorie de l'element
	 * @param string $needle Nom convivial
	 * @return string
	 */
	static function getClassNameByDisplayName(string $cat, string $needle): string {
		$fge = FGElement::getByDisplayName($cat, $needle);
		return $fge->getClassName();
	}

	/**
	 * Obtenir un element a partir de son ClassName
	 * @param string $cat Categorie de l'element
	 * @param string $needle ClassName
	 * @return object Element trouve
	 */
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

	/**
	 * Obtenir un element a partir de son nom convivial
	 * @param string $cat Categorie de l'element
	 * @param string $needle Nom convivial
	 * @return object Element trouve
	 */
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

	/**
	 * Obtenir un element a partir de son nom
	 * @param string $cat Categorie de l'element
	 * @param string $needle Nom
	 * @return object Element trouve
	 */
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

