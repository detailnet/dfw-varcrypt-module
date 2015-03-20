<?php

namespace Detail\VarCrypt\Options;

use Detail\Core\Options\AbstractOptions;

class ModuleOptions extends AbstractOptions
{
    /**
     * @var string
     */
    protected $encryptor;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var array
     */
    protected $listeners = array();

    /**
     * @var Listener\MultiEncryptorListenerOptions
     */
    protected $multiEncryptorListener;

    /**
     * @return string
     */
    public function getEncryptor()
    {
        return $this->encryptor;
    }

    /**
     * @param string $encryptor
     */
    public function setEncryptor($encryptor)
    {
        $this->encryptor = $encryptor;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * @return array
     */
    public function getListeners()
    {
        return $this->listeners;
    }

    /**
     * @param array $listeners
     */
    public function setListeners(array $listeners)
    {
        $this->listeners = $listeners;
    }

    /**
     * @return Listener\MultiEncryptorListenerOptions
     */
    public function getMultiEncryptorListener()
    {
        if ($this->multiEncryptorListener === null) {
            $listeners = $this->getListeners();

            $config = array();

            if (isset($listeners['Detail\VarCrypt\Listener\MultiEncryptorListener'])) {
                $config = $listeners['Detail\VarCrypt\Listener\MultiEncryptorListener'];
            }

            $this->multiEncryptorListener = new Listener\MultiEncryptorListenerOptions($config);
        }

        return $this->multiEncryptorListener;
    }
}
