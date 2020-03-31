<?php

namespace gloobus\gsb\modules\api\controllers;

use gloobus\gsb\rest\Controller;

/**
 * Class TranslationController
 */
class TranslationController extends Controller
{
    /**
     * {@inheritDoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        if ( \Yii::$app->controller->action->getUniqueId() === 'translation/index' ) {
            unset($behaviors['authenticator']);
        }

        return $behaviors;
    }

    public function actionIndex()
    {
        return [];
    }
}
