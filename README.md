# Zend Framework 2 Module for dfw-varcrypt

[![Build Status](https://travis-ci.org/detailnet/dfw-varcrypt-module.svg?branch=master)](https://travis-ci.org/detailnet/dfw-varcrypt-module)
[![Coverage Status](https://img.shields.io/coveralls/detailnet/dfw-varcrypt-module.svg)](https://coveralls.io/r/detailnet/dfw-varcrypt-module)
[![Latest Stable Version](https://poser.pugx.org/detailnet/dfw-varcrypt-module/v/stable.svg)](https://packagist.org/packages/detailnet/dfw-varcrypt-module)
[![Latest Unstable Version](https://poser.pugx.org/detailnet/dfw-varcrypt-module/v/unstable.svg)](https://packagist.org/packages/detailnet/dfw-varcrypt-module)

## Introduction
This module integrates the [DETAIL Framework library for for working with encrypted environment variables](https://github.com/detailnet/dfw-varcrypt) with [Zend Framework 2](https://github.com/zendframework/zf2).

## Requirements
[Zend Framework 2 Skeleton Application](http://www.github.com/zendframework/ZendSkeletonApplication) (or compatible architecture)

## Installation
Install the module through [Composer](http://getcomposer.org/) using the following steps:

  1. `cd my/project/directory`
  
  2. Create a `composer.json` file with following contents (or update your existing file accordingly):

     ```json
     {
         "require": {
             "detailnet/dfw-varcrypt-module": "1.x-dev"
         }
     }
     ```
  3. Install Composer via `curl -s http://getcomposer.org/installer | php` (on Windows, download
     the [installer](http://getcomposer.org/installer) and execute it with PHP)
     
  4. Run `php composer.phar self-update`
     
  5. Run `php composer.phar install`
  
  6. Open `configs/application.config.php` and add following key to your `modules`:

     ```php
     'service_manager' => array(
         'delegators' => array(
             'ModuleManager' => array(
                 // By attaching this delegator the module Detail\VarCrypt is loaded before
                 // all other modules so that the encrypted environment variables can be
                 // applied before the configs of the other modules are merged/applied.
                 'Detail\VarCrypt\Factory\ModuleManager\ModuleManagerDelegatorFactory',
             ),
         ),
     ),
     ```

  7. Copy `vendor/detailnet/dfw-varcrypt-module/config/detail_varcrypt.local.php.dist` into your application's
     `config/autoload` directory, rename it to `detail_varcrypt.local.php` and make the appropriate changes.

## Usage

### Save/encode config
Before the module can be used, a config (simple string or JSON encoded string) needs to be encoded
and provided as environment variable.

Here's an example for providing MongoDB credentials as a single environment variable:

1. Define credentials as JSON:

     ```json
     {
       "server": "localhost",
       "user": "root",
       "password": "root",
       "port": 27017,
       "dbname": null,
       "options": []
     }
     ```

2. Make sure an encryption key is set in `detail_varcrypt.local.php`.
3. Encode JSON: `php public/index.php varcrypt encode-value {"server": ...}`
4. Save the output as environment variable (e.g. `MONGO`).
5. Test that the environment variable can be accessed (at least from the CLI):
   `php public/index.php varcrypt decode-variable MONGO`
   
### Apply/decode config
The following steps are necessary, to use an encrypted/encoded environment variable in a ZF2 app.

1. Add the environment variable to the module's config (in `detail_varcrypt.local.php`):

     ```php
     'detail_varcrypt' => array(
         'listeners' => array(
             'Detail\VarCrypt\Listener\MultiEncryptorListener' => array(
                 'apply_variables' => array(
                     'mongo',
                 ),
             ),
         ),
     ),
     ```
2. Access environment variables as you normally would:

     ```php
     array(
         'doctrine' => array(
             'connection' => array(
                 'odm_default' => array(
                     'server' => getenv('MONGO_SERVER') ?: 'localhost',
                     ...
                 ),
             ),
         ),
     )
     ```
