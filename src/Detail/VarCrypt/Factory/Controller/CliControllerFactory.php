<?php

namespace Detail\VarCrypt\Factory\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Detail\VarCrypt\Exception;
use Detail\VarCrypt\Controller\CliController as Controller;

class CliControllerFactory implements
    FactoryInterface
{
    /**
     * {@inheritDoc}
     * @return Controller
     */
    public function createService(ServiceLocatorInterface $controllerManager)
    {
        /** @var \Zend\Mvc\Controller\ControllerManager $controllerManager */

        $serviceLocator = $controllerManager->getServiceLocator();

//        /** @var \Detail\VarCrypt\Options\ModuleOptions $moduleOptions */
//        $moduleOptions = $serviceLocator->get('Detail\VarCrypt\Options\ModuleOptions');

        /** @var \Detail\VarCrypt\SimpleEncryptor $encryptor */
        $encryptor = $serviceLocator->get('Detail\VarCrypt\SimpleEncryptor');

        $controller = new Controller($encryptor);

        return $controller;
    }
}
