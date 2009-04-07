<?php

$this->startSetup();

try
{
    Mage::getResourceModel('catalog/product_flat_indexer')->rebuild();
}
catch (Exception $e)
{
    //Mage::log("Error building flat product catalog: " . $e->getMessage());
}

$this->endSetup();