<?php

namespace SymfonyBro\NotificationCoreBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use SymfonyBro\NotificationCoreBundle\DependencyInjection\Compiler\RegisterDriverPass;

class SymfonyBroNotificationCoreBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new RegisterDriverPass());
    }
}
