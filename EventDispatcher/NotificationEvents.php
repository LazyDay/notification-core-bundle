<?php
/**
 * @author Artem Dekhtyar <m@artemd.ru>
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 */

namespace SymfonyBro\NotificationCoreBundle\EventDispatcher;

final class NotificationEvents
{
    const BEFORE_FORMAT = 'symfony_bro.notification_core.before_format';
    const BEFORE_SEND = 'symfony_bro.notification_core.before_send';
}