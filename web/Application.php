<?php

namespace gloobus\gsb\web;

use gloobus\gsb\database\models\Identity;
use Yii;
use yii\base\Theme;
use yii\web\{
    ErrorHandler,
    IdentityInterface,
    NotFoundHttpException,
    Request,
    Response,
    UrlNormalizerRedirectException
};

use gloobus\gsb\helpers\ArrayHelper;
use gloobus\gsb\web\components\{ThemeComponent, UserComponent};

/**
 * Class Application
 *
 * @package       gloobus
 * @subpackage    gloobus\gsb\web
 * @version       1.0.0
 * @since         1.0.0
 * @author        Tamas Palecian <palecian.tamas@gloobus.it>
 * @copyright     Copyright (c) 2020 Gloobus SRL
 */
class Application extends \gloobus\gsb\base\Application
{
    /**
     * @var string the default route of the application. Defaults to 'site'
     */
    public $defaultRoute = 'site';

    /**
     * @var array the configuration specifying a controller action which should handle
     * all user requests. This is mainly used when the application is in maintenance mode
     * and needs to handle all incoming requests via a single action.
     * The configuration is an array whose first element specifies the route of the action.
     * The rest of the array elements (key-value pairs) specify the parameters to be bound
     * to the action. For example,
     * ```php
     * [
     *     'offline/notice',
     *     'param1' => 'value1',
     *     'param2' => 'value2',
     * ]
     * ```
     * Defaults to null, meaning catch-all is not used
     */
    public $catchAll;

    /**
     * @var Controller the currently active controller instance
     */
    public $controller;

    /**
     * @var string the homepage URL
     */
    private $_homeUrl;

    /**
     * {@inheritDoc}
     */
    public function bootstrap()
    {
        $request = $this->getRequest();
        Yii::setAlias('@webroot', dirname($request->getScriptFile()));
        Yii::setAlias('@web', $request->getBaseUrl());

        parent::bootstrap();
    }

    /**
     * Handles the specified request
     *
     * @param Request $request the request to be handled
     * @return Response the resulting response
     * @throws NotFoundHttpException if the requested route is invalid
     */
    public function handleRequest( $request )
    {
        if ( empty($this->catchAll) ) {
            try {
                list($route, $params) = $request->resolve();
            } catch ( UrlNormalizerRedirectException $exception ) {
                $url = $exception->url;
                if ( is_array($url) ) {
                    if ( isset($url[0]) ) {
                        $url[0] = '/' . ltrim($url[0], '/');
                    }
                    $url += $request->getQueryParams();
                }

                return $this->getResponse()->redirect(Url::to($url, $exception->scheme), $exception->statusCode);
            }
        } else {
            $route = $this->catchAll[0];
            $params = $this->catchAll;
            unset($params[0]);
        }

        try {
            Yii::debug("Route requested: '$route'", __METHOD__);
            $this->requestedRoute = $route;
            $result = $this->runAction($route, $params);

            if ( $result instanceof Response ) {
                return $result;
            }

            $response = $this->getResponse();
            if ( $result !== null ) {
                $response->data = $result;
            }

            return $response;
        } catch ( InvalidRouteException $exception ) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'), $exception->getCode(), $exception);
        }
    }

    /**
     * Returns the homepage URL
     *
     * @return string the homepage URL
     */
    public function getHomeUrl(): string
    {
        if ( $this->_homeUrl === null ) {
            if ( $this->getUrlManager()->showScriptName ) {
                return $this->getRequest()->getScriptUrl();
            }

            return $this->getRequest()->getBaseUrl() . '/';
        }

        return $this->_homeUrl;
    }

    /**
     * @param string $value the homepage URL
     */
    public function setHomeUrl( string $value ): void
    {
        $this->_homeUrl = $value;
    }

    /**
     * Retrieves the error handler component
     *
     * @return ErrorHandler the error handler component
     */
    public function getErrorHandler(): ErrorHandler
    {
        return $this->get('errorHandler');
    }

    /**
     * Retrieves the request component
     *
     * @return Request the request component
     */
    public function getRequest(): Request
    {
        return $this->get('request');
    }

    /**
     * Retrieves the theme component
     *
     * @return Theme the theme component
     */
    public function getTheme(): ThemeComponent
    {
        return $this->get('theme');
    }

    /**
     *
     */
    public function getUser(): UserComponent
    {
        return $this->get('user');
    }

    /**
     * {@inheritDoc}
     */
    public function coreComponents()
    {
        return ArrayHelper::merge(
            parent::coreComponents(),
            [
                'errorHandler' => [ 'class' => ErrorHandler::class ],
                'request'      => [ 'class' => Request::class ],
                'response'     => [ 'class' => Response::class ],
                'theme'        => [ 'class' => ThemeComponent::class ],
                'user'         => [ 'class' => UserComponent::class ],
            ]
        );
    }
}
