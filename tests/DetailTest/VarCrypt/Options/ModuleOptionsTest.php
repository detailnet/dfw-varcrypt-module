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
//                'getClient',
//                'setClient',
            )
        );
    }

    public function testDummy()
    {
        // Remove once we have a real test
    }

//    public function testClientCanBeSet()
//    {
//        $clientOptions = array('base_url' => 'some-url');
//
//        $this->assertNull($this->options->getClient());
//
//        $this->options->setClient($clientOptions);
//
//        $client = $this->options->getClient();
//
//        $this->assertInstanceOf('Detail\FileConversion\Options\Client\FileConversionClientOptions', $client);
//        $this->assertEquals($clientOptions['base_url'], $client->getBaseUrl());
//    }
}
