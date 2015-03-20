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
        /** @var \Zend\ModuleManager\ModuleManager $moduleManager */
        $moduleManager = $serviceLocator->get('ModuleManager');
        /** @var \Detail\VarCrypt\Module $module */
        $module = $moduleManager->getModule('Detail\VarCrypt');

        if ($module === null) {
            throw new ConfigException('Module Detail\VarCrypt is not loaded');
        }

        $config = $module->getConfig();

        if (!isset($config['detail_varcrypt'])) {
            throw new ConfigException('Config for Detail\VarCrypt is not set');
        }

        $moduleOptions = new ModuleOptions($config['detail_varcrypt']);

        if (!$moduleOptions->getKey()) {
            throw new ConfigException('Missing required config option "key" for module Detail\VarCrypt');
        }

        return $moduleOptions;
    }
}
