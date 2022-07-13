<?php

declare(strict_types=1);

namespace Karaev\CustomerStatus\Block;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Customer\Api\CustomerRepositoryInterface;

/**
 * Class CustomerStatus
 * @package Karaev\CustomerStatus\Block
 */
class CustomerStatus extends Template
{
    /**
     * @var string
     */
    protected $_template = 'Karaev_CustomerStatus::form/customer_status.phtml';

    protected Session $customerSession;

    protected CustomerRepositoryInterface $customerRepository;

    /**
     * @param Template\Context $context
     * @param Session $customerSession
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        Session $customerSession,
        CustomerRepositoryInterface $customerRepository,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->customerSession = $customerSession;
        $this->customerRepository = $customerRepository;
    }

    /**
     * @return int
     */
    public function getDataStatus(): int
    {
        return (int)$this->customerSession->getCustomer()->getStatus();
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->getUrl('karaev/status/save');
    }
}
