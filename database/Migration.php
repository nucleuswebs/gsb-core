<?php

namespace gloobus\gsb\database;

/**
 * Class Migration
 *
 * @package       gloobus
 * @subpackage    gloobus\gsb\database
 * @version       1.0.0
 * @since         1.0.0
 * @author        Tamas Palecian <palecian.tamas@gloobus.it>
 * @copyright     Copyright (c) 2020 Gloobus SRL
 */
class Migration extends \yii\db\Migration
{
    const ENGINE_SET = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
}
