<?php

namespace gloobus\gsb\database\models;

use Yii;

/**
 * This is the model class for table "nucleo_language".
 *
 * @property string   $id
 * @property string   $slug
 * @property string   $name
 * @property int      $is_core
 * @property int      $is_published
 * @property int      $created_at
 * @property int|null $updated_at
 */
class Language extends \gloobus\gsb\database\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%language}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [ [ 'slug', 'name', 'is_core', 'is_published' ], 'required' ],
            [ [ 'is_core', 'is_published', 'created_at', 'updated_at' ], 'integer' ],
            [ [ 'id' ], 'string', 'max' => 36 ],
            [ [ 'slug' ], 'string', 'max' => 50 ],
            [ [ 'name' ], 'string', 'max' => 255 ],
            [ [ 'id' ], 'unique' ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'           => 'ID',
            'slug'         => 'Slug',
            'name'         => 'Name',
            'is_core'      => 'Is Core',
            'is_published' => 'Is Published',
            'created_at'   => 'Created At',
            'updated_at'   => 'Updated At',
        ];
    }
}
