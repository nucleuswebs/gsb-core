<?php

namespace gloobus\gsb\database\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "nucleo_token".
 *
 * @property string   $id
 * @property string   $type
 * @property string   $entity_id
 * @property string   $value
 * @property int      $is_expired
 * @property int      $created_at
 * @property int|null $updated_at
 */
class Token extends \gloobus\gsb\database\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%token}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [ [ 'type', 'entity_id', 'value', 'is_expired' ], 'required' ],
            [ [ 'is_expired', 'created_at', 'updated_at' ], 'integer' ],
            [ [ 'id', 'entity_id', 'value' ], 'string', 'max' => 36 ],
            [ [ 'type' ], 'string', 'max' => 255 ],
            [ [ 'id' ], 'unique' ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'type'       => 'Type',
            'entity_id'  => 'Entity ID',
            'value'      => 'Value',
            'is_expired' => 'Is Expired',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Get the related identity
     */
    public function getIdentity(): ?ActiveQuery
    {
        return $this->hasOne(Identity::class, [ 'id' => 'entity_id' ]);
    }
}
