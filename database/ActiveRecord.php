<?php

namespace gloobus\gsb\database;

use gloobus\gsb\database\behaviors\{TimestampBehavior, UniqueIdBehavior};

/**
 * Class ActiveRecord
 *
 * @package       gloobus
 * @subpackage    gloobus\gsb\database
 * @version       1.0.0
 * @since         1.0.0
 * @author        Tamas Palecian <palecian.tamas@gloobus.it>
 * @copyright     Copyright (c) 2020 Gloobus SRL
 */
class ActiveRecord extends \yii\db\ActiveRecord
{
    /**
     * {@inheritDoc}
     */
    public function behaviors()
    {
        return [
            [
                'class'      => TimestampBehavior::class,
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => [ 'created_at' ],
                    self::EVENT_BEFORE_UPDATE => [ 'updated_at' ],
                ],
            ],
            UniqueIdBehavior::class,
        ];
    }

    /**
     * Find an ActiveRecord instance with the given id
     *
     * @param int $id the id of the record
     * @return mixed|null the ActiveRecord instance or `null` if nothing matches
     */
    public static function findById( int $id )
    {
        return self::findByAttributes([ 'id' => $id ]);
    }

    /**
     * Find an ActiveRecord instance with the given unique id
     *
     * @param string $uniqueId the uid of the record
     * @return mixed|null the ActiveRecord instance or `null` if nothing matches
     */
    public static function findByUid( string $uniqueId )
    {
        return self::findByAttributes([ 'id' => $uniqueId ]);
    }

    /**
     * Find an ActiveRecord instance with the given slug
     *
     * @param string $slug the slug of the record
     * @return mixed|null the ActiveRecord instance or `null` if nothing matches
     */
    public static function findBySlug( string $slug )
    {
        return self::findByAttributes([ 'slug' => $slug ]);
    }

    /**
     * Find an ActiveRecord instance with the given slug and language code
     *
     * @param string $slug         the slug of the record
     * @param string $languageCode the language code of the record
     * @return mixed|null the ActiveRecord instance or `null` if nothing matches
     */
    public static function findBySlugAndLanguage( string $slug, string $languageCode )
    {
        return self::findByAttributes(
            [
                'slug'          => $slug,
                'language_code' => $languageCode,
            ]
        );
    }

    /**
     * Find the first ActiveRecord instance based on sort_order property in `ascending` order
     *
     * @return mixed|null the ActiveRecord instance or `null` if nothing matches
     */
    public static function findFirstBySortOrder()
    {
        return static::find()->orderBy([ 'sort_order' => SORT_ASC ])->one();
    }

    /**
     * Find the last ActiveRecord instance based on sort_order property in `descending` order
     *
     * @return mixed|null the ActiveRecord instance or `null` if nothing matches
     */
    public static function findLastBySortOrder()
    {
        return static::find()->orderBy([ 'sort_order' => SORT_DESC ])->one();
    }

    /**
     * Find an ActiveRecord instance based on attributes criteria
     *
     * @param array $attributes the conditions based on what to search for record
     * @return mixed|null the ActiveRecord record instance or `null` if nothing matches
     */
    public static function findByAttributes( array $attributes )
    {
        return static::find()->where($attributes)->one();
    }

    /**
     * Find ActiveRecord instance(s) based on attributes criteria
     *
     * @param array $attributes the conditions based on what to search for record(s)
     * @return array an array of ActiveRecord instances, or an empty array if nothing matches
     */
    public static function findAllByAttributes( array $attributes ): array
    {
        return static::find()->where($attributes)->all();
    }
}
