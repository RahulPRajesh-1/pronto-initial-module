<?php
 
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */


 
namespace Cda\Pronto\Api\Data;

/**
 * @api
 * @since 100.0.2
 */
 
interface RetailCustomerInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{
 
    const CUSTOMER_NAME  = 'CustomerName ';
    const BILL_TO_NAME = 'BillToName ';
    
    
    /**
     * Get id
     * first name of the customer
     * @return string|null
     */
    public function getCustomerName();
 
    /**
     * Set id
     * @param string $customerName
     * @return string
     */
    public function setCustomerName($customerName);

    /**
     * Get id
     * last name of the customer
     * @return string|null
     */
    public function getBillToName();
 
    /**
     * Set id
     * @param string $billToName
     * @return string
     */
    public function setBillToName($billToName);

}