<?php

namespace Detail\VarCrypt;

use Zend\Console\Adapter\AdapterInterface as Console;
use Zend\Loader\AutoloaderFactory;
use Zend\Loader\StandardAutoloader;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;
use Zend\ModuleManager\Feature\ControllerProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\ModuleEvent;
//use Zend\ModuleManager\ModuleManager;
use Zend\ServiceManager\Config as ServiceConfig;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\ArrayUtils;

class Module implements
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    ControllerProviderInterface,
    ServiceProviderInterface,
    ConsoleUsageProviderInterface
{
    public function onLoadModules(ModuleEvent $event)
    {
//        /** @var ModuleManager $moduleManager */
//        $moduleManager = $event->getTarget();
        /** @var ServiceManager $serviceLocator */
        $serviceLocator = $event->getParam('ServiceManager');

        $serviceConfig = ArrayUtils::merge(
            $this->getConfig(false)['service_manager'],
            $this->getServiceConfig()
        );

        $serviceConfig = new ServiceConfig($serviceConfig);
        $serviceConfig->configureServiceManager($serviceLocator);

        /** @var \Detail\VarCrypt\Listener\MultiEncryptorListener $encryptorListener */
        $encryptorListener = $serviceLocator->get('Detail\VarCrypt\Listener\MultiEncryptorListener');
        $encryptorListener->onLoadModules($event);

//        $moduleManager->getEventManager()->attachAggregate($encryptorListener);
    }

    /**
     * {@inheritdoc}
     */
    public function getAutoloaderConfig()
    {
        return array(
            AutoloaderFactory::STANDARD_AUTOLOADER => array(
                StandardAutoloader::LOAD_NS => array(
                    __NAMESPACE__ => __DIR__,
                ),
            ),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig($withoutServiceManager = true)
    {
        $config = include __DIR__ . '/../../../config/module.config.php';

        if ($withoutServiceManager !== false) {
            unset($config['service_manager']);
        }

        return $config;
    }

    public function getControllerConfig()
    {
        return array();
    }

    public function getServiceConfig()
    {
        return array();
    }

    /**
     * {@inheritdoc}
     */
    public function getConsoleUsage(Console $console)
    {
        return array(
            'Actions:',
//            'varcrypt encode-value [--verbose|-v] <value>' => 'Encode a string value',
            'varcrypt encode-value <value>' => 'Encode a string value',
            array('<value>', 'The string to encode'),
//            array('--verbose|-v', '(optional) Turn on verbose mode'),
            'varcrypt decode-value <value>' => 'Decode a string value',
            array('<value>', 'The string to decode'),
        );
    }
}
