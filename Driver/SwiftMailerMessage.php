<?php
/**
 * @author Artem Dekhtyar <m@artemd.ru>
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 */

namespace SymfonyBro\NotificationCoreBundle\Driver;


use SymfonyBro\NotificationCore\Model\AbstractMessage;
use SymfonyBro\NotificationCore\Model\MessageInterface;
use SymfonyBro\NotificationCore\Model\NotificationInterface;

class SwiftMailerMessage extends AbstractMessage
{
    /**
     * @var \Swift_Message
     */
    private $swiftMessage;

    public function __construct(NotificationInterface $notification, MessageInterface $swiftMessage)
    {
        parent::__construct($notification);
        $this->swiftMessage = $swiftMessage;
    }

    /**
     * @return \Swift_Message
     */
    public function getSwiftMessage(): \Swift_Message
    {
        return $this->swiftMessage;
    }
}
