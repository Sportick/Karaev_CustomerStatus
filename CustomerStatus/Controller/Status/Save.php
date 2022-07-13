<?php

declare(strict_types=1);

namespace Karaev\CustomerStatus\Controller\Status;

use Exception;
use Magento\Framework\App\Action\Action;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Data\Form\FormKey\Validator as FormKeyValidator;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Karaev\CustomerStatus\Api\CustomerStatusDataInterface;

/**
 * Class Save
 * @package Karaev\CustomerStatus\Controller\Status
 */
class Save extends Action
{
    private Session $customerSession;
    private FormKeyValidator $formKeyValidator;
    private CustomerRepositoryInterface $customerRepository;

    /**
     * @param Context $context
     * @param Session $customerSession
     * @param FormKeyValidator $formKeyValidator
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct(
        Context $context,
        Session $customerSession,
        FormKeyValidator $formKeyValidator,
        CustomerRepositoryInterface $customerRepository
    ) {
        parent::__construct($context);

        $this->customerSession = $customerSession;
        $this->formKeyValidator = $formKeyValidator;
        $this->customerRepository = $customerRepository;
    }

    /**
     * @return ResponseInterface|Redirect|ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        if (!$this->formKeyValidator->validate($this->getRequest()) || !$this->getRequest()->isPost()) {
            return $resultRedirect->setPath('*/*/');
        }

        try {
            $customerId = $this->customerSession->getCustomerId();

            if ($customerId) {
                $status = $this->getRequest()->getParam(CustomerStatusDataInterface::STATUS);

                $customer = $this->customerRepository->getById($customerId);
                $extensionAttributes = $customer->getExtensionAttributes();
                $extensionAttributes->setStatus($status);
                $customer->setExtensionAttributes($extensionAttributes);

                $this->customerRepository->save($customer);

                $this->messageManager->addSuccessMessage(__('Client status changed successfully!'));
            }
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        return $resultRedirect->setPath('karaev/status');
    }
}
