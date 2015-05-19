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
    'controllers' => array(
        'factories' => array(
            'Detail\VarCrypt\Controller\CliController' => 'Detail\VarCrypt\Factory\Controller\CliControllerFactory',
        ),
    ),
    'console' => array(
        'router' => array(
            'routes' => array(
                'dfw-varcrypt.encode-value' => array(
                    'options' => array(
//                        'route'    => 'varcrypt encode-value [--verbose|-v] <value>',
                        'route'    => 'varcrypt encode-value <value>',
                        'defaults' => array(
                            'controller' => 'Detail\VarCrypt\Controller\CliController',
                            'action'     => 'encodeValue',
                        ),
                    ),
                ),
                'dfw-varcrypt.decode-value' => array(
                    'options' => array(
                        'route'    => 'varcrypt decode-value <value>',
                        'defaults' => array(
                            'controller' => 'Detail\VarCrypt\Controller\CliController',
                            'action'     => 'decodeValue',
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
