<?php

namespace Wucdbm\Bundle\LoginBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class InjectRememberMeServicesPass implements CompilerPassInterface {

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container) {
        foreach ($container->getParameter('wucdbm_login_manager.config')['managers'] as $name => $config) {
            $managerDefinition = new ChildDefinition('wucdbm_login.manager.abstract');
            $managerDefinition->setClass($config['class']);
            $managerDefinition->replaceArgument(5, $config);
            $managerDefinition->setPublic(true);

            $firewallName = $config['firewall_name'];

            if ($config['remember_me']) {
                if ($container->hasDefinition('security.authentication.rememberme.services.persistent.' . $firewallName)) {
                    $managerDefinition->addMethodCall('setRememberMeService', [new Reference('security.authentication.rememberme.services.persistent.' . $firewallName)]);
                } elseif ($container->hasDefinition('security.authentication.rememberme.services.simplehash.' . $firewallName)) {
                    $managerDefinition->addMethodCall('setRememberMeService', [new Reference('security.authentication.rememberme.services.simplehash.' . $firewallName)]);
                }
            }

            if ($config['hwi_oauth']['enabled']) {
                $managerDefinition->addMethodCall('setHwiOAuthResourceOwnerMap', [new Reference(sprintf('hwi_oauth.resource_ownermap.%s', $firewallName))]);
                $managerDefinition->addMethodCall('setHwiOauthUserProvider', [new Reference($config['hwi_oauth']['user_provider'])]);
            }

            $managerId = sprintf('wucdbm_login.manager.%s', $name);
            $container->setDefinition($managerId, $managerDefinition);
        }
    }

}