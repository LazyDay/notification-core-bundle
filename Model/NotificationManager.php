<?php
/**
 * @author Artem Dekhtyar <m@artemd.ru>
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 */

namespace SymfonyBro\NotificationCoreBundle\Model;


use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use SymfonyBro\NotificationCore\Model\AbstractNotificationManager;
use SymfonyBro\NotificationCore\Model\DriverInterface;
use SymfonyBro\NotificationCore\Model\FormatterInterface;
use SymfonyBro\NotificationCore\Model\MessageInterface;
use SymfonyBro\NotificationCore\Model\NotificationInterface;
use SymfonyBro\NotificationCoreBundle\EventDispatcher\BeforeFormatEvent;
use SymfonyBro\NotificationCoreBundle\EventDispatcher\BeforeSendEvent;
use SymfonyBro\NotificationCoreBundle\EventDispatcher\NotificationEvents;

class NotificationManager extends AbstractNotificationManager
{
    /**
     * @var DriverBuilder
     */
    private $driverBuilder;

    /**
     * @var FormatterBuilder
     */
    private $formatterBuilder;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    protected function createDriver(NotificationInterface $notification): DriverInterface
    {
        return $this->driverBuilder->build($notification);
    }

    protected function createFormatter(NotificationInterface $notification): FormatterInterface
    {
        return $this->formatterBuilder->build($notification);
    }

    protected function beforeFormat(NotificationInterface $notification)
    {
        $this->eventDispatcher->dispatch(NotificationEvents::BEFORE_FORMAT, new BeforeFormatEvent($notification));
    }

    protected function beforeSend(MessageInterface $message)
    {
        $this->eventDispatcher->dispatch(NotificationEvents::BEFORE_SEND, new BeforeSendEvent($message));
    }
}
