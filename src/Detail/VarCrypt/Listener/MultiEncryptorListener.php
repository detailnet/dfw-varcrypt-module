<?php

namespace Detail\VarCrypt\Listener;

use Zend\ModuleManager\ModuleEvent;

use Keboola\Encryption;

use Detail\VarCrypt;

class MultiEncryptorListener extends BaseEncryptorListener implements
    VarCrypt\MultiEncryptorAwareInterface
{
    use VarCrypt\MultiEncryptorAwareTrait;

    /**
     * @var array
     */
    protected $variables;

    /**
     * @var array
     */
    protected $applyVariables;

    /**
     * @param VarCrypt\MultiEncryptor $encryptor
     * @param array $variables
     * @param array $applyVariables
     */
    public function __construct(
        VarCrypt\MultiEncryptor $encryptor,
        array $variables = array(),
        array $applyVariables = array()
    ) {
        $this->setEncryptor($encryptor);
        $this->setVariables($variables);
        $this->setApplyVariables($applyVariables);
    }

    /**
     * @return array
     */
    public function getVariables()
    {
        return $this->variables;
    }

    /**
     * @param array $variables
     */
    public function setVariables($variables)
    {
        $this->variables = $variables;
    }

    /**
     * @return array
     */
    public function getApplyVariables()
    {
        return $this->applyVariables;
    }

    /**
     * @param array $applyVariables
     */
    public function setApplyVariables($applyVariables)
    {
        $this->applyVariables = $applyVariables;
    }

    /**
     * @param ModuleEvent $event
     */
    public function onLoadModules(ModuleEvent $event)
    {
        $encryptor = $this->getEncryptor();

        foreach ($this->getVariables() as $group => $variables) {
            $encryptor->setVariables($group, $variables);
        }

        $encryptor->applyVariables($this->getApplyVariables());
    }
}
