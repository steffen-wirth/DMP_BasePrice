<?php
/**
 * Der Modulprogrammierer - Vinai Kopp, Rico Neitzel GbR
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
 * @category   DerModPro
 * @package    DerModPro_BasePrice
 * @copyright  Copyright (c) 2009 Der Modulprogrammierer - Vinai Kopp, Rico Neitzel GbR http://der-modulprogrammierer.de/
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Source model for baseprice attributes
 *
 * @category   DerModPro
 * @package    DerModPro_BasePrice
 * @author     Vinai Kopp <vinai@der-modulprogrammierer.de>
 */
abstract class DerModPro_BasePrice_Model_Entity_Source_Baseprice_Abstract
	extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
	protected $_basePriceDefaultKey = '';
	
	public function getDefaultValue()
	{
		$value = null;
		if ($this->_basePriceDefaultKey)
		{
			$value = Mage::helper('baseprice')->getConfig($this->_basePriceDefaultKey);
		}
		return $value;
	}
}