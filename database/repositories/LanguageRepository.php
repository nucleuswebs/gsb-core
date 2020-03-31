<?php

namespace gloobus\gsb\database\repositories;

use gloobus\gsb\database\models\Language;

/**
 * Class LanguageRepository
 *
 * @package       gloobus
 * @subpackage    gloobus\gsb\database\repositories
 * @version       1.0.0
 * @since         1.0.0
 * @author        Tamas Palecian <palecian.tamas@gloobus.it>
 * @copyright     Copyright (c) 2020 Gloobus SRL
 */
class LanguageRepository extends Language
{
    public function isPublished()
    {
        return (bool) $this->is_published;
    }

    public function isCore()
    {
        return (bool) $this->is_core;
    }
}
