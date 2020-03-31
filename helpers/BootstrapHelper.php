<?php

namespace gloobus\gsb\helpers;

/**
 * Class BootstrapHelper
 *
 * @package       gloobus
 * @subpackage    gloobus\gsb\helpers
 * @version       1.0.0
 * @since         1.0.0
 * @author        Tamas Palecian <palecian.tamas@gloobus.it>
 * @copyright     Copyright (c) 2020 Gloobus SRL
 */
class BootstrapHelper
{
    /**
     * Bind a component to the application instance
     * If the component already exists in the application, then the configuration given will override the application
     * component configuration
     *
     * @param mixed  $application   the application instance
     * @param string $name          the component name
     * @param array  $configuration the component configuration
     * @return mixed the updated application instance
     * @see ArrayHelper::merge()
     * @see https://www.yiiframework.com/doc/guide/2.0/en/structure-application-components
     */
    public static function bindComponent( $application, string $name, array $configuration )
    {
        $applicationComponents = $application->components;

        if ( isset($applicationComponents[$name]) ) {
            $componentConfiguration = ArrayHelper::merge(
                $applicationComponents[$name],
                $configuration
            );
        } else {
            $applicationComponents[$name] = $configuration;
        }

        $application->components = $applicationComponents;

        return $application;
    }

    /**
     * Bind a migration path to the application instance
     *
     * @param mixed  $application   the application instance
     * @param string $migrationPath the migration path
     * @return mixed the application instance
     * @see https://www.yiiframework.com/doc/guide/2.0/en/db-migrations
     */
    public static function bindMigrationPath( $application, string $migrationPath )
    {
        $application->params['yii.migrations'][] = $migrationPath;

        return $application;
    }
}
