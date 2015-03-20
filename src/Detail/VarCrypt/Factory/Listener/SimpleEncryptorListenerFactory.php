<?php

namespace Detail\VarCrypt\Factory\Listener;

use Zend\ServiceManager\ServiceLocatorInterface;

use Detail\VarCrypt\Listener\SimpleEncryptorListener as Listener;

class SimpleEncryptorListenerFactory extends BaseEncryptorListenerFactory
{
    protected function createListener(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \Detail\VarCrypt\SimpleEncryptor $encryptor */
        $encryptor = $serviceLocator->get('Detail\VarCrypt\SimpleEncryptor');

        return new Listener($encryptor);
    }
}
