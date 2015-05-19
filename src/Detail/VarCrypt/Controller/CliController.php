<?php

namespace Detail\VarCrypt\Controller;

use Zend\Console\Request as ConsoleRequest;
use Zend\Console\Adapter\AdapterInterface as Console;
use Zend\Console\ColorInterface as ConsoleColor;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ConsoleModel;

use Detail\VarCrypt\SimpleEncryptor;
use Detail\VarCrypt\Exception;

class CliController extends AbstractActionController
{
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
    public function encodeValueAction()
    {
        $request = $this->getConsoleRequest();

        $value = $request->getParam('value');
        $encodedValue = $this->getEncryptor()->encode($value);

        $this->writeConsoleLine($encodedValue);
    }

    /**
     * @return void
     */
    public function decodeValueAction()
    {
        $request = $this->getConsoleRequest();

        $value = $request->getParam('value');
        $decodedValue = $this->getEncryptor()->decode($value);

        $this->writeConsoleLine($decodedValue);
    }

    /**
     * @return ConsoleModel
     */
    public function decodeVariableAction()
    {
        $request = $this->getConsoleRequest();

        $variable = $request->getParam('variable');
        $decodedValue = $this->getEncryptor()->getVariable($variable);

        $response = new ConsoleModel();

        if ($decodedValue === null) {
            $this->writeConsoleLine('Variable does not exist', ConsoleColor::LIGHT_RED);
            $response->setErrorLevel(1);
        } else {
            $this->writeConsoleLine($decodedValue);
        }

        return $response;
    }

    /**
     * @return ConsoleRequest
     */
    protected function getConsoleRequest()
    {
        $request = $this->getRequest();

        // Make sure that we are running in a console and the user has not tricked our
        // application into running this action from a public web server.
        if (!$request instanceof ConsoleRequest) {
            throw new Exception\RuntimeException('You can only use this action from a console');
        }

        return $request;
    }

    /**
     * @param string $message
     * @param integer $color
     */
    protected function writeConsoleLine($message, $color = ConsoleColor::LIGHT_BLUE)
    {
//        /** @var ConsoleRequest $request */
//        $request = $this->getRequest();
//        $isVerbose = $request->getParam('verbose', false) || $request->getParam('v', false);

        $console = $this->getServiceLocator()->get('console');

        if (!$console instanceof Console) {
            throw new Exception\RuntimeException(
                'Cannot obtain console adapter. Are we running in a console?'
            );
        }

//        if ($isVerbose) {
            $console->writeLine($message, $color);
//        }
    }
}
