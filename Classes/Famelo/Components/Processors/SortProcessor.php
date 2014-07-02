<?php
namespace Famelo\Components\Processors;


/*                                                                        *
 * This script belongs to the FLow framework.                            *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License as published by the *
 * Free Software Foundation, either version 3 of the License, or (at your *
 * option) any later version.                                             *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser       *
 * General Public License for more details.                               *
 *                                                                        *
 * You should have received a copy of the GNU Lesser General Public       *
 * License along with the script.                                         *
 * If not, see http://www.gnu.org/licenses/lgpl.html                      *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use Doctrine\ORM\Mapping as ORM;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Configuration\ConfigurationManager;
use TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 */
class SortProcessor extends AbstractProcessor {
	/**
	 *
	 * @param object $query
	 * @return string Rendered string
	 * @api
	 */
	public function process($query) {
		$this->request = $this->controllerContext->getRequest();

		$sortBy = $this->templateVariableContainer->get('defaultSortBy');
		$order = $this->templateVariableContainer->get('defaultOrder');

		if( $this->request->hasArgument("sortBy") ){
			$sortBy = $this->request->getArgument("sortBy");

			if( $this->request->hasArgument("order") ){
				$order = $this->request->getArgument("order");
			} else {
				$order = "DESC";
			}
		}

		if ($sortBy !== NULL) {
			$query->setOrderings(array(
				$sortBy => $order
			));
		}

		$this->sorting = array(
			"sortBy" => $sortBy,
			"order"=> $order,
			"oppositeOrder"=> $order == "ASC" ? "DESC" : "ASC"
		);

		$this->addWrapper('field', $this);
	}

	public function wrap($content, $arguments) {
		$arguments['content'] = $content;
		$this->viewHelperVariableContainer->add('Famelo\Common\ViewHelpers\Query\SortViewHelper', 'sorting', $this->sorting);
		$content =  $this->viewHelperVariableContainer->getView()->renderPartial('SortField', NULL, $arguments);
		$this->viewHelperVariableContainer->remove('Famelo\Common\ViewHelpers\Query\SortViewHelper', 'sorting');
		return $content;
	}
}

?>