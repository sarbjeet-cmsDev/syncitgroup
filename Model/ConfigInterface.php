<?php
namespace Syncitgroup\Sgform\Model;

/**
 * Sgform module configuration
 */
interface ConfigInterface
{
    /**
     * Recipient email config path
     */
    const XML_PATH_EMAIL_RECIPIENT = 'sgform/general/recipient';
    
    /**
     * Email template config path
     */
    const XML_PATH_EMAIL_TEMPLATE = 'sgform/general/template';

    /**
     * Enabled config path
     */
    const XML_PATH_ENABLED = 'sgform/general/enabled';

    /**
     * Check if module is enabled
     */
    public function isEnabled();

    /**
     * Return email template identifier
     */
    public function emailTemplate();

    /**
     * Return email recipient address
     */
    public function emailRecipient();
}
