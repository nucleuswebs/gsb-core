<?php

namespace gloobus\gsb;

/**
 * Class Bootstrap
 *
 * @package       gloobus
 * @subpackage    gloobus\gsb
 * @version       1.0.0
 * @since         1.0.0
 * @author        Tamas Palecian <palecian.tamas@gloobus.it>
 * @copyright     Copyright (c) 2020 Gloobus SRL
 */
class Bootstrap extends \gloobus\gsb\base\Bootstrap
{
	/**
	 * {@inheritDoc}
	 */
	public function bindWebConfigurations( $application ): void
	{
		parent::bindWebConfigurations($application);
	}

	/**
	 * {@inheritDoc}
	 */
	public function bindConsoleConfigurations( $application ): void
	{
		$this->addMigrationPath('@gloobus/gsb/migrations');
		parent::bindConsoleConfigurations($application);
	}
}
