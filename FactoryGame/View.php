<?php
namespace Kemenyende\FactoryGame;

abstract class View
{
	private static function getElementSpanClass(FGElement $element): ?string {
		$cssClass = $element->getNativeName();

		if ($element instanceof FGItem) {
			$cssClass .= ' '.$element->getForm();

			if ($element->isPickUpRessource()) {
				$cssClass .= ' SrcPickUp';
			}

			if ($element->isRadioactive() && $element->isFuel()) {
				$cssClass .= ' RadioactivePower';
			} elseif ($element->isRadioactive()) {
				$cssClass .= ' Radioactive';
			} elseif ($element->isFuel()) {
				$cssClass .= ' Power';
			}
		} else if ($element instanceof FGRecipe) {
			if ($element->isAlternate()) {
			}
		} else if ($element instanceof FGBuilding) {
			if ($element->isPowerGenerator()) {
				$cssClass .= ' PowerGenerator';
			} elseif ($element->isResourceExtractor()) {
				$cssClass .= ' Extractor';
			}
		}

		return !empty($cssClass) ? $cssClass : null;
	}

	static function echoFGElement(FGElement $element) {
		$spanClass = self::getElementSpanClass($element);

		echo '<label class="tooltip">';
		echo '<span';
		$triggerSpanClasses = array();
		if (isset($spanClass)) $triggerSpanClasses[] = $spanClass;
		//$triggerSpanClasses[] = 'tooltiptrigger';
		if (!empty($triggerSpanClasses)) echo ' class="'.implode(' ', $triggerSpanClasses).'"';
		echo '>';
		echo htmlspecialchars($element->getDisplayName());
		echo '</span>';
		echo '<input type="checkbox">';
		
		echo '<div class="tooltiptext">';
		echo $element->__toString2(FGElement::TS_HTML_BLOCKTAG);
		echo '</div>';
		
		echo '</label>';
	}

	static function echoFGElement2(FGElement $element) {
		/*
		.tooltip {
			display:inline;
		}
		
		.tooltiptrigger:hover + .tooltiptext {
			visibility: visible;
		}
		
		.tooltip .tooltiptext {
			position: absolute;
			visibility: hidden;
		
			padding: 1em;
			border-style: double;
			border-radius: 6px;
			min-width: 600px;
		
			background-color: #888888;
			color: #000000;
			font-size: 0.8em;
			font-weight: normal;
		}
		 */
		$spanClass = self::getElementSpanClass($element);

		echo '<div class="tooltip">';
		
		echo '<span';
		$triggerSpanClasses = array();
		if (isset($spanClass)) $triggerSpanClasses[] = $spanClass;
		$triggerSpanClasses[] = 'tooltiptrigger';
		if (!empty($triggerSpanClasses)) echo ' class="'.implode(' ', $triggerSpanClasses).'"';
		echo '>';
		echo htmlspecialchars($element->getDisplayName());
		echo '</span>';
		
		echo '<div class="tooltiptext">';
		echo $element->__toString2(FGElement::TS_HTML_BLOCKTAG);
		echo '</div>';

		echo '</div>';
	}

	static function showAllElements(int $style = 1) {
		$all = FGElement::getAll();

		switch ($style) {
		
			case 0:
			foreach($all as $cat => &$elements) {
				echo '<h1>', count($elements), ' ', $cat, '</h1><ul>';
				foreach($elements as $element) echo '<li>', View::echoFGElement($element), '</li>';
				echo '</ul>';
			}

			break;
			
			case 1:
			
			$all2 = array();
			foreach($all as $cat => &$elements) {
				foreach($elements as $element) {
					$category = $cat;
					if ('FGItem' == $cat) {
						/* @var $element FGItem */
						//if ($element->isFuel()) $category .= ' (Fuel)';
						
					} elseif ('FGBuilding' == $cat) {
						/* @var $element FGBuilding */
						//if ($element->isPowerGenerator()) $category .= ' (Power Generator)';
						//elseif ($element->isResourceExtractor()) $category .= ' (Extractor)';
						
					} elseif ('FGRecipe' == $cat) {
						/* @var $element FGRecipe */
						if ($element->isAlternate()) $category .= ' (Alternate)';
						elseif ($element->isInduced()) $category .= ' (Induced)';
						
					} elseif ('FGSchematic' == $cat) {
						/* @var $element FGSchematic */
						
					}
					if (!array_key_exists($category, $all2)) $all2[$category] = array();
					$all2[$category][] = $element;
				}
			}
			$all = $all2;
			unset($all2);
			
			$categories = array_keys($all);
			$catSizeMax = 0;

			echo '<table>';
			echo '<tr>';
			foreach($categories as $cat) {
				$elements = $all[$cat];
				$catSize = count($elements);
				if ($catSizeMax < $catSize) $catSizeMax = $catSize;
				echo '<th>', count($elements), ' ', $cat, '</th>';
			}
			echo '</tr>';

			
			$keys = array_keys($all);
			$values = array_fill(0, count($keys), true);
			$first = array_combine($keys, $values);
			unset($keys, $values);
			
			foreach(array_keys($all) as $cat) {
				reset($all[$cat]);
			}
			for($rowID = 0; $rowID<$catSizeMax; $rowID++) {
				echo '<tr>';
				foreach ($categories as $cat) {
					if ($first[$cat]) {
						$first[$cat] = false;
						$element = reset($all[$cat]);
					} else {
					$element = next($all[$cat]);
					}
					echo "\n", '<td>';
					if (false !== $element) View::echoFGElement($element);
					echo '</td>';

				}
				echo "\n", '</tr>';
			}
			echo '</table>';

			break;
		}
	}

}

