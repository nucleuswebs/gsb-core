<?php

/**
 * Web Application configuration
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
    'id'             => 'gsb',
    'language'       => 'en-US',
    'sourceLanguage' => 'en-US',


    /**
     ******************************************************************************************************************/
    'basePath'       => dirname(__DIR__, 4),
    'bootstrap'      => [
        'log',
        'theme',
    ],
    'aliases'        => [
        'cache'  => '@app/app/cache',
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],


    /**
     ******************************************************************************************************************/
    'controllerMap'  => [
        'migrate' => [
            'class' => 'gloobus\\gsb\\console\\controllers\\MigrationController',
        ],
    ],

    /**
     ******************************************************************************************************************/
    'components'     => [
        'cache'      => [
            'class'     => 'yii\caching\FileCache',
            'cachePath' => '@app/app/cache',
        ],
        'i18n'       => [
            'translations' => [

            ],
        ],
        'request'    => [
            'baseUrl' => '',
            'class'   => 'yii\\web\\Request',
        ],
        'user'       => [
            'identityClass'   => 'gloobus\\gsb\\database\\models\\entity\\Identity',
            'enableAutoLogin' => false,
        ],
        'urlManager' => [
            'class' => 'gloobus\\gsb\\web\\components\\UrlManagerComponent',
        ],
    ]
];
