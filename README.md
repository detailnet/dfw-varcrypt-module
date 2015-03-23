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
tbd
