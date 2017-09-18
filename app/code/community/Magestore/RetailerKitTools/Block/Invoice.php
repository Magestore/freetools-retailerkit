<?php
/**
 * Magestore
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the Magestore.com license that is
 * available through the world-wide-web at this URL:
 * http://www.magestore.com/license-agreement.html
 * 
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @category    Magestore
 * @package     Magestore_Retailerkittools
 * @copyright   Copyright (c) 2012 Magestore (http://www.magestore.com/)
 * @license     http://www.magestore.com/license-agreement.html
 */

/**
 * Retailerkittools Custom Link Form Block
 * 
 * @category    Magestore
 * @package     Magestore_Retailerkittools
 * @author      Magestore Developer
 */
class Magestore_Retailerkittools_Block_Invoice extends Mage_Core_Block_Template
{
    protected function _construct()
    {
        parent::_construct();
    }

    public function getCompanyData(){
    	return Mage::app()->getRequest()->getParam('company');
    }

    public function getCustomerData(){
    	return Mage::app()->getRequest()->getParam('customer');
    }

    public function getInvoiceNumber(){
    	return Mage::app()->getRequest()->getParam('invoice_number');
    }

    public function getInvoiceDate(){
    	return Mage::app()->getRequest()->getParam('invoice_date');
    }
    public function getLineItems(){
    	return Mage::app()->getRequest()->getParam('line_items');
    }

    public function getNote(){
    	return Mage::app()->getRequest()->getParam('notes');
    }

    public function getTaxRate(){
    	return Mage::app()->getRequest()->getParam('tax_rate')/100;
    }

    public function getSubtotal(){
        $subtotal = Mage::app()->getRequest()->getParam('subtotal');        
        return $this->getCurrency().number_format($subtotal, 2, '.', ',');
        // return Mage::helper('core')->formatPrice($subtotal, true);
    }

    public function getGrandTotal(){
        $subtotal = Mage::app()->getRequest()->getParam('subtotal');
        $taxAmount = $subtotal * $this->getTaxRate();
        $grandtotal = $taxAmount + $subtotal;
        return $this->getCurrency().number_format($grandtotal, 2, '.', ',');
        // return Mage::helper('core')->formatPrice($grandtotal, true);
    }

    public function getTaxAmount(){
        $subtotal = Mage::app()->getRequest()->getParam('subtotal');
        $taxAmount = $subtotal * $this->getTaxRate();
        return $this->getCurrency().number_format($taxAmount, 2, '.', ',');
    	// return Mage::helper('core')->formatPrice($taxAmount, true);
    }

    public function getLogo(){
        $path = Mage::getBaseDir('media') . DS . 'barcode';
        if($_FILES['company_logo']['name']){
            try{
                $fname = $_FILES['company_logo']['name'];
                $uploader = new Varien_File_Uploader('company_logo');
                $uploader->setAllowedExtensions(array('png', 'gif', 'jpeg', 'jpg'));
                $uploader->setAllowCreateFolders(true);
                $uploader->setAllowRenameFiles(false);
                $uploader->setFilesDispersion(false);
                $uploader->save($path, $fname);             
                $imageurl = Mage::getBaseUrl('media') . DS . 'barcode'. DS . $fname;
            }catch(Exception $e){
            } 
        }
        if(!$imageurl){
            $imageurl = Mage::app()->getRequest()->getParam('company_logo');
        }
        return $imageurl;
    }

    public function getCurrency(){
        return Mage::app()->getRequest()->getParam('currencies');
    }

}