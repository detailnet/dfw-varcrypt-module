<?php

namespace Detail\VarCrypt\Factory\Listener;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

//use Detail\VarCrypt\Exception\ConfigException;

abstract class BaseEncryptorListenerFactory implements
    FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
//        /** @var \Detail\VarCrypt\Options\ModuleOptions $moduleOptions */
//        $moduleOptions = $serviceLocator->get('Detail\VarCrypt\Options\ModuleOptions');

        return $this->createListener($serviceLocator);
    }

    abstract protected function createListener(ServiceLocatorInterface $serviceLocator);
}
