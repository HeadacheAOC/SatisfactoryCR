<?php
namespace FactoryGame;

use Exception;

abstract class Region {

	private array $allFactory = array();
	private array $allSurplus = array();

	private bool $AllInOne = false;

	public function __construct(bool $AllInOne) {
		$this->AllInOne = $AllInOne;
		if ($this->AllInOne) $this->addFactory('AllInOne');
	}

	protected function addFactory(string $name): Factory {
	    if (array_key_exists($name, $this->allFactory)) throw new Exception($name);

	    if ($this->AllInOne && !empty($this->allFactory)) return reset($this->allFactory);

	    $factory = new Factory($name);
	    $this->allFactory[$name] = $factory;
	    return $factory;
	}

	/**
	 * (Usines) Creer les Zones Industrielles
	 */
	abstract protected function step1_addFactories();

	/**
	 * (Recettes) Ajouter les batiments de production
	 */
	abstract protected function step2_addRecipes();

	/**
	 * (Production) Collecte de la production de chacune des Z.I.
	 */
	protected function step3_proceed() {
	    foreach($this->allFactory as $name => $factory) {
	        $this->allSurplus[$name] = $factory->calcSurplus();
	    }
	}

	/**
	 * (Transfert) Tranferer une ressource d'un site a l'autre.
	 */
	protected function supply(Factory $dest, Factory $src, string $DisplayName, $amount=true) {
	if (false === $amount) return;
	$surplus = &$this->allSurplus[$src->getName()];
	$item = FGElement::getByDisplayName('FGItem', $DisplayName);
	$ClassName = $item->getClassName();
	if (!empty($surplus[$ClassName])) {
	    $available = $surplus[$ClassName];
	    if (true === $amount) $amount = $available;

	    if ($amount>=$available) {
	        unset($surplus[$ClassName]);
	        $dest->addSupply($ClassName, $available);
	    } else {
	        $surplus[$ClassName] -= $amount;
	        $dest->addSupply($ClassName, $amount);
	    }
	}
	}

	/**
	 * Echange de marchandises entre les Z.I.
	 */
	abstract protected function step4_Supply();

	/**
	 * Affichage
	 */
	protected function step5_Show() {
	    foreach($this->allFactory as $factory) {
	        $factory->show();
	    }

	    // Affichage : Visualiser ce qui semble devoir etre gere

	    $factory = new Factory('Surplus');
	    foreach($this->allSurplus as $surplus) {
	        $factory->addSupplies($surplus);
	    }
	    $factory->show();
	}

	public function proceed() {
	$this->step1_addFactories();
	$this->step2_addRecipes();
	$this->step3_proceed();
	if (!$this->AllInOne) $this->step4_Supply();
	$this->step5_Show();
	}
}

