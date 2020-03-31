<?php

namespace gloobus\gsb\web;

/**
 * Class Controller
 *
 * @package       gloobus
 * @subpackage    gloobus\gsb\web
 * @version       1.0.0
 * @since         1.0.0
 * @author        Tamas Palecian <palecian.tamas@gloobus.it>
 * @copyright     Copyright (c) 2020 Gloobus SRL
 */
class Controller extends \yii\web\Controller
{
    /**
     * {@inheritDoc}
     */
    public function beforeAction( $action )
    {
        return parent::beforeAction($action);
    }
}
