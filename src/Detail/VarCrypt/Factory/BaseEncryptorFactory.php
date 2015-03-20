<?php

namespace Detail\VarCrypt\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Keboola\Encryption;

//use Detail\VarCrypt\Exception\ConfigException;

abstract class BaseEncryptorFactory implements
    FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \Detail\VarCrypt\Options\ModuleOptions $moduleOptions */
        $moduleOptions = $serviceLocator->get('Detail\VarCrypt\Options\ModuleOptions');

        /** @var \Keboola\Encryption\EncryptorInterface $encryptor */
        $encryptor = $serviceLocator->get($moduleOptions->getEncryptor());

        return $this->createEncryptor($serviceLocator, $encryptor);
    }

    abstract protected function createEncryptor(
        ServiceLocatorInterface $serviceLocator,
        Encryption\EncryptorInterface $encryptor
    );
}
