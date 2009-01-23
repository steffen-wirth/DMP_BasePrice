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
 * @category   DerModPro
 * @package    DerModPro_BasePrice
 * @copyright  Copyright (c) 2009 Vinai Kopp http://netzarbeiter.com/
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
/**
 * Observer for the hideprices extension.
 *
 * @category   DerModPro
 * @package    DerModPro_BasePrice
 * @author     Vinai Kopp <vinai@netzarbeiter.com>
 */
class DerModPro_BasePrice_Model_Observer extends Mage_Core_Model_Abstract
{
	/**
	 * Set the default value on a prduct
	 *
	 * @param Varien_Event_Observer $observer
	 */
	public function catalogProductLoadAfter($observer)
	{
		if (! Mage::helper('baseprice')->moduleActive()) return;
		$product = $observer->getProduct();
		foreach (array('base_price_amount', 'base_price_unit', 'base_price_base_amount', 'base_price_base_unit') as $attributeCode)
		{
			$data = $product->getDataUsingMethod($attributeCode);
			if (! isset($data))
			{
				$attribute = Mage::getModel('eav/entity_attribute')->loadByCode('catalog_product', $attributeCode);
				$product->setDataUsingMethod($attributeCode, $attribute->getFrontend()->getValue($product));
			}
		}
	}
	
	/**
	 * Check the selected unit types are compatible
	 *
	 * @param Varien_Event_Observer $observer
	 */
	public function catalogProductSaveBefore($observer)
	{
		if (! Mage::helper('baseprice')->moduleActive()) return;
		$product = $observer->getProduct();
		if ($product->getBasePriceAmount())
		{
			$fromUnit = $product->getBasePriceUnit();
			$toUnit = $product->getBasePriceBaseUnit();
			// will throw Exception if no conversion rate is defined
			try {
				$rate = Mage::getSingleton('baseprice/baseprice')->getConversionRate($fromUnit, $toUnit);
			}
			catch (Exception $e)
			{
				Mage::throwException($e->getMessage() . "<br/>\n" . Mage::helper('baseprice')->__('The product settings where not saved'));
			}
		}
	}
}

