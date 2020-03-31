<?php

namespace gloobus\gsb\database\behaviors;

use yii\behaviors\AttributeBehavior;
use yii\db\BaseActiveRecord;

/**
 * Class UniqueIdBehavior
 *
 * @package       gloobus
 * @subpackage    gloobus\gsb\database\behaviors
 * @version       1.0.0
 * @since         1.0.0
 * @author        Tamas Palecian <palecian.tamas@gloobus.it>
 * @copyright     Copyright (c) 2020 Gloobus SRL
 */
class UniqueIdBehavior extends AttributeBehavior
{
    /**
     * @var string the attribute that will receive the generated hash
     */
    public $uniqueIdAttribute = 'id';

    /**
     * {@inheritDoc}
     * in case, when the value is `null`, a new hash will be generated as value
     */
    public $value;

    /**
     * {@inheritDoc}
     */
    public function init()
    {
        parent::init();

        if ( empty($this->attributes) ) {
            $this->attributes = [
                BaseActiveRecord::EVENT_BEFORE_INSERT => [ $this->uniqueIdAttribute ],
            ];
        }
    }

    /**
     * {@@inheritDoc}
     * update the attach method to validate if the entity has the required property else we do not attach the event to
     * the entity
     */
    public function attach( $owner )
    {
        if ( $owner->hasProperty($this->uniqueIdAttribute) ) {
            parent::attach($owner);
        }
    }

    /**
     * {@inheritDoc}
     * in case, when the [[value]] is `null`, a new hash value will be generated
     */
    protected function getValue( $event )
    {
        if ( $this->value === null ) {
            do {
                $className = $this->owner->classname();
                $hash = \Yii::$app->security->makeUuid();
            } while ( $this->hasExists($className, $hash) === true );

            $this->value = $hash;
        }

        return parent::getValue($event);
    }

    /**
     * Validates whatever the generated hash exists in the given active record class
     *
     * @return bool whatever the has exists or not
     */
    protected function hasExists( string $className, string $uniqueId ): bool
    {
        if ( $className::findByUid($uniqueId) !== null ) {
            return true;
        }

        return false;
    }
}
