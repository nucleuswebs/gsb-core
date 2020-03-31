<?php

namespace gloobus\gsb\base\components;

use Ramsey\Uuid\Uuid;

/**
 * Class SecurityComponent
 *
 * @package       gloobus
 * @subpackage    gloobus\gsb\base\components
 * @version       1.0.0
 * @since         1.0.0
 * @author        Tamas Palecian <palecian.tamas@gloobus.it>
 * @copyright     Copyright (c) 2020 Gloobus SRL
 */
class SecurityComponent extends \yii\base\Security
{
    /**
     * {@inheritDoc}
     */
    public function init()
    {

    }

    /**
     * Make an unique id with the help of the current timestamp
     *
     * @return string the generated unique id
     * @throws \Exception
     * @see Uuid::uuid1()
     */
    public function makeUuid(): string
    {
        return Uuid::uuid1()->toString();
    }
}
