<?php

namespace SymfonyBro\NotificationCoreBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use SymfonyBro\NotificationCoreBundle\DependencyInjection\Compiler\RegisterDriverPass;
use SymfonyBro\NotificationCoreBundle\DependencyInjection\Compiler\RegisterFormatterPass;

class SymfonyBroNotificationCoreBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new RegisterDriverPass());
        $container->addCompilerPass(new RegisterFormatterPass());
    }
}
