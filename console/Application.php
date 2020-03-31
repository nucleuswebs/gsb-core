<?php

namespace gloobus\gsb\console;

use yii\console\{ErrorHandler, Request, Response};

use gloobus\gsb\helpers\ArrayHelper;
use gloobus\gsb\web\components\{Theme};

/**
 * Class Application
 *
 * @package       gloobus
 * @subpackage    gloobus\gsb\console
 * @version       1.0.0
 * @since         1.0.0
 * @author        Tamas Palecian <palecian.tamas@gloobus.it>
 * @copyright     Copyright (c) 2020 Gloobus SRL
 */
class Application extends \gloobus\gsb\base\Application
{
    /**
     * The option name for specifying the application configuratino file path.
     */
    const OPTION_APPCONFIG = 'appconfig';

    /**
     * @var string the default route of this application. Defaults to 'help', meaning the `help` command.
     */
    public $defaultRoute = 'help';

    /**
     * @var bool whatever to enable the commands provided by the yii framework. Defaults to true.
     */
    public $enableCoreCommands = true;

    /**
     * @var Controller the currently active controller instance
     */
    public $controller;

    /**
     * {@inheritDoc}
     */
    public function __construct( $config )
    {
        $config = $this->loadConfig($config);
        parent::__construct($config);
    }

    /**
     * Loads the configuration.
     * This method will check if the command line option [[OPTION_APPCONFIG]] is specified.
     * If so, the corresponding file will be loaded as the application configuration.
     * Otherwise, the configuration provided as the parameter will be returned back.
     *
     * @param array $config the configuration provided in the constructor.
     * @return array the actual configuration to be used by the application.
     */
    protected function loadConfig( $config )
    {
        if ( !empty($_SERVER['argv']) ) {
            $option = '--' . self::OPTION_APPCONFIG . '=';
            foreach ( $_SERVER['argv'] as $param ) {
                if ( strpos($param, $option) !== false ) {
                    $path = substr($param, strlen($option));
                    if ( !empty($path) && is_file($file = Yii::getAlias($path)) ) {
                        return require $file;
                    }

                    exit("The configuration file does not exist: $path\n");
                }
            }
        }

        return $config;
    }

    /**
     * Initialize the application
     */
    public function init()
    {
        parent::init();
        if ( $this->enableCoreCommands ) {
            foreach ( $this->coreCommands() as $id => $command ) {
                if ( !isset($this->controllerMap[$id]) ) {
                    $this->controllerMap[$id] = $command;
                }
            }
        }
        // ensure we have the 'help' command so that we can list the available commands
        if ( !isset($this->controllerMap['help']) ) {
            $this->controllerMap['help'] = 'yii\console\controllers\HelpController';
        }
    }

    /**
     * Handles the specified request
     *
     * @param Request $request the request to be handled
     * @return Response the resulting response
     */
    public function handleRequest( $request )
    {
        list($route, $params) = $request->resolve();
        $this->requestedRoute = $route;
        $result = $this->runAction($route, $params);

        if ( $result instanceof Response ) {
            return $result;
        }

        $response = $this->getResponse();
        $response->exitStatus = $result;

        return $response;
    }

    /**
     * Runs a controller action specified by a route.
     * This method parses the specified route and creates the corresponding child module(s), controller and action
     * instances. It then calls [[Controller::runAction()]] to run the action with the given parameters.
     * If the route is empty, the method will use [[defaultRoute]].
     * For example, to run `public function actionTest($a, $b)` assuming that the controller has options the following
     * code should be used:
     * ```php
     * \Yii::$app->runAction('controller/test', ['option' => 'value', $a, $b]);
     * ```
     *
     * @param string $route  the route that specifies the action.
     * @param array  $params the parameters to be passed to the action
     * @return int|Response the result of the action. This can be either an exit code or Response object.
     *                       Exit code 0 means normal, and other values mean abnormal. Exit code of `null` is treaded
     *                       as `0` as well.
     * @throws Exception if the route is invalid
     */
    public function runAction( $route, $params = [] )
    {
        try {
            $res = parent::runAction($route, $params);

            return is_object($res) ? $res : (int) $res;
        } catch ( InvalidRouteException $e ) {
            throw new UnknownCommandException($route, $this, 0, $e);
        }
    }

    /**
     * Returns the error handler component
     *
     * @return ErrorHandler the error handler application component
     */
    public function getErrorHandler(): ErrorHandler
    {
        return $this->get('errorHandler');
    }

    /**
     * Returns the request component
     *
     * @return Request the request component
     */
    public function getRequest(): Request
    {
        return $this->get('request');
    }

    /**
     * Returns the response component
     *
     * @return Response the response component
     */
    public function getResponse(): Response
    {
        return $this->get('response');
    }

    /**
     * Retrieves the theme component
     *
     * @return Theme the theme component
     */
    public function getTheme(): Theme
    {
        return $this->get('theme');
    }

    /**
     * Returns the configuration of the built-in commands
     *
     * @return array the configuration of the built-in commands.
     */
    public function coreCommands()
    {
        return [
            'asset'   => 'yii\console\controllers\AssetController',
            'cache'   => 'yii\console\controllers\CacheController',
            'fixture' => 'yii\console\controllers\FixtureController',
            'help'    => 'yii\console\controllers\HelpController',
            'message' => 'yii\console\controllers\MessageController',
            'migrate' => 'yii\console\controllers\MigrateController',
            'serve'   => 'yii\console\controllers\ServeController',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function coreComponents()
    {
        return ArrayHelper::merge(
            parent::coreComponents(),
            [
                'errorHandler' => [ 'class' => ErrorHandler::class ],
                'request'      => [ 'class' => Request::class ],
                'response'     => [ 'class' => Response::class ],
                'theme'        => [ 'class' => Theme::class ],
            ]
        );
    }
}
