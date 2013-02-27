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
 * @copyright  Copyright (c) 2012 Netresearch GmbH 
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

ABOUT
This extension enables you to display the base price for products.  E.g. if you sell
different quantities of oil, you can enter the amount each bottle contains (like 250ml)
and a reference unit (like liter), and the price per liter is calculated and displayed.

What can be configured:
- Product Unit:
   The packaging unit of your products: Milliliter, Gram, Centimeter, Milligram,...

- Product Amount:
   The amount of the packaging unit (e.g. 100g)

- Reference Unit:
   The unit the price should be calculated for. It should match the type of unit chosen
   for the product (Milliliter to Liter, Milligram to Gram or Kilogram, Centimeter to Meter,...)

- Reference Amount:
   Probably you will want to have 1 (one) as the reference amount. But if you want to have a
   different amount, you can choose one here.


You can specify defaults on a global, website or store view scope for all products
in the admin interface under System / Catalog / Hide Prices

You can override those default settings in the Product Management page at
Catalog / Manage Products / (Choose a Product) / Prices

In the configuration you may also disable the extension on a store view scope.

NOTICE
This extension provides base prices for simple products. We provide a commercial
Extension that extends the BasePrice Module to add support for custom options,
configurable products and bundled products. You can purchase that module on the
http://der-modulprogrammierer.de website.


LIST VIEW
To display baseprices in the list view, you can either add the following code to your
catalog/product/list.phtml template, or enable the commented out XML block in
app/design/frontend/default/default/layout/baseprice.xml
This is the code that displays the short baseprice label for a product:

				<?php if($baseprice = Mage::helper('baseprice')->getBasePriceLabel($_product, true)): ?>
				<div class="baseprice">(<?php echo $baseprice ?>)</div>
				<?php endif; ?>


UNINSTALL
If you ever uninstall the extension (I don't hope so ;)) your site will be broken, because
Magento doesn't support a mechanism to remove attributes with an extension, and this
extension uses source models.
To fix the Error, you have to execute the following SQL:

   DELETE FROM `eav_attribute` where attribute_code IN ('base_price_amount','base_price_unit','base_price_base_amount','base_price_base_unit');   
   DELETE FROM `core_resource` where code = 'baseprice_setup';

Afterwards don't forget to clear the cache.


CHANGELOG
0.3.2 Support new base unit: square meter (m²)
0.3.1 Move frontend theme files to base interface
0.3.0 Load default values on existing products when the extension was installed
0.2.9 Avoid error when fromUnit or toUnit isn't set (Thanks to Jörg Weller!)
0.2.8 Another release because of a Magento Connect error :-(
0.2.7 New version because of Magento Connect error :-/
0.2.6 BCP compatibility upgrade
0.2.5 Magento 1.4 update, BCP compatibility update
0.2.4 Add Piece as a new unit
0.2.3 Small refactoring, and: released as stable
0.2.2 Added new format templates for the labels: {{product_amount}}, {{product_unit}} and {{product_unit_short}}
0.2.1 Fixed source models to work wth fat cataog model in magento 1.3.1
0.1.9 Automaticaly rebuild flat product catalog after installation
0.1.8 Magento 1.3 compatibility release
0.1.6 Removed debug log statements
0.1.5 Add missing translation namespaces
0.1.4 Add list view support (requires template editing to enable)
0.1.3 Set translation namespace correctly on blocks
0.1.2 Initial Release


BUGS
If you have ideas for improvements or find bugs, please send them to vinai@der-modulprogrammierer.de,
with DerModPro_BasePrice as part of the subject.
