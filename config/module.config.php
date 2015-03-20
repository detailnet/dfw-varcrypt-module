<?php

return array(
    'service_manager' => array(
        'abstract_factories' => array(
        ),
        'aliases' => array(
        ),
        'invokables' => array(
        ),
        'factories' => array(
            'Detail\VarCrypt\Listener\MultiEncryptorListener' => 'Detail\VarCrypt\Factory\Listener\MultiEncryptorListenerFactory',
            'Detail\VarCrypt\Listener\SimpleEncryptorListener' => 'Detail\VarCrypt\Factory\Listener\SimpleEncryptorListenerFactory',
            'Detail\VarCrypt\Options\ModuleOptions' => 'Detail\VarCrypt\Factory\Options\ModuleOptionsFactory',
            'Detail\VarCrypt\MultiEncryptor' => 'Detail\VarCrypt\Factory\MultiEncryptorFactory',
            'Detail\VarCrypt\SimpleEncryptor' => 'Detail\VarCrypt\Factory\SimpleEncryptorFactory',
            'Keboola\Encryption\AesEncryptor' => 'Detail\VarCrypt\Factory\Keboola\AesEncryptorFactory',
        ),
        'initializers' => array(
        ),
        'shared' => array(
        ),
    ),
    'detail_varcrypt' => array(
        'encryptor' => 'Keboola\Encryption\AesEncryptor',
        'key' => null,
        'listeners' => array(
            'Detail\VarCrypt\Listener\MultiEncryptorListener' => array(
                'variables' => array(
                ),
                'apply_variables' => array(
                ),
            ),
        ),
    ),
);
