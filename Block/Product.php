<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category   DerModPro
 * @package    DerModPro_BasePrice
 * @copyright  Copyright (c) 2009 Vinai Kopp http://netzarbeiter.com/
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


class DerModPro_BasePrice_Block_Product extends Mage_Catalog_Block_Product
{
	public function getPriceHtml($product)
	{
		$html = parent::getPriceHtml($product);
		$this->setTemplate('baseprice/baseprice.phtml');
		$html .= $this->toHtml();
		return $html . 'bbb';
	}
}