<?php

namespace gloobus\gsb\database\models;

use Yii;

/**
 * This is the model class for table "{{%translation}}".
 *
 * @property string      $id
 * @property string      $slug
 * @property string|null $value
 * @property string      $language_id
 * @property string|null $source_id
 * @property int         $created_at
 * @property int|null    $updated_at
 */
class Translation extends \gloobus\gsb\database\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%translation}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [ [ 'slug', 'language_id' ], 'required' ],
            [ [ 'value' ], 'string' ],
            [ [ 'created_at', 'updated_at' ], 'integer' ],
            [ [ 'id', 'language_id', 'source_id' ], 'string', 'max' => 36 ],
            [ [ 'slug' ], 'string', 'max' => 50 ],
            [ [ 'id' ], 'unique' ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'slug'        => 'Slug',
            'value'       => 'Value',
            'language_id' => 'Language ID',
            'source_id'   => 'Source ID',
            'created_at'  => 'Created At',
            'updated_at'  => 'Updated At',
        ];
    }
}
