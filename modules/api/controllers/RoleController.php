<?php

namespace app\modules\api\controllers;

use gloobus\gsb\rest\ActiveController;

/**
 * Class RoleController
 */
class RoleController extends ActiveController
{
    public $modelClass = 'gloobus\gsb\database\models\Role';
}
