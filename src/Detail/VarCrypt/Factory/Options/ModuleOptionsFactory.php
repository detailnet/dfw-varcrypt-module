<?php

namespace Detail\VarCrypt\Factory\Options;

use Traversable;

use Zend\Config\Factory as ConfigFactory;
use Zend\ModuleManager\Listener\ConfigListener;
use Zend\ModuleManager\Listener\DefaultListenerAggregate;
use Zend\ModuleManager\Listener\ListenerOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\ArrayUtils;
use Zend\Stdlib\Glob;

use Detail\VarCrypt\Exception;
use Detail\VarCrypt\Module;
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
            throw new Exception\ConfigException('Module Detail\VarCrypt is not loaded');
        }

        $config = $this->getConfig($serviceLocator, $module);

        if (!isset($config['detail_varcrypt'])) {
            throw new Exception\ConfigException('Config for Detail\VarCrypt is not set');
        }

        $moduleOptions = new ModuleOptions($config['detail_varcrypt']);

        if (!$moduleOptions->getKey()) {
            throw new Exception\ConfigException(
                'Missing required config option "key" for module Detail\VarCrypt'
            );
        }

        return $moduleOptions;
    }

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @param Module $module
     * @return array
     */
    protected function getConfig(ServiceLocatorInterface $serviceLocator, Module $module)
    {
        // Load same configs as the ConfigListener would...
        $applicationConfiguration = $serviceLocator->get('ApplicationConfig');
        $listenerOptions  = new ListenerOptions($applicationConfiguration['module_listener_options']);

        $configPaths = array_merge(
            $this->getConfigPaths($listenerOptions->getConfigGlobPaths(), ConfigListener::GLOB_PATH),
            $this->getConfigPaths($listenerOptions->getConfigStaticPaths(), ConfigListener::STATIC_PATH)
        );

        $config = $module->getConfig();
        $configs = array();

        foreach ($configPaths as $path) {
            $configs = array_merge($configs, $this->getConfigsByPath($path['path'], $path['type']));
        }

        foreach ($configs as $cfg) {
            $config = ArrayUtils::merge($config, $cfg);
        }

        return $config;
    }

    /**
     * Add an array of paths of config files to merge after loading modules
     *
     * @param Traversable|array $paths
     * @param string $type
     * @throws Exception\InvalidArgumentException
     * @return array
     */
    protected function getConfigPaths($paths, $type)
    {
        if ($paths instanceof Traversable) {
            $paths = ArrayUtils::iteratorToArray($paths);
        }

        if (!is_array($paths)) {
            throw new Exception\InvalidArgumentException(
                sprintf(
                    'Argument passed to %::%s() must be an array, '
                    . 'implement the Traversable interface, or be an '
                    . 'instance of Zend\Config\Config. %s given.',
                    __CLASS__,
                    __METHOD__,
                    gettype($paths)
                )
            );
        }

        $configPaths = array();

        foreach ($paths as $path) {
            if (!is_string($path)) {
                throw new Exception\InvalidArgumentException(
                    sprintf(
                        'Parameter to %s::%s() must be a string; %s given.',
                        __CLASS__,
                        __METHOD__,
                        gettype($path)
                    )
                );
            }

            $configPaths[] = array('type' => $type, 'path' => $path);
        }

        return $configPaths;
    }

    /**
     * Given a path (glob or static), fetch the config and add it to the array
     * of configs to merge.
     *
     * @param string $path
     * @param string $type
     * @return array
     */
    protected function getConfigsByPath($path, $type)
    {
        $getConfig = function($config) {
            if ($config instanceof Traversable) {
                $config = ArrayUtils::iteratorToArray($config);
            }

            if (!is_array($config)) {
                throw new Exception\InvalidArgumentException(
                    sprintf(
                        'Config being merged must be an array, '
                        . 'implement the Traversable interface, or be an '
                        . 'instance of Zend\Config\Config. %s given.',
                        gettype($config)
                    )
                );
            }

            return $config;
        };

        $configs = array();

        switch ($type) {
            case ConfigListener::STATIC_PATH:
                $configs[$path] = $getConfig(ConfigFactory::fromFile($path));
                break;
            case ConfigListener::GLOB_PATH:
                // We want to keep track of where each value came from so we don't
                // use ConfigFactory::fromFiles() since it does merging internally.
                foreach (Glob::glob($path, Glob::GLOB_BRACE) as $file) {
                    $configs[$file] = $getConfig(ConfigFactory::fromFile($file));
                }
                break;
        }

        return $configs;
    }
}
