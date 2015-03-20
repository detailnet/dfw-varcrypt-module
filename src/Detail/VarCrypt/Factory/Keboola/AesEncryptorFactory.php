<?php

namespace Detail\VarCrypt\Factory\Keboola;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Keboola\Encryption\AesEncryptor as Encryptor;

class AesEncryptorFactory implements
    FactoryInterface
{
    /**
     * {@inheritDoc}
     * @return Encryptor
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \Detail\VarCrypt\Options\ModuleOptions $moduleOptions */
        $moduleOptions = $serviceLocator->get('Detail\VarCrypt\Options\ModuleOptions');

        $encryptor = new Encryptor($moduleOptions->getKey());

        return $encryptor;
    }
}
