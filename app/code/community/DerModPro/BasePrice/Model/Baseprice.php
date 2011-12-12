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
 * Baseprice model
 *
 * @category   DerModPro
 * @package    DerModPro_BasePrice
 * @author     Vinai Kopp <vinai@der-modulprogrammierer.de>
 */
class DerModPro_BasePrice_Model_Baseprice extends Varien_Object
{
	public function __construct(array $params = null)
	{
		if (isset($params['reference_unit'])) $this->setReferenceUnit($params['reference_unit']);
		if (isset($params['reference_amount'])) $this->setReferenceAmount($params['reference_amount']);
	}
	
	public function getReferenceUnit()
	{
		$unit = $this->getData('reference_unit');
		if (! isset($unit) || ! $unit)
		{
			Mage::throwException(Mage::helper('baseprice')->__('Reference unit not set'));
		}
		return $unit;
	}
	
	public function getReferenceAmount()
	{
		$amount = $this->getData('reference_amount');
		if (! isset($amount) || ! $amount)
		{
			$amount = Mage::helper('baseprice')->getConfig('default_base_price_base_amount');
		}
		return $amount;
	}
	
	public function getBasePrice($productAmount, $productUnit, $productPrice)
	{
		try
		{
			if ($productAmount <= 0)
			{
				Mage::throwException(Mage::helper('baseprice')->__('The product unit amount must be greater the zero'));
			}
			$rate = $this->getConversionRate($productUnit, $this->getReferenceUnit());
			$result = $productPrice / $productAmount / $rate * $this->getReferenceAmount();
			return $result;
		}
		catch (Exception $e)
		{
			Mage::throwException($e->getMessage());
		}
	}
	
	public function getConversionRate($fromUnit, $toUnit)
	{
		$fromUnit = trim(strtoupper($fromUnit));
		$toUnit = trim(strtoupper($toUnit));
		if ($fromUnit === $toUnit) return 1;
		$h = Mage::helper('baseprice');
		$rate = $h->getConfig(sprintf('convert/%s/to/%s', $fromUnit, $toUnit));
		if (! isset($rate) || ! $rate)
		{
			Mage::throwException($h->__('Conversion rate not found for %s to %s', $h->__($fromUnit), $h->__($toUnit)));
		}
		return $rate;
	}
	
	public function toOptionArray()
	{
		$options = array();
		$h = Mage::helper('baseprice');
		foreach (explode(',', $h->getConfig('units')) as $unit)
		{
			$options[] = array(
				'value' => $unit,
				'label' => $h->__($unit)
            );
		}
		return $options;
	}
}