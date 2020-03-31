<?php

namespace gloobus\gsb\base;

use yii\base\BootstrapInterface;

use gloobus\gsb\helpers\BootstrapHelper;

/**
 * Class Bootstrap
 *
 * @package       gloobus
 * @subpackage    gloobus\gsb\base
 * @version       1.0.0
 * @since         1.0.0
 * @author        Tamas Palecian <palecian.tamas@gloobus.it>
 * @copyright     Copyright (c) 2020 Gloobus SRL
 */
class Bootstrap implements BootstrapInterface
{
	/**
	 * @var array the list of components binded to the application instance
	 */
	private $components;

	/**
	 * @var array the list of migration paths binded to the application instance
	 */
	private $migrationPaths;

	/**
	 * {@inheritDoc}
	 */
	public function bootstrap( $application )
	{
		$this->bindWebConfigurations($application);
		$this->bindConsoleConfigurations($application);
	}

	/**
	 * Binds the components from [[components]] property to the web application instance
	 *
	 * @param mixed $application the application instance
	 */
	public function bindWebConfigurations( $application ): void
	{
		if ( !$application instanceof \gloobus\gsb\web\Application ) {
			return;
		}

		if ( !empty($this->components) ) {
			foreach ( $this->components as $componentName => $componentConfiguration ):
				BootstrapHelper::bindComponent($application, $componentName, $componentConfiguration);
			endforeach;
		}
	}

	/**
	 * Bind the migration path's from [[migrationPaths]] property to the console application instance
	 *
	 * @param mixed $application the application instance
	 */
	public function bindConsoleConfigurations( $application ): void
	{
		if ( !$application instanceof \gloobus\gsb\console\Application ) {
			return;
		}

		if ( !empty($this->migrationPaths) ) {
			foreach ( $this->migrationPaths as $migrationPath ):
				BootstrapHelper::bindMigrationPath($application, $migrationPath);
			endforeach;
		}
	}

	/**
	 * Add's a component to the [[components]] property
	 *
	 * @param string $name          the component name
	 * @param array  $configuration the component configuration
	 */
	public function addComponent( string $name, array $configuration ): void
	{
		$this->components[$name] = $configuration;
	}

	/**
	 * Add's a migration path to [[migrationPaths]] property
	 *
	 * @param string $path the migration path
	 */
	public function addMigrationPath( string $path ): void
	{
		$this->migrationPaths [] = $path;
	}
}
