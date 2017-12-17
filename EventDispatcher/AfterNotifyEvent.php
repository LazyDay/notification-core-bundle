<?php
/**
 * @author Artem Dekhtyar <m@artemd.ru>
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 */

namespace SymfonyBro\NotificationCoreBundle\EventDispatcher;


use Symfony\Component\EventDispatcher\Event;
use SymfonyBro\NotificationCore\Model\ContextInterface;
use SymfonyBro\NotificationCore\Model\NotificationInterface;
use SymfonyBro\NotificationCore\Model\RecipientInterface;
use SymfonyBro\NotificationCore\Model\TemplateInterface;

class AfterNotifyEvent extends Event
{
    /**
     * @var ContextInterface
     */
    private $context;
    /**
     * @var RecipientInterface
     */
    private $recipient;
    /**
     * @var TemplateInterface
     */
    private $template;
    /**
     * @var NotificationInterface
     */
    private $notification;

    public function __construct(ContextInterface $context, RecipientInterface $recipient, TemplateInterface $template, NotificationInterface $notification)
    {
        $this->context = $context;
        $this->recipient = $recipient;
        $this->template = $template;
        $this->notification = $notification;
    }

    /**
     * @return ContextInterface
     */
    public function getContext(): ContextInterface
    {
        return $this->context;
    }

    /**
     * @return RecipientInterface
     */
    public function getRecipient(): RecipientInterface
    {
        return $this->recipient;
    }

    /**
     * @return TemplateInterface
     */
    public function getTemplate(): TemplateInterface
    {
        return $this->template;
    }

    /**
     * @return NotificationInterface
     */
    public function getNotification(): NotificationInterface
    {
        return $this->notification;
    }

}