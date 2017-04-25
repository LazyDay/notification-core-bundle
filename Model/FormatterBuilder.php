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
        if (isset($this->formatterServices[$notificationClass])) {
            $services = &$this->formatterServices[$notificationClass];
            if (!in_array($serviceName, $services)) {
                $services[] = $serviceName;
            }
        } else {
            $this->formatterServices[$notificationClass] = [$serviceName];
        }
    }

    /**
     * @param NotificationInterface $notification
     * @return FormatterInterface[]
     * @throws NotificationException
     */
    public function build(NotificationInterface $notification): array
    {
        $key = get_class($notification);

        if (!array_key_exists($key, $this->formatterServices)) {
            throw new NotificationException($notification, "Formatters for '$key' is not registered");
        }

        $formatterServices = $this->formatterServices[$key];

        $formatters = [];
        foreach ($formatterServices as $formatterService) {
            if (!$this->container->has($formatterService)) {
                throw new NotificationException($notification, "Formatter service '$formatterService' is not registered in container");
            }

            $formatters[] = $this->container->get($formatterService);
        }

        return $formatters;
    }
}
