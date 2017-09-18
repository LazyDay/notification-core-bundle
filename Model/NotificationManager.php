<?php
/**
 * @author Artem Dekhtyar <m@artemd.ru>
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 */

namespace SymfonyBro\NotificationCoreBundle\Model;


use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use SymfonyBro\NotificationCore\Model\AbstractNotificationManager;
use SymfonyBro\NotificationCore\Model\DriverInterface;
use SymfonyBro\NotificationCore\Model\MessageInterface;
use SymfonyBro\NotificationCore\Model\NotificationInterface;
use SymfonyBro\NotificationCoreBundle\EventDispatcher\AfterSendEvent;
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

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * NotificationManager constructor.
     * @param DriverBuilder $driverBuilder
     * @param FormatterBuilder $formatterBuilder
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(DriverBuilder $driverBuilder, FormatterBuilder $formatterBuilder, EventDispatcherInterface $eventDispatcher, LoggerInterface $logger)
    {
        $this->driverBuilder = $driverBuilder;
        $this->formatterBuilder = $formatterBuilder;
        $this->eventDispatcher = $eventDispatcher;
        $this->logger = $logger;
    }

    protected function createDriver(MessageInterface $message): DriverInterface
    {
        return $this->driverBuilder->build($message);
    }

    protected function createFormatters(NotificationInterface $notification): array
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

    protected function afterSend(MessageInterface $message)
    {
        $this->eventDispatcher->dispatch(NotificationEvents::AFTER_SEND, new AfterSendEvent($message));
    }

    protected function onFormatException(NotificationInterface $notification, Exception $exception)
    {
        $this->logger->error("Error on formatting notification: " . $exception->getMessage(), [
            'notification_class' => get_class($notification),
        ]);
    }

    protected function onDriverCreateException(NotificationInterface $notification, MessageInterface $message, Exception $exception)
    {
        $this->logger->error("Error on create driver for message: " . $exception->getMessage(), [
            'notification_class' => get_class($notification),
            'message_class' => get_class($message),
        ]);
    }

    protected function onSendException(NotificationInterface $notification, MessageInterface $message, Exception $exception)
    {
        $this->logger->error("Error on send message: " . $exception->getMessage(), [
            'notification_class' => get_class($notification),
            'message_class' => get_class($message),
        ]);
    }
}
