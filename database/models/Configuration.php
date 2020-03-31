<?php

namespace gloobus\gsb\database\models;

use Yii;

/**
 * This is the model class for table "nucleo_configuration".
 *
 * @property string      $id
 * @property string      $slug
 * @property string      $name
 * @property string      $description
 * @property string|null $value
 * @property string      $language_id
 * @property string|null $source_id
 * @property int         $is_serialized
 * @property int         $is_core
 * @property int         $created_at
 * @property int|null    $updated_at
 */
class Configuration extends \gloobus\gsb\database\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%configuration}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [ [ 'slug', 'name', 'description', 'language_id', 'is_serialized', 'is_core' ], 'required' ],
            [ [ 'description', 'value' ], 'string' ],
            [ [ 'is_serialized', 'is_core', 'created_at', 'updated_at' ], 'integer' ],
            [ [ 'id', 'language_id', 'source_id' ], 'string', 'max' => 36 ],
            [ [ 'slug', 'name' ], 'string', 'max' => 255 ],
            [ [ 'id' ], 'unique' ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'            => 'ID',
            'slug'          => 'Slug',
            'name'          => 'Name',
            'description'   => 'Description',
            'value'         => 'Value',
            'language_id'   => 'Language ID',
            'source_id'     => 'Source ID',
            'is_serialized' => 'Is Serialized',
            'is_core'       => 'Is Core',
            'created_at'    => 'Created At',
            'updated_at'    => 'Updated At',
        ];
    }
}
