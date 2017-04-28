<?php
/**
 * @author Artem Dekhtyar <m@artemd.ru>
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 */

namespace SymfonyBro\NotificationCoreBundle\Driver\Slack;

use SymfonyBro\NotificationCore\Exception\NotificationException;
use SymfonyBro\NotificationCore\Model\DriverInterface;
use SymfonyBro\NotificationCore\Model\MessageInterface;

/**
 * Class SlackDriver
 *
 * @author Artem Dekhtyar <m@artemd.ru>
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 */
class SlackDriver implements DriverInterface
{
    /**
     * @var SlackClient
     */
    private $client;

    public function __construct(SlackClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param MessageInterface $message
     * @return void
     * @throws \SymfonyBro\NotificationCore\Exception\NotificationException
     */
    public function send(MessageInterface $message)
    {
        try {
            $this->doSend($message);
        } catch (\Exception $exception) {
            throw new NotificationException($message->getNotification(), $exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    private function doSend(SlackMessage $message)
    {
        $this->client->call($message->getMethod(), $message->build());
    }
}
