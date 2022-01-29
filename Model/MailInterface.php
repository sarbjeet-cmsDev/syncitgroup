<?php
namespace Syncitgroup\Sgform\Model;

/**
 * Email from sgform
 */
interface MailInterface
{
    /**
     * Send email from sgform
     *
     * @param string $replyTo Reply-to email address
     * @param array $variables Email template variables
     * @return void
     */
    public function send($replyTo, array $variables);
}
