<?php
/**
 * @author Artem Dekhtyar <m@artemd.ru>
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 */

namespace SymfonyBro\NotificationCoreBundle\Model;


use Symfony\Component\DependencyInjection\ContainerInterface;
use SymfonyBro\NotificationCore\Exception\NotificationException;
use SymfonyBro\NotificationCore\Model\FormatterInterface;
use SymfonyBro\NotificationCore\Model\NotificationInterface;

class FormatterBuilder
{
    /**
     * @var ContainerInterface
     */
    private $container;

    private $formatterServices = [];

    /**
     * FormatterBuilder constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $notificationClass
     * @param string $serviceName
     */
    public function registerFormatterService(string $notificationClass, string $serviceName)
    {
        $this->formatterServices[$notificationClass] = $serviceName;
    }

    /**
     * @param NotificationInterface $notification
     * @return FormatterInterface
     * @throws NotificationException
     */
    public function build(NotificationInterface $notification): FormatterInterface
    {
        $key = get_class($notification);

        if (!array_key_exists($key, $this->formatterServices)) {
            throw new NotificationException($notification, "Formatter for '$key' is not registered");
        }

        $formatterService = $this->formatterServices[$key];

        if (!$this->container->has($formatterService)) {
            throw new NotificationException($notification, "Formatter service '$formatterService' is not registered in container");
        }

        /** @var FormatterInterface $formatter */
        $formatter = $this->container->get($formatterService);

        return $formatter;
    }
}
