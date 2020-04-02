<?php

namespace gloobus\gsb\modules\api\controllers;

use gloobus\gsb\helpers\ArrayHelper;
use gloobus\gsb\helpers\RestResponseHelper;
use gloobus\gsb\rest\Controller;
use gloobus\gsb\modules\api\models\forms\AuthenticationForm;
use gloobus\gsb\database\models\Token;

class AuthorizationController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        if ( \Yii::$app->controller->action->getUniqueId() === 'authorization/login' ) {
            unset($behaviors['authenticator']);
        }

        return $behaviors;
    }

    public function actionLogin()
    {
        $model = new AuthenticationForm();
        $model->load(\Yii::$app->request->post(), '');

        if ( $model->validate() ) {
            $identity = $model->getIdentity();
            $token = Token::findByAttributes([ 'entity_id' => $identity->id, 'type' => 'api.authorization' ])->value;

            unset($identity->password);

            return [
                'identity' => $identity,
                'token'    => $token,
            ];
        } else {
            $response = RestResponseHelper::generateModelErrorResponse($model->getErrors(), 'The email address or password was wrong');
        }

        return RestResponseHelper::formatResponse($response);
    }
}
