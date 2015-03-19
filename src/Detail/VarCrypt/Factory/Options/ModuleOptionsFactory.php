<?php

namespace Detail\VarCrypt\Factory\Options;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Detail\VarCrypt\Exception\ConfigException;
use Detail\VarCrypt\Options\ModuleOptions;

class ModuleOptionsFactory implements
    FactoryInterface
{
    /**
     * {@inheritDoc}
     * @return ModuleOptions
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');

        if (!isset($config['detail_varcrypt'])) {
            throw new ConfigException('Config for Detail\VarCrypt is not set');
        }

        return new ModuleOptions($config['detail_varcrypt']);
    }
}
