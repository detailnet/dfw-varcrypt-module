<?php

namespace Detail\VarCrypt\Controller;

use DateTime;

use Zend\Console\Request as ConsoleRequest;
use Zend\Console\Adapter\AdapterInterface as Console;
use Zend\Console\ColorInterface as ConsoleColor;
use Zend\Mvc\Controller\AbstractActionController;

//use Detail\VarCrypt\BaseEncryptor;
use Detail\VarCrypt\SimpleEncryptor;
use Detail\VarCrypt\Exception;
//use Detail\VarCrypt\Options\ModuleOptions;

class CliController extends AbstractActionController
{
//    /**
//     * @var ModuleOptions
//     */
//    protected $options;
//
//    /**
//     * @param ModuleOptions $options
//     */
//    public function __construct(ModuleOptions $options)
//    {
//        $this->setOptions($options);
//    }
//
//    /**
//     * @return ModuleOptions
//     */
//    public function getOptions()
//    {
//        return $this->options;
//    }
//
//    /**
//     * @param ModuleOptions $options
//     */
//    public function setOptions(ModuleOptions $options)
//    {
//        $this->options = $options;
//    }

    /**
     * @var SimpleEncryptor
     */
    protected $encryptor;

    /**
     * @param SimpleEncryptor $encryptor
     */
    public function __construct(SimpleEncryptor $encryptor)
    {
        $this->setEncryptor($encryptor);
    }

    /**
     * @return SimpleEncryptor
     */
    public function getEncryptor()
    {
        return $this->encryptor;
    }

    /**
     * @param SimpleEncryptor $encryptor
     */
    public function setEncryptor(SimpleEncryptor $encryptor)
    {
        $this->encryptor = $encryptor;
    }

    /**
     * @return void
     */
    public function encodeAction()
    {
        $this->writeConsoleLine('encode');

        $request = $this->getConsoleRequest();

        $value = $request->getParam('value');

//        $encryptorClass = $request->getParam('encryptor', $this->getOptions()->getEncryptor());
//        /** @var BaseEncryptor $encryptor */
//        $encryptor = $this->getEncryptors()->getEncryptor($encryptorClass);

        $encodedValue = $this->getEncryptor()->encode($value);

        var_dump($value, $encodedValue);
    }

    /**
     * @return ConsoleRequest
     */
    protected function getConsoleRequest()
    {
        $request = $this->getRequest();

        // Make sure that we are running in a console and the user has not tricked our
        // application into running this action from a public web server.
        if (!$request instanceof ConsoleRequest){
            throw new Exception\RuntimeException('You can only use this action from a console');
        }

        return $request;
    }

    protected function writeConsoleLine($message, $color = ConsoleColor::LIGHT_BLUE)
    {
        /** @var ConsoleRequest $request */
        $request = $this->getRequest();
        $isVerbose = $request->getParam('verbose', false) || $request->getParam('v', false);

        $console = $this->getServiceLocator()->get('console');

        if (!$console instanceof Console) {
            throw new Exception\RuntimeException(
                'Cannot obtain console adapter. Are we running in a console?'
            );
        }

        if ($isVerbose) {
            $console->writeLine(sprintf('[%s] %s', $this->getTime(), $message), $color);
        }
    }

    /**
     * @return string
     */
    protected function getTime()
    {
        $time = microtime(true);
        $micro = sprintf("%06d", ($time - floor($time)) * 1000000);
        $date = new DateTime(date('Y-m-d H:i:s.' . $micro, $time));

        return $date->format("Y-m-d H:i:s.u");
    }
}
