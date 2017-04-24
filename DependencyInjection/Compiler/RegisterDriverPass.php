<?php

namespace SymfonyBro\NotificationCoreBundle\DependencyInjection\Compiler;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\LogicException;

/**
 * @author Artem Dekhtyar <m@artemd.ru>
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 */
class RegisterDriverPass implements CompilerPassInterface
{

    private $driverTag = 'symfony-bro.notification.driver';

    private $driverBuilderId = 'symfony_bro.notification_core.driver_builder';

    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition($this->driverBuilderId)) {
            return;
        }

        $builder = $container->findDefinition($this->driverBuilderId);

        $drivers = $container->findTaggedServiceIds($this->driverTag);

        foreach ($drivers as $id => $tags) {
            foreach ($tags as $attributes) {
                if (!isset($attributes['notification'])) {
                    throw new LogicException("'notification' is required attribute for tag $this->driverTag");
                }
                $builder->addMethodCall('registerDriverService', [$attributes['notification'], $id]);
            }
        }
    }
}