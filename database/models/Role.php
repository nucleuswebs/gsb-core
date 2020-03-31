<?php

namespace gloobus\gsb\database\models;

use Yii;

/**
 * This is the model class for table "nucleo_role".
 *
 * @property string $id
 * @property string $name
 * @property string $slug
 * @property int $created_at
 * @property int|null $updated_at
 */
class Role extends \gloobus\gsb\database\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%role}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'slug'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['id'], 'string', 'max' => 36],
            [['name', 'slug'], 'string', 'max' => 255],
            [['slug'], 'unique'],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'slug' => 'Slug',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
