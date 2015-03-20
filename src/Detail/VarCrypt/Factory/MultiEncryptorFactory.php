<?php

namespace Detail\VarCrypt\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;

use Keboola\Encryption;

use Detail\VarCrypt\MultiEncryptor as Encryptor;

class MultiEncryptorFactory extends BaseEncryptorFactory
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @param Encryption\EncryptorInterface $encryptor
     * @return Encryptor
     */
    protected function createEncryptor(
        ServiceLocatorInterface $serviceLocator,
        Encryption\EncryptorInterface $encryptor
    ) {
        return new Encryptor($encryptor);
    }
}
