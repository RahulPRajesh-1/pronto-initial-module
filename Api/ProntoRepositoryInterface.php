<?php
 
namespace Cda\Pronto\Api;
 
use Magento\Framework\Api\SearchCriteriaInterface;
use Cda\Pronto\Api\Data\ProntoInterface;
use PhpParser\Node\Expr\Cast\String_;

interface ProntoRepositoryInterface
{
    /**
     * @param string $customerFullName
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getTradeAccount($customerFullName);

    /**
     * @param \Cda\Pronto\Api\Data\RetailCustomerInterface $retailCustomerData
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function setRetailAccountPronto($retailCustomerData);


    /**
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getProntoLoginToken();

}