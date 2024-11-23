<?php
namespace FactoryGame;

abstract class View
{
	private static function getElementSpanClass(FGElement $element): ?string {
		$cssClass = $element->getNativeName();

		if ($element instanceof FGItem) {
			$cssClass .= ' '.$element->getForm();

			if ($element->isPickUpRessource()) {
				$cssClass .= ' SrcPickUp';
			}

			if ($element->isRadioactive()) {
				$cssClass .= ' Radioactive';
			}
		} else if ($element instanceof FGRecipe) {
			if ($element->isAlternate()) {
			}
		}

		return !empty($cssClass) ? $cssClass : null;
	}

	static function echoFGElement(FGElement $element) {
		$spanClass = self::getElementSpanClass($element);

		echo '<span';
		echo ' class="tooltip';
		if (isset($spanClass)) echo " {$spanClass}";
		echo '"';
		echo '>';
		echo htmlspecialchars($element->getDisplayName());

		echo '<div class="tooltiptext">';
	    echo $element->__toString2(FGElement::TS_HTML_BLOCKTAG);
		echo '</div>';

		echo '</span>';
	}

	static function echoFGElement2(FGElement $element) {
		$spanClass = self::getElementSpanClass($element);

		echo '<span';
		if (isset($spanClass)) echo ' class="'.$spanClass.'"';
		echo ' title="', $element->__toString2(FGElement::TS_HTML_TAGATTR_TITLE), '"';
		echo '>';
		echo htmlspecialchars($element->getDisplayName());
		if ($element instanceof FGItem) {
			if ($element->isRawRessource()) {
			}
		} else if ($element instanceof FGRecipe) {
			if ($element->isAlternate()) {
			}
		}
		echo '</span>';
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
				$categories = array_keys($all);
				$catSizeMax = 0;

				echo '<table>';
				echo '<tr>';
				foreach($all as $cat => &$elements) {
					$catSize = count($elements);
					if ($catSizeMax < $catSize) $catSizeMax = $catSize;
					echo '<th>', count($elements), ' ', $cat, '</th>';
				}
				echo '</tr>';

				for($rowID = 0; $rowID<$catSizeMax; $rowID++) {
					echo '<tr>';
					foreach ($categories as $cat) {
						$element = next($all[$cat]);
						echo '<td>';
						if (false !== $element) View::echoFGElement($element);
						echo '</td>';

					}
					echo '</tr>';
				}
				echo '</table>';

				break;
		}
	}

}

