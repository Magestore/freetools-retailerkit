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
 * @module      RetailerKitTools
 * @author      Magestore Developer
 *
 * @copyright   Copyright (c) 2016 Magestore (http://www.magestore.com/)
 * @license     http://www.magestore.com/license-agreement.html
 *
 */

/**
 * Vendor Resource Model
 *
 * @category    Magestore
 * @package     Magestore_RetailerKitTools
 * @author      Magestore Developer
 */
class Magestore_RetailerKitTools_Model_Mysql4_Order extends Mage_Core_Model_Mysql4_Abstract
{

    public function _construct()
    {
        $this->_init('retailerkittools/order', 'order_id');
    }
}