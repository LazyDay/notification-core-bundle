<?php
/**
 * @author Artem Dekhtyar <m@artemd.ru>
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 */

namespace SymfonyBro\NotificationCoreBundle\EventDispatcher;


final class NotificatorEvents
{
    const BEFORE_NOTIFY = 'symfony_bro.notification_core.before_notify';
    const AFTER_NOTIFY = 'symfony_bro.notification_core.after_notify';
}