<?php
/**
 * @author Artem Dekhtyar <m@artemd.ru>
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 */

namespace SymfonyBro\NotificationCoreBundle\Tests\Model;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use SymfonyBro\NotificationCore\Exception\NotificationException;
use SymfonyBro\NotificationCore\Model\DriverInterface;
use SymfonyBro\NotificationCore\Model\NotificationInterface;
use SymfonyBro\NotificationCoreBundle\Model\DriverBuilder;

class DriverBuilderTest extends TestCase
{
    public function testBuild()
    {
        $serviceName = 'test_driver_service';
        $notification = $this->getMockForAbstractClass(NotificationInterface::class);
        $driver = $this->getMockForAbstractClass(DriverInterface::class);

        $container = $this->getMockForAbstractClass(ContainerInterface::class);

        $container
            ->expects($this->once())
            ->method('has')
            ->with($serviceName)
            ->willReturn(true);

        $container
            ->expects($this->exactly(1))
            ->method('get')
            ->with($serviceName)
            ->willReturn($driver);

        $builder = new DriverBuilder($container);

        $builder->registerDriverService(get_class($notification), $serviceName);

        $this->assertEquals($driver,$builder->build($notification));
    }

    public function testBuildException()
    {
        $notification = $this->getMockForAbstractClass(NotificationInterface::class);
        $class = get_class($notification);
        $container = $this->getMockForAbstractClass(ContainerInterface::class);

        $builder = new DriverBuilder($container);

        $this->expectException(NotificationException::class);
        $this->expectExceptionMessage("Driver for '$class' is not registered");
        $builder->build($notification);
    }

    public function testBuildException2()
    {
        $serviceName = 'test_driver_service';
        $notification = $this->getMockForAbstractClass(NotificationInterface::class);
        $class = get_class($notification);
        $container = $this->getMockForAbstractClass(ContainerInterface::class);

        $container
            ->expects($this->once())
            ->method('has')
            ->with($serviceName)
            ->willReturn(false);

        $builder = new DriverBuilder($container);
        $builder->registerDriverService($class, $serviceName);

        $this->expectException(NotificationException::class);
        $this->expectExceptionMessage("Driver service '$serviceName' is not registered in container");
        $builder->build($notification);
    }

}
