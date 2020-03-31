<?php

namespace gloobus\gsb\database\repositories;

use gloobus\gsb\database\models\Configuration;

/**
 * Class ConfigurationRepository
 *
 * @package       gloobus
 * @subpackage    gloobus\gsb\database\repositories
 * @version       1.0.0
 * @since         1.0.0
 * @author        Tamas Palecian <palecian.tamas@gloobus.it>
 * @copyright     Copyright (c) 2020 Gloobus SRL
 */
class ConfigurationRepository extends Configuration
{
    /**
     * Retrieves the required frontend configurations
     *
     * @return array
     */
    public static function getFrontendConfiguration()
    {
        $defaultLanguageQuery = static::findByAttributes([ 'slug' => 'language.default' ]);
        $languagesQuery = LanguageRepository::findAllByAttributes([ 'is_published' => (int) true ]);

        $defaultLanguage = null;
        $languages = null;

        if ( $defaultLanguageQuery ) {
            $defaultLanguage = $defaultLanguageQuery->value;
        }

        foreach ( $languagesQuery as $language ) {
            $languages [] = $language->slug;
        }

        return [
            'language' => [
                'default' => $defaultLanguage,
                'items'   => $languages,
            ],
        ];
    }
}
