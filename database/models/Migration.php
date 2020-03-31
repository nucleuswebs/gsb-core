<?php

namespace gloobus\gsb\database\models;

use Yii;

/**
 * This is the model class for table "nucleo_migration".
 *
 * @property string $version
 * @property string $alias
 * @property int|null $apply_time
 */
class Migration extends \gloobus\gsb\database\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%migration}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['version', 'alias'], 'required'],
            [['apply_time'], 'integer'],
            [['version', 'alias'], 'string', 'max' => 180],
            [['version'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'version' => 'Version',
            'alias' => 'Alias',
            'apply_time' => 'Apply Time',
        ];
    }
}
