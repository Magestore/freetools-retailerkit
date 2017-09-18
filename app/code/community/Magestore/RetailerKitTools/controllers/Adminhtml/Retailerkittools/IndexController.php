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
 * @package     Magestore_RetailerKitTools
 * @module     RetailerKitTools
 * @author      Magestore Developer
 *
 * @copyright   Copyright (c) 2016 Magestore (http://www.magestore.com/)
 * @license     http://www.magestore.com/license-agreement.html
 *
 */
class Magestore_RetailerKitTools_Adminhtml_RetailerKitTools_IndexController extends Mage_Adminhtml_Controller_Action
{
	public function invoicegeneratorAction()
    {
        $this->loadLayout();        
        $this->getLayout()->getBlock('head')->setTitle(Mage::helper('retailerkittools')->__('Invoice Generator'));
        $this->renderLayout();
    }

    public function purchaseorderAction()
    {
        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setTitle(Mage::helper('retailerkittools')->__('Generate purchase order'));
        $this->renderLayout();
    }

    public function printshippinglabelAction()
    {
        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setTitle(Mage::helper('retailerkittools')->__('Shipping Label Printer'));
        $this->renderLayout();
    }

    public function  makebarcodeAction()
    {
        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setTitle(Mage::helper('retailerkittools')->__('Barcode Maker'));
        $this->renderLayout();
    }

    public function calcpaypalfeeAction()
    {
        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setTitle(Mage::helper('retailerkittools')->__('Paypal Fee Calculator'));
        $this->renderLayout();
    }

    public function companyinfoAction()
    {
        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setTitle(Mage::helper('retailerkittools')->__('Company Information'));
        $this->renderLayout();
    }

    public function shippingsenderAction()
    {
        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setTitle(Mage::helper('retailerkittools')->__('Shipping Sender Information'));
        $this->renderLayout();
    }

    public function printinvoiceAction()
    {
    	$this->loadLayout();
        $data = $this->getRequest()->getParams();
        // Transactional Email Template's ID
        $translate = Mage::getSingleton('core/translate');
        $translate->setTranslateInline(false);
        $templateId = 'retailerkittools_email_invoice';
 
        // Set sender information           
        $senderName = Mage::getStoreConfig('trans_email/ident_support/name');
        $senderEmail = Mage::getStoreConfig('trans_email/ident_support/email');     
        $sender = array('name' => $senderName,
                    'email' => $senderEmail);
        // Set recepient information
        $recepientEmail = $data['company']['company_email'];
        $recepientName = $data['company']['company_name'];
        if($_FILES['company_logo']['name'] && $_FILES['company_logo']['type'] == 'image/jpeg'){
            try{
                $fname = $_FILES['company_logo']['name'];
                $imageurl = Mage::getBaseUrl('media') . DS . 'barcode'. DS . $fname;
                $data['company_logo'] = $imageurl;
            }catch(Exception $e){
            } 
        }
        // Get Store ID     
        $store = Mage::app()->getStore()->getId();
        $model = Mage::getModel('retailerkittools/invoice');
        $invoice = $model->setInvoiceData(json_encode($data))->save();
        $invoiceid = $model->getId();        
        // Set variables that can be used in email template
        $vars = array(
            'data' => json_encode($data),
            'url'   => Mage::getUrl('retailerkittools/index/showinvoice/').'?data='.$invoiceid
        );             
        // Send Transactional Email
        Mage::getModel('core/email_template')
            ->sendTransactional($templateId, $sender, $recepientEmail, $recepientName, $vars, 0);
                
        $translate->setTranslateInline(true);   
        $this->renderLayout();
    	// $result = array();
     //    $result['html'] = $this->getLayout()->createBlock('retailerkittools/invoice')->setTemplate('retailerkittools/invoice.phtml')->toHtml();
     //    $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }

    public function showinvoiceAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function showorderAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    } 

    public function showlabelAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }  

    public function printorderAction()
   {
        $this->loadLayout();
        $data = $this->getRequest()->getParams();
        // Transactional Email Template's ID
        $translate = Mage::getSingleton('core/translate');
        $translate->setTranslateInline(false);
        $templateId = 'retailerkittools_email_order';
 
        // Set sender information           
        $senderName = Mage::getStoreConfig('trans_email/ident_support/name');
        $senderEmail = Mage::getStoreConfig('trans_email/ident_support/email');     
        $sender = array('name' => $senderName,
                    'email' => $senderEmail);
        // Set recepient information
        $recepientEmail = $data['company']['email'];
        $recepientName = $data['company']['company_name'];
        
        // Get Store ID     
        $store = Mage::app()->getStore()->getId();
        $model = Mage::getModel('retailerkittools/order');
        $order = $model->setOrderData(json_encode($data))->save();
        $ordereid = $model->getId();
        // Set variables that can be used in email template
        $vars = array(
            'data' => json_encode($data),
            'url'   => Mage::getUrl('retailerkittools/index/showorder/').'?data='.$ordereid
        );            
 
        // Send Transactional Email
        Mage::getModel('core/email_template')
            ->sendTransactional($templateId, $sender, $recepientEmail, $recepientName, $vars, 0);
                
        $translate->setTranslateInline(true);   
        $this->renderLayout();
        // $result = array();
     //    $result['html'] = $this->getLayout()->createBlock('retailerkittools/invoice')->setTemplate('retailerkittools/invoice.phtml')->toHtml();
     //    $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    } 

    public function shippinglabelAction()
    {
        $this->loadLayout();
        $data = $this->getRequest()->getParams();
        // Transactional Email Template's ID
        $translate = Mage::getSingleton('core/translate');
        $translate->setTranslateInline(false);
        $templateId = 'retailerkittools_email_label';
 
        // Set sender information           
        $senderName = Mage::getStoreConfig('trans_email/ident_support/name');
        $senderEmail = Mage::getStoreConfig('trans_email/ident_support/email');     
        $sender = array('name' => $senderName,
                    'email' => $senderEmail);
        // Set recepient information
        $recepientEmail = $data['sender']['email'];
        $recepientName = $data['sender']['first_name'];
        // Get Store ID     
        $store = Mage::app()->getStore()->getId();
        $model = Mage::getModel('retailerkittools/label');
        $label = $model->setLabelData(json_encode($data))->save();
        $labelid = $model->getId();
        // Set variables that can be used in email template
        $vars = array(
            'data' => json_encode($data),
            'url'   => Mage::getUrl('retailerkittools/index/showlabel/').'?data='.$labelid
        );            
 
        // Send Transactional Email
        Mage::getModel('core/email_template')
            ->sendTransactional($templateId, $sender, $recepientEmail, $recepientName, $vars, 0);
                
        $translate->setTranslateInline(true);   
        $this->renderLayout();
        $this->renderLayout();
        // $result = array();
     //    $result['html'] = $this->getLayout()->createBlock('retailerkittools/invoice')->setTemplate('retailerkittools/invoice.phtml')->toHtml();
     //    $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }

    public function barcodeAction()
    {        
        $result = array();
        $filename="barcode.png";
        $barcodeString = $this->getRequest()->getParam('query');
        $file = Zend_Barcode::draw('code128', 'image', array('text' => $barcodeString, 'drawText' => false), array());
        $barcode_path= DS."barcode".DS."barcode.png";

        $store_image = imagepng($file,Mage::getBaseDir('media').$barcode_path);
        // var_dump();
        if($store_image)
        {
            $path = Mage::getBaseDir('media') . DS . $barcode_path;
            $urlImage = Mage::getBaseUrl('media') . DS . $barcode_path;            
            $result['urlImage'] = $urlImage;
        }
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));        
        // $this->_prepareDownloadResponse($filename, array('type' => 'filename', 'value' => $path));
    }

    public function savecompanyinfoAction(){
        $path = Mage::getBaseDir('media') . DS . 'barcode';
        try{
            if($_FILES['company_logo']['name']){
                $fname = $_FILES['company_logo']['name'];
                $uploader = new Varien_File_Uploader('company_logo');
                $uploader->setAllowedExtensions(array('png', 'gif', 'jpeg', 'jpg'));
                $uploader->setAllowCreateFolders(true);
                $uploader->setAllowRenameFiles(false);
                $uploader->setFilesDispersion(false);
                $uploader->save($path, $fname);        
                Mage::getModel('core/config')->saveConfig('retailerkittools/company/company_logo', $fname);
            }
            $data = $this->getRequest()->getParam('company');
            if($data){
                Mage::getModel('core/config')->saveConfig('retailerkittools/company/company_name', $data["company_name"]);
                Mage::getModel('core/config')->saveConfig('retailerkittools/company/company_email', $data["company_email"]);
                Mage::getModel('core/config')->saveConfig('retailerkittools/company/company_address', $data["company_address"]);
                Mage::getModel('core/config')->saveConfig('retailerkittools/company/company_city', $data["company_city"]);
                Mage::getModel('core/config')->saveConfig('retailerkittools/company/company_zipcode', $data["company_zipcode"]);
                Mage::getModel('core/config')->saveConfig('retailerkittools/company/company_country', $data["country"]);
                Mage::getModel('core/config')->saveConfig('retailerkittools/company/company_state', $data["province"]);
                Mage::getModel('core/config')->saveConfig('retailerkittools/company/company_state_id', $data["province_id"]);
            }
            Mage::getModel('core/config')->cleanCache();
            Mage::getSingleton('core/session')->addSuccess(
                    Mage::helper('retailerkittools')->__('Company Information was successfully saved')
                );
        }catch( Exception $e){

        }

        return $this->_redirect('*/*/companyinfo');
       
    }

    public function saveshippingsenderAction(){
        $data = $this->getRequest()->getParam('sender');
        try{
            if($data){
                Mage::getModel('core/config')->saveConfig('retailerkittools/shipping_sender/first_name', $data["first_name"]);
                Mage::getModel('core/config')->saveConfig('retailerkittools/shipping_sender/last_name', $data["last_name"]);
                Mage::getModel('core/config')->saveConfig('retailerkittools/shipping_sender/email', $data["email"]);
                Mage::getModel('core/config')->saveConfig('retailerkittools/shipping_sender/address', $data["address"]);
                Mage::getModel('core/config')->saveConfig('retailerkittools/shipping_sender/city', $data["city"]);
                Mage::getModel('core/config')->saveConfig('retailerkittools/shipping_sender/zipcode', $data["zip"]);
                Mage::getModel('core/config')->saveConfig('retailerkittools/shipping_sender/country', $data["country"]);
                Mage::getModel('core/config')->saveConfig('retailerkittools/shipping_sender/state', $data["province"]);
                Mage::getModel('core/config')->saveConfig('retailerkittools/shipping_sender/state_id', $data["province_id"]);
            }
            Mage::getModel('core/config')->cleanCache();
            Mage::getSingleton('core/session')->addSuccess(
                    Mage::helper('retailerkittools')->__('Shipping Sender Information was successfully saved')
                );
        }catch(Exception $e){

        }

        return $this->_redirect('*/*/shippingsender');
        
    }

    public function changevendorAction(){
        $result = array();
        $vendorid = Mage::app()->getRequest()->getParam('vendorid');
        $vendor = Mage::getModel('retailerkittools/vendor')->load($vendorid);
        $result['vendor_name'] = $vendor->getData('vendor_name');
        $result['vendor_email'] = $vendor->getData('vendor_email');
        $result['vendor_phone'] = $vendor->getData('vendor_phone');
        $result['vendor_address'] = $vendor->getData('vendor_address');
        $result['vendor_city'] = $vendor->getData('vendor_city');
        $result['vendor_country'] = $vendor->getData('vendor_country');
        $result['vendor_zipcode'] = $vendor->getData('vendor_zipcode');
        $result['vendor_state'] = $vendor->getData('vendor_state');
        $result['vendor_state_id'] = $vendor->getData('vendor_state_id');
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }

    public function changecurrencyAction(){
        $result = array();
        $currencyCode = Mage::app()->getRequest()->getParam('currency');
        // $currency_symbol = Mage::app()->getLocale()->currency($currencyCode)->getSymbol();
        // Mage::getSingleton('adminhtml/session')->setCurrencySymbol($currency_symbol);
        $url = Mage::helper("adminhtml")->getUrl('adminhtml/retailerkittools_index/invoicegenerator',array('currency'=> $currencyCode));
        $result['url'] = $url;
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }
    public function vendorsAction()
    {
        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setTitle(Mage::helper('retailerkittools')->__('Vendors'));
        $this->renderLayout();
    }

    public function editvendorAction()
    {
        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setTitle(Mage::helper('retailerkittools')->__('Edit Vendor Information'));
        $this->renderLayout();
    }
    public function addvendorAction()
    {
        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setTitle(Mage::helper('retailerkittools')->__('New Vendor'));
        $this->renderLayout();
    }

    public function savevendorAction()
    {
        if ($data = $this->getRequest()->getParams()) {
            $model = Mage::getModel('retailerkittools/vendor');
                $model->setData($data);
                if($this->getRequest()->getParam('vendor_id')){
                    $model->setVendorId($this->getRequest()->getParam('vendor_id'));
                }else{
                    $model->setVendorId();
                }
            try {
                $model->save();
                Mage::getSingleton('core/session')->addSuccess(
                    Mage::helper('retailerkittools')->__('Vendor was successfully saved')
                );
                Mage::getSingleton('core/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                    return;
                }
                $this->_redirect('retailerkittools/index/vendors');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('core/session')->addError($e->getMessage());
                Mage::getSingleton('core/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('core/session')->addError(
            Mage::helper('retailerkittools')->__('Unable to find item to save')
        );
        $this->_redirect('retailerkittools/index/editvendor');
    }

    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('retailerkittools');
    }
}