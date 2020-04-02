<?php

namespace gloobus\gsb\database\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%identity}}".
 *
 * @property string      $id
 * @property string      $email_address
 * @property string      $password
 * @property string      $first_name
 * @property string      $last_name
 * @property string      $role_id
 * @property int         $is_confirmed
 * @property int         $is_organization
 * @property string      $created_at
 * @property string|null $updated_at
 */
class Identity extends \gloobus\gsb\database\ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%identity}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'email_address',
                    'password',
                    'first_name',
                    'last_name',
                    'role_id',
                    'is_confirmed',
                    'is_organization',
                ],
                'required',
            ],
            [ [ 'is_confirmed', 'is_organization' ], 'integer' ],
            [ [ 'created_at', 'updated_at' ], 'safe' ],
            [ [ 'id', 'role_id' ], 'string', 'max' => 36 ],
            [ [ 'email_address', 'first_name', 'last_name' ], 'string', 'max' => 255 ],
            [ [ 'password' ], 'string', 'max' => 100 ],
            [ [ 'email_address' ], 'unique' ],
            [ [ 'id' ], 'unique' ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'              => 'ID',
            'email_address'   => 'Email Address',
            'password'        => 'Password',
            'first_name'      => 'First Name',
            'last_name'       => 'Last Name',
            'role_id'         => 'Role ID',
            'is_confirmed'    => 'Is Confirmed',
            'is_organization' => 'Is Organization',
            'created_at'      => 'Created At',
            'updated_at'      => 'Updated At',
        ];
    }


    /**
     * Get the identity related role
     */
    public function getRole(): ?Role
    {
        return $this->hasOne(Role::class, [ 'id' => 'role_id' ]);
    }

    /**
     * Get the identity related tokens
     */
    public function getTokens()
    {
        return $this->hasMany(Token::class, [ 'entity_id' => 'id' ]);
    }

    /**
     * {@inheritDoc}
     */
    public static function findIdentity( $id )
    {
        return static::findByUid($id);
    }

    /**
     * {@inheritDoc}
     * Not implemented in first version
     */
    public static function findIdentityByAccessToken( $token, $type = null )
    {
        return null;
        //return static::findByAttributes([ 'access_token' => $token ]);
    }

    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritDoc}
     */
    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    /**
     * {@inheritDoc}
     */
    public function validateAuthKey( $authKey )
    {
        // TODO: Implement validateAuthKey() method.
    }

    /**
     * Validates if the given password is correct or not for the current identity
     *
     * @param $password the password to validate
     * @return bool whatever the password is valid or not
     */
    public function validatePassword( $password ): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }
}
