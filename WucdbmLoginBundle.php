<?php

namespace Wucdbm\Bundle\LoginBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Wucdbm\Bundle\LoginBundle\DependencyInjection\Compiler\InjectRememberMeServicesPass;

class WucdbmLoginBundle extends Bundle {

    public function build(ContainerBuilder $container) {
        parent::build($container);

        $container->addCompilerPass(new InjectRememberMeServicesPass());
    }

}