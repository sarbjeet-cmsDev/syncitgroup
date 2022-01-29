<?php
namespace Syncitgroup\Sgform\Controller\Adminhtml\Index;

use Magento\Framework\App\Action\HttpGetActionInterface;

/**
 * Index action.
 */
class Index extends \Syncitgroup\Sgform\Controller\Adminhtml\Index implements HttpGetActionInterface
{
    /**
     * Index action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();

        $this->initPage($resultPage)->getConfig()->getTitle()->prepend(__('sgForm'));

        return $resultPage;
    }
}
