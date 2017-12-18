<?php
/**
 * @author Artem Dekhtyar <m@artemd.ru>
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 */

namespace SymfonyBro\NotificationCoreBundle\Model;

use InvalidArgumentException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use SymfonyBro\NotificationCore\Exception\NotificationException;
use SymfonyBro\NotificationCore\Model\DriverInterface;
use SymfonyBro\NotificationCore\Model\MessageInterface;

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
     * @param string $messageClass
     * @param string $serviceName
     */
    public function registerDriverService(string $messageClass, string $serviceName)
    {
        $this->driverServices[$messageClass] = $serviceName;
    }

    /**
     * @param MessageInterface $message
     * @return DriverInterface
     * @throws NotificationException
     */
    public function build(MessageInterface $message): DriverInterface
    {
        $key = get_class($message);

        if (!array_key_exists($key, $this->driverServices)) {
            throw new InvalidArgumentException("Driver for '$key' is not registered");
        }

        $driverService = $this->driverServices[$key];

        if (!$this->container->has($driverService)) {
            throw new InvalidArgumentException("Driver service '$driverService' is not registered in container");
        }

        /** @var DriverInterface $driver */
        $driver = $this->container->get($driverService);

        return $driver;
    }
}
