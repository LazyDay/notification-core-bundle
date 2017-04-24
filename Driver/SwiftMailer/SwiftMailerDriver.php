<?php
/**
 * @author Artem Dekhtyar <m@artemd.ru>
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 */

namespace SymfonyBro\NotificationCoreBundle\Driver\SwiftMailer;

use SymfonyBro\NotificationCore\Exception\NotificationException;
use SymfonyBro\NotificationCore\Model\DriverInterface;
use SymfonyBro\NotificationCore\Model\MessageInterface;

class SwiftMailerDriver implements DriverInterface
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * SwiftMailerDriver constructor.
     * @param \Swift_Mailer $mailer
     */
    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param MessageInterface $message
     * @return void
     * @throws NotificationException
     */
    public function send(MessageInterface $message)
    {
        try {
            $this->doSend($message);
        } catch (\Exception $exception) {
            throw new NotificationException($message->getNotification(), $exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    private function doSend(SwiftMailerMessage $message)
    {
        $this->mailer->send($message->getSwiftMessage());
    }
}