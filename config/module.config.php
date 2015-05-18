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
            'Detail\VarCrypt\Controller\CliController' => 'Detail\VarCrypt\Factory\Controller\CliControllerFactory',
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
    'console' => array(
        'router' => array(
            'routes' => array(
                'console.dfw-varcrypt.encode' => array(
                    'options' => array(
                        'route'    => 'varcrypt encode [--verbose|-v] <value>',
                        'defaults' => array(
                            'controller' => 'Detail\VarCrypt\Controller\CliController',
                            'action'     => 'encode',
                        ),
                    ),
                ),
            ),
        ),
    ),
    'detail_varcrypt' => array(
        'encryptor' => 'Keboola\Encryption\AesEncryptor',
        'key' => null,
//        'key' => 'xx330ac01bac67c9b03a1956720bceyy',
        'listeners' => array(
            'Detail\VarCrypt\Listener\MultiEncryptorListener' => array(
                'variables' => array(
                    'mysql' => array(
//                        'password' => 'unencrypted_mysql_password',
//                        'port' => 3306,
                    ),
                ),
                'apply_variables' => array(
//                    'mysql'
                ),
            ),
        ),
    ),
);
