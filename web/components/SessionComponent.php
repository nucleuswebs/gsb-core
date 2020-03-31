<?php

namespace gloobus\gsb\web\components;

use Yii;
use yii\base\InvalidConfigException;
use yii\web\Session;

use gloobus\gsb\helpers\ArrayHelper;

/**
 * Class SessionComponent
 *
 * @package       gloobus
 * @subpackage    gloobus\gsb\web\components
 * @version       1.0.0
 * @since         1.0.0
 * @author        Tamas Palecian <palecian.tamas@gloobus.it>
 * @copyright     Copyright (c) 2020 Gloobus SRL
 */
class SessionComponent extends Session
{
    public $encryptionKey = null;

    /**
     * {@inheritDoc}
     */
    public function init()
    {
        if ( $this->default === null ) {
            throw new InvalidConfigException(
                Yii::t('nucleo.exceptions', 'No encryption key has been specified!', 500)
            );
        }
        parent::init();
    }

    /**
     * {@inheritDoc}
     */
    public function get( $key, $defaultValue = null )
    {
        $this->open();

        return isset($_SESSION[$key]) ? $this->decrypt($_SESSION[$key]) : $defaultValue;
    }

    /**
     * {@inheritDoc}
     */
    public function set( $key, $value )
    {
        $this->open();
        $_SESSION[$key] = $this->encrypt($value);
    }

    /**
     * Encrypt session value
     *
     * @param string|array $value the session value
     * @return string the encrypted value
     * @see \gloobus\gsb\base\components\Security::encryptByKey()
     */
    private function encrypt( $value ): string
    {
        if ( is_array($value) ) {
            $value = serialize($value);
        }

        return Yii::$app->security->encryptByKey($value, $this->encryptionKey);
    }

    /**
     * Decrypt session value
     *
     * @param mixed $value the encrypted value
     * @return mixed the decrypted value
     * @see \gloobus\gsb\base\components\Security::decryptByKey()
     */
    private function decrypt( $value )
    {
        if ( is_array($value) ) {
            return $value;
        }

        $decryptedValue = Yii::$app->security->decryptByKey($value, $this->encryptionKey);

        if ( ArrayHelper::isSerialized($decryptedValue) ) {
            return unserialize($decryptedValue);
        }

        return $decryptedValue;
    }
}
