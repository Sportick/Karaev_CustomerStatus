<?php

declare(strict_types=1);

namespace Karaev\CustomerStatus\Controller\Status;

use Magento\Framework\View\Result\Page;
use Magento\Framework\Controller\ResultFactory;
use Magento\Review\Controller\Customer as CustomerController;
use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;

/**
 * Class Index
 * @package Karaev\CustomerTrigger\Controller\Trigger
 */
class Index extends CustomerController implements HttpGetActionInterface
{
    /**
     * @return Page
     */
    public function execute()
    {
        $this->_view->loadLayout();

        /** @var Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        if ($navigationBlock = $resultPage->getLayout()->getBlock('customer-account-navigation-trigger-link')) {
            $navigationBlock->setActive('karaev/status');
        }

        $this->_view->getPage()->getConfig()->getTitle()->set(__('Status Customer'));

        return $resultPage;
    }
}
