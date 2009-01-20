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

/**
 * Backend model for attribute with multiple values, Netzarbeiter_GroupsCatalog version
 *
 * @category   DerModPro
 * @package    DerModPro_BasePrice
 * @author     Vinai Kopp <vinai@netzarbeiter.com>
 */
class DerModPro_BasePrice_Model_Entity_Backend_Baseprice_Unit
	extends Mage_Eav_Model_Entity_Attribute_Backend_Array
{
	
	/**
	 * Prepare the unit selecton array before saving
	 *
	 * @param Mage_Catalog_Model_Product $object
	 * @return nothing afaik :)
	 */
    public function beforeSave($object)
    {
        $data = $object->getData($this->getAttribute()->getAttributeCode());
        $helper = Mage::helper('baseprice');
        $default = $helper->getConfig('default/' . $this->getAttribute()->getAttributeCode());
        
        /**
         * Default to using the default - don't let the user select nothing
         */
        if (empty($data)) {
        	$object->setData($this->getAttribute()->getAttributeCode(), array($default));
        }
        
        /**
         * Mage_Eav_Model_Entity_Attribute_Backend_Array::beforeSave() makes a string from the array values
         */
        return parent::beforeSave($object);
    }
}