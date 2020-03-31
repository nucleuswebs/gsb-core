<?php

namespace gloobus\gsb\database\repositories;

use Yii;

use gloobus\gsb\database\models\Token;

/**
 * Class TokenRepository
 *
 * @package       gloobus
 * @subpackage    gloobus\gsb\database\repositories
 * @version       1.0.0
 * @since         1.0.0
 * @author        Tamas Palecian <palecian.tamas@gloobus.it>
 * @copyright     Copyright (c) 2020 Gloobus SRL
 */
class TokenRepository extends Token
{
    /**
     * Find a record based on given value
     *
     * @param string $value the token value
     * @return Token|null the token entity or null if no token was found
     */
    public static function findByValue( string $value ): ?Token
    {
        return static::findByAttributes(
            [
                'value' => $value,
            ]
        );
    }

    /**
     * Create a record with the given type and entityId
     *
     * @param string $type     the token type
     * @param string $entityId the entity id
     * @return Token the generated Token instance
     */
    public static function create( string $type, string $entityId ): Token
    {
        $token = new Token();
        $token->type = $type;
        $token->entity_id = $entityId;
        $token->value = static::makeUniqueHash();
        $token->is_expired = (int) false;
        if( !$token->save()) {
            var_dump($token->getErrors());
        }

        return $token;
    }

    /**
     * Set the record [[is_expired]] property to true
     *
     * @param string $id the record id
     * @return Token|null the updated active record or null if the record was not found
     */
    public static function setExpired( string $id ): ?Token
    {
        $record = static::findByUid($id);

        if ( !$record ) {
            return null;
        }

        $record->expired = (int) true;
        $record->update();

        return $record;
    }

    /**
     * Make an unique hash used as token value
     *
     * @return string the generated token value
     */
    private static function makeUniqueHash(): string
    {
        do {
            $token = Yii::$app->security->generateRandomString(36);
        } while ( static::findByValue($token) !== null );

        return $token;
    }
}
