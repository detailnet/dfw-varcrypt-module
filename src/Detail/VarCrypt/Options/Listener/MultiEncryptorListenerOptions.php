<?php

namespace Detail\VarCrypt\Options\Listener;

use Detail\Core\Options\AbstractOptions;

class MultiEncryptorListenerOptions extends AbstractOptions
{
    /**
     * @var array
     */
    protected $variables = array();

    /**
     * @var string[]
     */
    protected $applyVariables = array();

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
    public function setVariables(array $variables)
    {
        $this->variables = $variables;
    }

    /**
     * @return string[]
     */
    public function getApplyVariables()
    {
        return $this->applyVariables;
    }

    /**
     * @param string[] $applyVariables
     */
    public function setApplyVariables(array $applyVariables)
    {
        $this->applyVariables = $applyVariables;
    }
}
