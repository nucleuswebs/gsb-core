<?php

namespace gloobus\gsb\helpers;

/**
 * Class ArrayHelper
 *
 * @package       gloobus
 * @subpackage    gloobus\gsb\helpers
 * @version       1.0.0
 * @since         1.0.0
 * @author        Tamas Palecian <palecian.tamas@gloobus.it>
 * @copyright     Copyright (c) 2020 Gloobus SRL
 */
class ArrayHelper extends \yii\helpers\ArrayHelper
{
    /**
     * Verifies whatever the string is a serialized array or not
     *
     * @param string $value the string which will be verified
     * @return bool whatever the string is a serialized array or not
     */
    public static function isSerialized( string $value )
    {
        if ( !is_string($value) ) {
            return false;
        }

        $value = trim($value);

        if ( 'N;' == $value ) {
            return true;
        }

        if ( !preg_match('/^([adObis]):/', $value, $badions) ) {
            return false;
        }

        switch ( $badions[1] ) {
            case 'a' :
            case 'O' :
            case 's' :
                if ( preg_match("/^{$badions[1]}:[0-9]+:.*[;}]\$/s", $value) ) {
                    return true;
                }
                break;
            case 'b' :
            case 'i' :
            case 'd' :
                if ( preg_match("/^{$badions[1]}:[0-9.E-]+;\$/", $value) ) {
                    return true;
                }
                break;
        }

        return false;
    }
}
