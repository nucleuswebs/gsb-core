<?php

namespace gloobus\gsb\database\behaviors;

use yii\behaviors\AttributeBehavior;
use yii\db\BaseActiveRecord;

use gloobus\gsb\database\ActiveRecord;

/**
 * Class TimestampBehavior
 *
 * @package       gloobus
 * @subpackage    gloobus\gsb\database\behaviors
 * @version       1.0.0
 * @since         1.0.0
 * @author        Tamas Palecian <palecian.tamas@gloobus.it>
 * @copyright     Copyright (c) 2020 Gloobus SRL
 */
class TimestampBehavior extends AttributeBehavior
{
    /**
     * @var string the attribute that will receive timestamp value
     * set this property to false if you do not want to record the creation time.
     */
    public $createdAtAttribute = 'created_at';

    /**
     * @var string the attribute that will receive timestamp value
     * set this property to false if you do not want to record the update time.
     */
    public $updatedAtAttribute = 'updated_at';

    /**
     * {@inheritDoc}
     * in case, when the value is `null`, the result of the curent timestamp will be used as value
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
                BaseActiveRecord::EVENT_BEFORE_INSERT => [ $this->createdAtAttribute, $this->updatedAtAttribute ],
                BaseActiveRecord::EVENT_BEFORE_UPDATE => $this->updatedAtAttribute,
            ];
        }
    }

    /**
     * {@inheritDoc}
     * in case, when the [[value]] is `null`, a new timestamp value will be generated
     */
    protected function getValue( $event )
    {
        if ( $this->value === null ) {
            return time();
        }

        return parent::getValue($event);
    }
}
