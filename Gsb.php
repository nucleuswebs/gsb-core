<?php

namespace gloobus\gsb;

use gloobus\gsb\base\{Application, ConfigurationManager};
use gloobus\gsb\console\Application as ConsoleApplication;
use gloobus\gsb\helpers\ArrayHelper;
use gloobus\gsb\web\Application as WebApplication;

/**
 * Class Nucleo
 *
 * @package       gloobus
 * @subpackage    gloobus\gsb
 * @version       1.0.0
 * @since         1.0.0
 * @author        Tamas Palecian <palecian.tamas@gloobus.it>
 * @copyright     Copyright (c) 2020 Gloobus SRL
 */
class Gsb
{
	/**
	 * @var Application the application instance
	 */
	private $application;

	/**
	 * Get the application instance
	 *
	 * @return Application the application instance
	 */
	public function get(): Application
	{
		return $this->application;
	}

	/**
	 * Creates an application instance with the given application classname
	 *
	 * @param string $className the application class name
	 * @param bool   $isConsole whatever is a console application or not
	 */
	public function make( string $className, bool $isConsole = false ): void
	{
		$configuration = ConfigurationManager::make($isConsole);
		$this->application = new $className($configuration);
	}
}
