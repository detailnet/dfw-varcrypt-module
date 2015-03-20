<?php

namespace Detail\VarCrypt\Listener;

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\ModuleManager\ModuleEvent;

abstract class BaseEncryptorListener implements
    ListenerAggregateInterface
{
    /**
     * @var array
     */
    protected $callbacks = array();

    /**
     * {@inheritDoc}
     */
    public function attach(EventManagerInterface $events)
    {
        $this->callbacks[] = $events->attach(ModuleEvent::EVENT_LOAD_MODULES, array($this, 'onLoadModules'), 10000);
    }

    /**
     * @param ModuleEvent $e
     */
    abstract public function onLoadModules(ModuleEvent $e);

    /**
     * {@inheritDoc}
     */
    public function detach(EventManagerInterface $events)
    {
        foreach ($this->callbacks as $index => $callback) {
            if ($events->detach($callback)) {
                unset($this->callbacks[$index]);
            }
        }
    }
}
