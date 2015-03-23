<?php

namespace DetailTest\VarCrypt\Options;

class ModuleOptionsTest extends OptionsTestCase
{
    /**
     * @var \Detail\VarCrypt\Options\ModuleOptions
     */
    protected $options;

    protected function setUp()
    {
        $this->options = $this->getOptions(
            'Detail\VarCrypt\Options\ModuleOptions',
            array(
                'getEncryptor',
                'setEncryptor',
                'getKey',
                'setKey',
            )
        );
    }

    public function testEncryptorCanBeSet()
    {
        $encryptor = 'Some\Encryptor\Class';

        $this->assertNull($this->options->getEncryptor());

        $this->options->setEncryptor($encryptor);

        $this->assertEquals($encryptor, $this->options->getEncryptor());
    }

    public function testKeyCanBeSet()
    {
        $key = 'some-key';

        $this->assertNull($this->options->getKey());

        $this->options->setKey($key);

        $this->assertEquals($key, $this->options->getKey());
    }
}
