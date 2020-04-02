<?php

namespace gloobus\gsb\rest;

use yii\web\Response;

use gloobus\gsb\rest\filters\HttpBearerAuth;

/**
 * Class ActiveController
 *
 * @package       gloobus
 * @subpackage    gloobus\gsb\rest
 * @version       1.0.0
 * @since         1.0.0
 * @author        Tamas Palecian <palecian.tamas@gloobus.it>
 * @copyright     Copyright (c) 2020 Gloobus SRL
 */
class ActiveController extends \yii\rest\ActiveController
{
    /**
     * {@inheritDoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        unset($behaviors['authenticator']);

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
            'cors'  => [
                'Origin'                           => [ '*', 'http://127.0.0.1:3000' ],
                'Access-Control-Request-Method'    => [ 'GET', 'POST', 'OPTION' ],
                'Access-Control-Request-Headers'   => [ '*' ],
                'Access-Control-Allow-Credentials' => false,
                'Access-Control-Expose-Headers'    => [ 'Access-Controll-Allow-Origin' ],
            ],
        ];

        $behaviors['authenticator'] = [
            'class'       => \yii\filters\auth\CompositeAuth::class,
            'authMethods' => [
                HttpBearerAuth::class,
            ],
            'except'      => [ 'options' ],
        ];

        $behaviors['contentNegotiator'] = [
            'class'   => 'yii\filters\ContentNegotiator',
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];

        $behaviors['verbs'] = [
            'class'   => \yii\filters\VerbFilter::class,
            'actions' => [
                'index'  => [ 'GET' ],
                'view'   => [ 'GET' ],
                'create' => [ 'POST' ],
                'update' => [ 'PUT' ],
                'delete' => [ 'DELETE' ],
            ],
        ];

        return $behaviors;
    }
}
