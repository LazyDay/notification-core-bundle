<?php
/**
 * @author Artem Dekhtyar <m@artemd.ru>
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 */

namespace SymfonyBro\NotificationCoreBundle\Tests\Model;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use SymfonyBro\NotificationCore\Model\DriverInterface;
use SymfonyBro\NotificationCore\Model\MessageInterface;
use SymfonyBro\NotificationCoreBundle\Model\DriverBuilder;

class DriverBuilderTest extends TestCase
{
    public function testBuild()
    {
        $serviceName = 'test_driver_service';
        $message = $this->getMockForAbstractClass(MessageInterface::class);
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

        $builder->registerDriverService(get_class($message), $serviceName);

        $this->assertEquals($driver,$builder->build($message));
    }

    public function testBuildException()
    {
        $message = $this->getMockForAbstractClass(MessageInterface::class);
        $class = get_class($message);
        $container = $this->getMockForAbstractClass(ContainerInterface::class);

        $builder = new DriverBuilder($container);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Driver for '$class' is not registered");
        $builder->build($message);
    }

    public function testBuildException2()
    {
        $serviceName = 'test_driver_service';
        $message = $this->getMockForAbstractClass(MessageInterface::class);
        $class = get_class($message);
        $container = $this->getMockForAbstractClass(ContainerInterface::class);

        $container
            ->expects($this->once())
            ->method('has')
            ->with($serviceName)
            ->willReturn(false);

        $builder = new DriverBuilder($container);
        $builder->registerDriverService($class, $serviceName);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Driver service '$serviceName' is not registered in container");
        $builder->build($message);
    }

}
