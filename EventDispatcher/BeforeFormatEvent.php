<?php
/**
 * @author Artem Dekhtyar <m@artemd.ru>
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 */

namespace SymfonyBro\NotificationCoreBundle\EventDispatcher;


use Symfony\Component\EventDispatcher\Event;
use SymfonyBro\NotificationCore\Model\NotificationInterface;

class BeforeFormatEvent extends Event
{
    /**
     * @var NotificationInterface
     */
    private $notification;

    /**
     * BeforeSendEvent constructor.
     * @param NotificationInterface $notification
     */
    public function __construct(NotificationInterface $notification)
    {
        $this->notification = $notification;
    }

    /**
     * @return NotificationInterface
     */
    public function getNotification(): NotificationInterface
    {
        return $this->notification;
    }
}
