<?php

namespace SymfonyBro\NotificationCoreBundle\Driver\Slack;

use SymfonyBro\NotificationCore\Model\AbstractMessage;
use SymfonyBro\NotificationCore\Model\NotificationInterface;

/**
 * Class SlackMessage
 *
 * @package SymfonyBro\NotificationCoreBundle\Driver\Slack
 * @author Artem Dekhtyar <m@artemd.ru>
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 */
class SlackMessage extends AbstractMessage
{

    private $method;

    private $mrkdwn;
    private $token;
    private $channel;
    private $text;
    private $parse;
    private $link_names;
    private $attachments;
    private $unfurl_links;
    private $unfurl_media;
    private $username;
    private $as_user;
    private $icon_url;
    private $icon_emoji;
    private $thread_ts;
    private $reply_broadcast;

    public function __construct(NotificationInterface $notification, $method = 'chat.postMessage')
    {
        parent::__construct($notification);
        $this->method = $method;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     * @return SlackMessage
     */
    public function setMethod(string $method): SlackMessage
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     * @return SlackMessage
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * @param mixed $channel
     * @return SlackMessage
     */
    public function setChannel($channel)
    {
        $this->channel = $channel;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     * @return SlackMessage
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getParse()
    {
        return $this->parse;
    }

    /**
     * @param mixed $parse
     * @return SlackMessage
     */
    public function setParse($parse)
    {
        $this->parse = $parse;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLinkNames()
    {
        return $this->link_names;
    }

    /**
     * @param mixed $link_names
     * @return SlackMessage
     */
    public function setLinkNames($link_names)
    {
        $this->link_names = $link_names;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAttachments()
    {
        return $this->attachments;
    }

    /**
     * @param mixed $attachments
     * @return SlackMessage
     */
    public function setAttachments($attachments)
    {
        $this->attachments = $attachments;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUnfurlLinks()
    {
        return $this->unfurl_links;
    }

    /**
     * @param mixed $unfurl_links
     * @return SlackMessage
     */
    public function setUnfurlLinks($unfurl_links)
    {
        $this->unfurl_links = $unfurl_links;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUnfurlMedia()
    {
        return $this->unfurl_media;
    }

    /**
     * @param mixed $unfurl_media
     * @return SlackMessage
     */
    public function setUnfurlMedia($unfurl_media)
    {
        $this->unfurl_media = $unfurl_media;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     * @return SlackMessage
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAsUser()
    {
        return $this->as_user;
    }

    /**
     * @param mixed $as_user
     * @return SlackMessage
     */
    public function setAsUser($as_user)
    {
        $this->as_user = $as_user;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIconUrl()
    {
        return $this->icon_url;
    }

    /**
     * @param mixed $icon_url
     * @return SlackMessage
     */
    public function setIconUrl($icon_url)
    {
        $this->icon_url = $icon_url;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIconEmoji()
    {
        return $this->icon_emoji;
    }

    /**
     * @param mixed $icon_emoji
     * @return SlackMessage
     */
    public function setIconEmoji($icon_emoji)
    {
        $this->icon_emoji = $icon_emoji;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getThreadTs()
    {
        return $this->thread_ts;
    }

    /**
     * @param mixed $thread_ts
     * @return SlackMessage
     */
    public function setThreadTs($thread_ts)
    {
        $this->thread_ts = $thread_ts;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReplyBroadcast()
    {
        return $this->reply_broadcast;
    }

    /**
     * @param mixed $reply_broadcast
     * @return SlackMessage
     */
    public function setReplyBroadcast($reply_broadcast)
    {
        $this->reply_broadcast = $reply_broadcast;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getMrkdwn()
    {
        return $this->mrkdwn;
    }

    /**
     * @param boolean $mrkdwn
     * @return SlackMessage
     */
    public function setMrkdwn($mrkdwn)
    {
        $this->mrkdwn = $mrkdwn;
        return $this;
    }



    public function build()
    {

    }
}
