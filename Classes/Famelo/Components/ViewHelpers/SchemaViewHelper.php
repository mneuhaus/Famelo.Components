<?php
namespace Famelo\Components\ViewHelpers;
/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Famelo.Components".     *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Reflection\ObjectAccess;

class SchemaViewHelper extends \TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper {
	/**
	 *
	 * @param string $className
	 * @return string
	 */
	public function render($className) {
		// return ObjectAccess::getProperty($object, $name);
	}
}