<?php
/**
 * @author Artem Dekhtyar <m@artemd.ru>
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 */

namespace SymfonyBro\NotificationCoreBundle\Tests\Model;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use SymfonyBro\NotificationCore\Exception\NotificationException;
use SymfonyBro\NotificationCore\Model\FormatterInterface;
use SymfonyBro\NotificationCore\Model\NotificationInterface;
use SymfonyBro\NotificationCoreBundle\Model\FormatterBuilder;

class FormatterBuilderTest extends TestCase
{
    public function testBuild()
    {
        $serviceName = 'test_formatter_service';
        $notification = $this->getMockForAbstractClass(NotificationInterface::class);
        $formatter = $this->getMockForAbstractClass(FormatterInterface::class);

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
            ->willReturn($formatter);

        $builder = new FormatterBuilder($container);

        $builder->registerFormatterService(get_class($notification), $serviceName);
        foreach ($builder->build($notification) as $buildedFormatter) {
            $this->assertEquals($formatter, $buildedFormatter);
        }

    }

    public function testBuildException()
    {
        $notification = $this->getMockForAbstractClass(NotificationInterface::class);
        $class = get_class($notification);
        $container = $this->getMockForAbstractClass(ContainerInterface::class);

        $builder = new FormatterBuilder($container);

        $this->expectException(NotificationException::class);
        $this->expectExceptionMessage("Formatters for '$class' is not registered");
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

        $builder = new FormatterBuilder($container);
        $builder->registerFormatterService($class, $serviceName);

        $this->expectException(NotificationException::class);
        $this->expectExceptionMessage("Formatter service '$serviceName' is not registered in container");
        $builder->build($notification);
    }

}
