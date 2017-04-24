<?php
/**
 * @author Artem Dekhtyar <m@artemd.ru>
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 */

namespace SymfonyBro\NotificationCoreBundle\Model;


use Symfony\Component\DependencyInjection\ContainerInterface;
use SymfonyBro\NotificationCore\Exception\NotificationException;
use SymfonyBro\NotificationCore\Model\DriverInterface;
use SymfonyBro\NotificationCore\Model\NotificationInterface;

class DriverBuilder
{
    /**
     * @var ContainerInterface
     */
    private $container;

    private $driverServices = [];

    /**
     * DriverBuilder constructor.
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
    public function registerDriverService(string $notificationClass, string $serviceName)
    {
        $this->driverServices[$notificationClass] = $serviceName;
    }

    /**
     * @param NotificationInterface $notification
     * @return DriverInterface
     * @throws NotificationException
     */
    public function build(NotificationInterface $notification): DriverInterface
    {
        $key = get_class($notification);

        if (!array_key_exists($key, $this->driverServices)) {
            throw new NotificationException($notification, "Driver for '$key' is not registered");
        }

        $driverService = $this->driverServices[$key];

        if (!$this->container->has($driverService)) {
            throw new NotificationException($notification, "Driver service '$driverService' is not registered in container");
        }

        /** @var DriverInterface $driver */
        $driver = $this->container->get($driverService);

        return $driver;
    }
}
