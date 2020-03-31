<?php

/**
 * Console Application configuration
 * To understand the configuration structure please check the link bellow with the documentation of YiiFramework.
 *
 * @package       gloobus
 * @subpackage    gloobus\gsb\app
 * @version       1.0.0
 * @since         1.0.0
 * @author        Tamas Palecian <palecian.tamas@gloobus.it>
 * @copyright     Copyright (c) 2020 Gloobus SRL
 * @see           https://www.yiiframework.com/doc/guide/2.0/en/concept-configurations
 */
return [
    /**
     ******************************************************************************************************************/
    'id'            => 'nucleo-console',
    'basePath'      => dirname(__DIR__, 4),

    /**
     ******************************************************************************************************************/
    'controllerMap' => [
        'migrate' => [
            'class' => 'gloobus\\gsb\\console\\controllers\\MigrationController',
        ],
    ],

    /**
     ******************************************************************************************************************/
    'components'    => [
        'urlManager' => [
            'class' => 'gloobus\\gsb\\web\\components\\UrlManager',
        ],
    ],
];
