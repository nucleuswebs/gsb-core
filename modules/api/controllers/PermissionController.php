<?php

namespace app\modules\api\controllers;

use gloobus\gsb\rest\ActiveController;

/**
 * Class PermissionController
 */
class PermissionController extends ActiveController
{
    public $modelClass = 'gloobus\gsb\database\models\Permission';
}
