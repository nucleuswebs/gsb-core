<?php

namespace app\modules\api\controllers;

use gloobus\gsb\rest\Controller;
use gloobus\gsb\database\repositories\ConfigurationRepository;

/**
 * Class ConfigurationController
 */
class ConfigurationController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        unset($behaviors['authenticator']);

        return $behaviors;
    }

    public function actionIndex()
    {
        return ConfigurationRepository::getFrontendConfiguration();
    }
}
