<?php

namespace gloobus\gsb\database\repositories;

use Yii;

use gloobus\gsb\database\models\Identity;

/**
 * Class IdentityRepository
 *
 * @package       gloobus
 * @subpackage    gloobus\gsb\database\repositories
 * @version       1.0.0
 * @since         1.0.0
 * @author        Tamas Palecian <palecian.tamas@gloobus.it>
 * @copyright     Copyright (c) 2020 Gloobus SRL
 */
class IdentityRepository extends Identity
{
    public static function create( Identity $identity ): ?Identity
    {
        $identity->password = Yii::$app->security->generatePasswordHash($identity->password);
        $identity->is_confirmed = (int) false;
        $identity->is_organization = (int) $identity->is_organization;
        $identity->save();

        return $identity;
    }

    /**
     * Set the record [[is_confirmed]] property to true
     *
     * @param string $id the record id
     * @return Identity|null the updated active record or null if the record was not found
     */
    public static function setConfirmed( string $id ): Identity
    {
        $record = static::findByUid($id);

        if ( ! $record ) {
            return null;
        }

        $record->is_confirmed = (int) true;
        $record->update();

        return  $record;
    }

    /**
     * Set the record [[is_organization]] property to true
     *
     * @param string $id the record id
     * @return Identity|null the updated active record or null if the record was not found
     */
    public static function setOrganization( string $id ): Identity
    {
        $record = static::findByUid($id);

        if ( ! $record ) {
            return null;
        }

        $record->is_organization = (int) true;
        $record->update();

        return  $record;
    }
}
