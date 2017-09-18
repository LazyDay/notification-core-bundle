<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 9/16/17
 * Time: 5:24 PM
 */

namespace SymfonyBro\NotificationCoreBundle\EventDispatcher;


use SymfonyBro\NotificationCore\Model\MessageInterface;

class AfterSendEvent
{
    /**
     * @var MessageInterface
     */
    private $message;

    /**
     * BeforeSendEvent constructor.
     * @param MessageInterface $message
     */
    public function __construct(MessageInterface $message)
    {
        $this->message = $message;
    }

    /**
     * @return MessageInterface
     */
    public function getMessage(): MessageInterface
    {
        return $this->message;
    }
}