<?php

declare(strict_types=1);

namespace Karaev\CustomerStatus\Plugin\CustomerData;

use Magento\Customer\Model\Session;
use Magento\Customer\CustomerData\Customer;
use Karaev\CustomerStatus\Api\CustomerStatusDataInterface;

/**
 * Class CustomerPlugin
 * @package Karaev\CustomerStatus\Plugin\CustomerData
 */
class CustomerPlugin
{
    protected Session $customerSession;

    /**
     * @param Session $customerSession
     */
    public function __construct(Session $customerSession)
    {
        $this->customerSession = $customerSession;
    }

    /**
     * @param Customer $subject
     * @param $result
     * @return array
     */
    public function afterGetSectionData(Customer $subject, $result): array
    {
        $result[CustomerStatusDataInterface::STATUS] = $this->getCustomerStatus();

        return $result;
    }

    /**
     * @return string
     */
    public function getCustomerStatus(): string
    {
        $status = $this->customerSession->getCustomer()->getStatus();

        return (int)$status === CustomerStatusDataInterface::VALUE_STATUS_ENABLE ?
            CustomerStatusDataInterface::LABEL_STATUS_ENABLE :
            CustomerStatusDataInterface::LABEL_STATUS_DISABLE;
    }
}
