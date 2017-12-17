<?php
/**
 * @author Artem Dekhtyar <m@artemd.ru>
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 */

namespace SymfonyBro\NotificationCoreBundle\Model;


use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use SymfonyBro\NotificationCore\Model\AbstractNotificator;
use SymfonyBro\NotificationCore\Model\ContextInterface;
use SymfonyBro\NotificationCore\Model\NotificationBuilderInterface;
use SymfonyBro\NotificationCore\Model\NotificationInterface;
use SymfonyBro\NotificationCore\Model\NotificationManagerInterface;
use SymfonyBro\NotificationCore\Model\RecipientFinderInterface;
use SymfonyBro\NotificationCore\Model\RecipientInterface;
use SymfonyBro\NotificationCore\Model\TemplateFinderInterface;
use SymfonyBro\NotificationCore\Model\TemplateInterface;
use SymfonyBro\NotificationCoreBundle\EventDispatcher\AfterNotifyEvent;
use SymfonyBro\NotificationCoreBundle\EventDispatcher\BeforeNotifyEvent;
use SymfonyBro\NotificationCoreBundle\EventDispatcher\NotificatorEvents;
use Throwable;

class Notificator extends AbstractNotificator
{
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(RecipientFinderInterface $recipientFinder, TemplateFinderInterface $templateFinder, NotificationBuilderInterface $builder, NotificationManagerInterface $manager, EventDispatcherInterface $eventDispatcher, LoggerInterface $logger)
    {
        parent::__construct($recipientFinder, $templateFinder, $builder, $manager);
        $this->logger = $logger;
        $this->eventDispatcher = $eventDispatcher;
    }

    protected function beforeSend(ContextInterface $context, RecipientInterface $recipient, TemplateInterface $template)
    {
        $this->eventDispatcher->dispatch(NotificatorEvents::BEFORE_NOTIFY, new BeforeNotifyEvent($context, $recipient, $template));
    }

    protected function afterNotify(ContextInterface $context, RecipientInterface $recipient, TemplateInterface $template, NotificationInterface $notification)
    {
        $this->eventDispatcher->dispatch(NotificatorEvents::AFTER_NOTIFY, new AfterNotifyEvent($context, $recipient, $template, $notification));
    }

    protected function onNotifyException(Throwable $e, NotificationInterface $notification)
    {
        $this->logger->error($e->getMessage(), [
            'notification_class' => get_class($notification),
        ]);
    }

    protected function onBuildException(Throwable $e, ContextInterface $context, RecipientInterface $recipient, TemplateInterface $template)
    {
        $this->logger->error($e->getMessage(), $context);
    }
}