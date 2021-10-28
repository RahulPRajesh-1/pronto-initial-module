<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Cda\Pronto\Model\Data;

use Cda\Pronto\Api\Data\RetailCustomerInterface;

class RetailCustomer extends \Magento\Framework\Api\AbstractExtensibleObject implements RetailCustomerInterface
{

    /**
     * Get id
     * @return string|null
     */
    public function getCustomerName()
    {
        return $this->_get(self::CUSTOMER_NAME);
    }

    /**
     * Set product_id
     * @param string $customerName
     * @return \Cda\Pronto\Api\Data\RetailCustomerInterface
     */
    public function setCustomerName($customerName)
    {
        return $this->setData(self::BILL_TO_NAME, $customerName);
    }


    /**
     * Get id
     * @return string|null
     */
    public function getBillToName()
    {
        return $this->_get(self::CUSTOMER_NAME);
    }

    /**
     * Set product_id
     * @param string $billToName
     * @return \Cda\Pronto\Api\Data\RetailCustomerInterface
     */
    public function setBillToName($billToName)
    {
        return $this->setData(self::BILL_TO_NAME, $billToName);
    }

}