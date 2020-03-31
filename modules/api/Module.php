<?php

namespace app\modules\api;

/**
 * Class Module
 */
class Module extends \gloobus\gsb\base\Module
{
    /**
     * @var string the module controllers namespace
     */
    public $controllerNamespace = 'app\modules\api\controllers';

    /**
     * {@inheritDoc}
     */
    public function init()
    {
        parent::init();
        \Yii::$app->user->enableSession = false;
    }
}
