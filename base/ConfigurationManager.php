<?php

namespace gloobus\gsb\base;

use yii\base\Exception;
use yii\web\Request;

use gloobus\gsb\helpers\ArrayHelper;

/**
 * Class ConfigurationManager
 *
 * @package       gloobus
 * @subpackage    gloobus\gsb\base
 * @version       1.0.0
 * @since         1.0.0
 * @author        Tamas Palecian <palecian.tamas@gloobus.it>
 * @copyright     Copyright (c) 2020 Gloobus SRL
 */
class ConfigurationManager
{
    const WEB_CONFIG_NAME = 'web-application.php';
    const CONSOLE_CONFIG_NAME = 'console-application.php';

    /**
     * Generates the application configuration based on application type and environment
     * The process starts by checking if the application is console application or web application,
     * then merges the base application configuration with the environment configuration.
     * This method also injects the components configuration to the generated configuration data
     *
     * @param bool $isConsole whatever the application type is console or not
     * @return array the generated configuration
     */
    public static function make( bool $isConsole ): array
    {
        $nucleoConfigPath = dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR;
        $envConfigPath = dirname(__DIR__, 4) . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR;
        $componentsConfigPath = $envConfigPath . 'components' . DIRECTORY_SEPARATOR;

        $nucleoConfigName = ( $isConsole ) ? static::CONSOLE_CONFIG_NAME : static::WEB_CONFIG_NAME;
        $envConfigName = 'environment-' . YII_ENV . '.php';

        $nucleoConfig = static::get($nucleoConfigName, $nucleoConfigPath);
        $envConfig = static::get($envConfigName, $envConfigPath);

        $configuration = ArrayHelper::merge($nucleoConfig, $envConfig);
        $configuration = static::bindComponents($configuration, $componentsConfigPath, $isConsole);

        if ( !$isConsole ) {
            $configuration = static::bindWebRequest($configuration);
        }

        return $configuration;
    }

    /**
     * Retrieves the configuration value from the requested file
     *
     * @param string $fileName the file name with extension
     * @param string $filePath the file path
     * @return array the configuration file content
     * @throws Exception if the configuration file was not found
     */
    public static function get( string $fileName, string $filePath ): array
    {
        $fileLocation = rtrim($filePath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $fileName;

        if ( !file_exists($fileLocation) ) {
            throw new Exception('The configuration file was not found in ' . $fileLocation, 500);
        }

        return include( $fileLocation );
    }

    /**
     * Binds the components configuration data retrieved from the given directory to the application components data
     *
     * @param array  $configuration  the application configuration
     * @param string $componentsPath the components configurations directory path
     * @param bool   $isConsole      whatever the application type is console or not
     * @return array the application configuration
     * @throws Exception if the configuration file was not found
     * @see get() the method which retrieves the configuration file data
     */
    public static function bindComponents( array $configuration, string $componentsPath, bool $isConsole ): array
    {
        $componentsToBind = [ 'components' => [] ];
        $componentsFilesList = array_diff(scandir($componentsPath), [ '..', '.' ]);

        if ( empty($componentsFilesList) ) {
            return $configuration;
        }

        foreach ( $componentsFilesList as $componentFileName ):
            $componentName = str_replace('-component.php', '', $componentFileName);
            $componentConfiguration = self::get($componentFileName, $componentsPath);
            if ( $isConsole && $componentName === 'request' ) {
                continue( 1 );
            }

            $componentsToBind['components'][$componentName] = $componentConfiguration;
        endforeach;

        if ( !empty($componentsToBind['components']) ) {
            $configuration = ArrayHelper::merge($configuration, $componentsToBind);
        }


        return $configuration;
    }

    public static function bindWebRequest( array $configuration ): array
    {
        $request = new Request;
        $baseUrl = str_replace('/web', '', $request->getBaseUrl());
        $configuration['components']['request']['baseUrl'] = $baseUrl;

        return $configuration;
    }
}
