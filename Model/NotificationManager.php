<?php
/**
 * @author Artem Dekhtyar <m@artemd.ru>
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 */

namespace SymfonyBro\NotificationCoreBundle\Model;


use SymfonyBro\NotificationCore\Model\AbstractNotificationManager;
use SymfonyBro\NotificationCore\Model\DriverInterface;
use SymfonyBro\NotificationCore\Model\FormatterInterface;
use SymfonyBro\NotificationCore\Model\NotificationInterface;

class NotificationManager extends AbstractNotificationManager
{

    protected function createDriver(NotificationInterface $notification): DriverInterface
    {
        // TODO: Implement createDriver() method.
    }

    protected function createFormatter(NotificationInterface $notification): FormatterInterface
    {
        // TODO: Implement createFormatter() method.
    }
}