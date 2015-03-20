<?php

namespace Detail\VarCrypt\Factory\Listener;

use Zend\ServiceManager\ServiceLocatorInterface;

use Detail\VarCrypt\Listener\MultiEncryptorListener as Listener;

class MultiEncryptorListenerFactory extends BaseEncryptorListenerFactory
{
    protected function createListener(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \Detail\VarCrypt\Options\ModuleOptions $moduleOptions */
        $moduleOptions = $serviceLocator->get('Detail\VarCrypt\Options\ModuleOptions');
        $listenerOptions = $moduleOptions->getMultiEncryptorListener();

        /** @var \Detail\VarCrypt\MultiEncryptor $encryptor */
        $encryptor = $serviceLocator->get('Detail\VarCrypt\MultiEncryptor');

        return new Listener(
            $encryptor,
            $listenerOptions->getVariables(),
            $listenerOptions->getApplyVariables()
        );
    }
}
