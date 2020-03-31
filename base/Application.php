<?php

namespace gloobus\gsb\base;

use gloobus\gsb\base\components\SecurityComponent;
use gloobus\gsb\helpers\ArrayHelper;

/**
 * Class Application
 *
 * @package       gloobus
 * @subpackage    gloobus\gsb
 * @version       1.0.0
 * @since         1.0.0
 * @author        Tamas Palecian <palecian.tamas@gloobus.it>
 * @copyright     Copyright (c) 2020 Gloobus SRL
 */
abstract class Application extends \yii\base\Application
{
	/**
	 * {@inheritDoc}
	 */
	public function coreComponents()
	{
		return ArrayHelper::merge(
			parent::coreComponents(),
			[
				'security' => SecurityComponent::class,
			]
		);
	}

	/**
	 * Handle the specified request
	 * This method should return on instance of [[Response]] or its child class
	 * which represents the handling result of the request.
	 *
	 * @param Request $request the request to be handled
	 * @return Response the resulting response
	 */
	abstract public function handleRequest( $request );

	/**
	 * Retrieves the security component
	 *
	 * @return SecurityComponent the security component
	 */
	public function getSecurity(): SecurityComponent
	{
		return $this->get('security');
	}
}
