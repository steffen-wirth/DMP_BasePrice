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
 * @copyright  Copyright (c) 2009 Der Modulprogrammierer - Vinai Kopp, Rico Neitzel GbR http://der-modulprogrammierer.de/
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Helper for the baseprice extension.
 *
 * @category   DerModPro
 * @package    DerModPro_BasePrice
 * @author     Vinai Kopp <vinai@der-modulprogrammierer.de>
 */
class DerModPro_BasePrice_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function getBasePriceLabel($product)
	{
		if (! ($productAmount = $product->getBasePriceAmount())) return '';
		
		$productUnit = $product->getBasePriceUnit();
		$productPrice = $product->getFinalPrice();
		if (! $productPrice) return '';
		
		$productPrice = Mage::helper('tax')->getPrice($product, $productPrice, $this->getConfig('base_price_incl_tax'));
		$referenceAmount = $product->getBasePriceBaseAmount();
		$referenceUnit = $product->getBasePriceBaseUnit();
		$basePriceModel = Mage::getModel('baseprice/baseprice', array('reference_unit' => $referenceUnit, 'reference_amount' => $referenceAmount));
		$basePrice = $basePriceModel->getBasePrice($productAmount, $productUnit, $productPrice);
		
		$label = $this->__($this->getConfig('frontend_label'));
		$label = str_replace('{{baseprice}}', Mage::helper('core')->currency($basePrice), $label);
		$label = str_replace('{{reference_amount}}', $referenceAmount, $label);
		$label = str_replace('{{reference_unit}}', $this->__($referenceUnit), $label);
		return $label;
	}
	
	/**
	 * Check if the script is called from the adminhtml interface
	 *
	 * @return boolean
	 */
	public function inAdmin()
	{
		return Mage::app()->getStore()->isAdmin();
	}
	
	/**
	 * Dump a variable to the logfile (defaults to hideprices.log)
	 *
	 * @param mixed $var
	 * @param string $file
	 */
	public function log($var, $file = null)
	{
		$file = isset($file) ? $file : 'baseprice.log';
		
		$var = print_r($var, 1);
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') $var = str_replace("\n", "\r\n", $var);
		Mage::log($var, null, $file);
	}

	/**
	 * Check if the extension has been disabled in the system configuration
	 */
	public function moduleActive()
	{
		return ! (bool) $this->getConfig('disable_ext');
	}
	
	/**
	 * Return the config value for the passed key (current store)
	 * 
	 * @param string $key
	 * @return string
	 */
	public function getConfig($key)
	{
		$path = 'catalog/baseprice/' . $key;
		return Mage::getStoreConfig($path, Mage::app()->getStore());
	}
}

