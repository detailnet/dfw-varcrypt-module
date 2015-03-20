<?php

namespace Detail\VarCrypt\Factory\ModuleManager;

use Zend\ModuleManager\ModuleEvent;
//use Zend\ModuleManager\ModuleManager;
use Zend\ServiceManager\DelegatorFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManager;

class ModuleManagerDelegatorFactory implements
    DelegatorFactoryInterface
{
    /**
     * A factory that creates delegates of a given service
     *
     * @param ServiceLocatorInterface $serviceLocator the service locator which requested the service
     * @param string $name the normalized service name
     * @param string $requestedName the requested service name
     * @param callable $callback the callback that is responsible for creating the service
     *
     * @return mixed
     */
    public function createDelegatorWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName, $callback)
    {
        $moduleManager = call_user_func($callback);

        if ($serviceLocator instanceof ServiceManager) {
            $loadVarCryptModule = function(ModuleEvent $event) use ($moduleManager) {
                /** @var \Detail\VarCrypt\Module $varCryptModule */
                $varCryptModule = $moduleManager->loadModule('Detail\VarCrypt');
                $varCryptModule->onLoadModules($event);
            };

            // Load VarCrypt module before the (other) modules are loaded,
            // and thus before the configs are merged.
            $moduleManager->getEventManager()->attach(
                ModuleEvent::EVENT_LOAD_MODULES, $loadVarCryptModule, 10000
            );
        }

        return $moduleManager;
    }
}
