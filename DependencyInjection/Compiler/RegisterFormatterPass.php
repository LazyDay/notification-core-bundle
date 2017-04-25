<?php
/**
 * @author Artem Dekhtyar <m@artemd.ru>
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 */

namespace SymfonyBro\NotificationCoreBundle\DependencyInjection\Compiler;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class RegisterFormatterPass implements CompilerPassInterface
{
    private $tag = 'symfony-bro.notification.formatter';

    private $builderId = 'symfony_bro.notification_core.formatter_builder';

    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition($this->builderId)) {
            return;
        }

        $builder = $container->findDefinition($this->builderId);

        $drivers = $container->findTaggedServiceIds($this->tag);

        foreach ($drivers as $id => $tags) {
            foreach ($tags as $attributes) {
                if (!isset($attributes['notification'])) {
                    throw new LogicException("'notification' is required attribute for tag $this->tag");
                }
                $builder->addMethodCall('registerFormatterService', [$attributes['notification'], $id]);
            }
        }

    }
}