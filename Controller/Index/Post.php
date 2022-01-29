<?php

namespace Syncitgroup\Sgform\Controller\Index;

use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Syncitgroup\Sgform\Model\ConfigInterface;
use Syncitgroup\Sgform\Model\MailInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\DataObject;
use Syncitgroup\Sgform\Model\FormFactory;
use Magento\Framework\Event\ManagerInterface;

class Post extends \Syncitgroup\Sgform\Controller\Index implements HttpPostActionInterface
{
    /**
     * @var Context
     */
    private $context;

    /**
     * @var MailInterface
     */
    private $mail;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var FormFactory
     */
    private $formFactory;

    /**
     * @var ManagerInterface
     */
    protected $eventManager;

    /**
     * @param Context $context
     * @param ConfigInterface $config
     * @param MailInterface $mail
     * @param FormFactory $formFactory
     * @param LoggerInterface $logger
     * @param ManagerInterface $eventManager
     */
    public function __construct(
        Context $context,
        ConfigInterface $config,
        MailInterface $mail,
        FormFactory $formFactory,
        LoggerInterface $logger,
        ManagerInterface $eventManager
    ) {
        parent::__construct($context, $config);
        $this->context = $context;
        $this->mail = $mail;
        $this->logger = $logger;
        $this->formFactory = $formFactory;
        $this->eventManager = $eventManager;
    }

    /**
     * Post user question
     *
     * @return Redirect
     */
    public function execute()
    {
        if (!$this->getRequest()->isPost()) {
            return $this->resultRedirectFactory->create()->setPath('*/*/');
        }
        try {
            $data = $this->validatedParams();
            //Save sgform
            $form = $this->formFactory->create();
            $form->setEmail($data['email'])
                ->setName($data['name'])
                ->setPhone($data['phone'])
                ->setComment($data['comment'])
                ->save();

            $this->sendEmail($data);

            $this->eventManager->dispatch(
                'sgform_submit_after',
                [
                    'data' => $data
                ]
            );

            $this->messageManager->addSuccessMessage(
                __('Thank you for submitting to Syncit Group custom form!.')
            );
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->logger->critical($e);
            $this->messageManager->addErrorMessage(
                __('An error occurred while processing your form. Please try again later.')
            );
        }
        return $this->resultRedirectFactory->create()->setPath('syncit-group-form/index');
    }

    /**
     * @param array $post Post data from form
     * @return void
     */
    private function sendEmail($post)
    {
        $this->mail->send(
            $post['email'],
            ['data' => new DataObject($post)]
        );
    }

    /**
     * @return array
     * @throws \Exception
     */
    private function validatedParams()
    {
        $request = $this->getRequest();
        if (trim($request->getParam('name')) === '') {
            throw new LocalizedException(__('Enter the Name and try again.'));
        }
        if (trim($request->getParam('phone')) === '') {
            throw new LocalizedException(__('Enter the phone and try again.'));
        }
        if (trim($request->getParam('comment')) === '') {
            throw new LocalizedException(__('Enter the comment and try again.'));
        }
        if (false === \strpos($request->getParam('email'), '@')) {
            throw new LocalizedException(__('The email address is invalid. Verify the email address and try again.'));
        }

        return $request->getParams();
    }
}
