<?php
namespace SymfonyBro\NotificationCoreBundle\EventDispatcher;

use Symfony\Component\EventDispatcher\Event;
use SymfonyBro\NotificationCore\Model\MessageInterface;

class AfterSendEvent extends Event
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