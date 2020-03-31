<?php

/**
 * Class m200330_124854_create_language_table
 *
 * @package       gloobus
 * @subpackage    gloobus\gsb\migrations
 * @version       1.0.0
 * @since         1.0.0
 * @author        Tamas Palecian <palecian.tamas@gloobus.it>
 * @copyright     Copyright (c) 2020 Gloobus SRL
 */
class m200330_124854_create_language_table extends \gloobus\gsb\database\Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            '{{%language}}',
            [
                'id'           => $this->string(36)->notNull(),
                'slug'         => $this->string(50)->notNull(),
                'name'         => $this->string(255)->notNull(),
                'is_core'      => $this->boolean()->notNull(),
                'is_published' => $this->boolean()->notNull(),
                'created_at'   => $this->integer(10)->notNull(),
                'updated_at'   => $this->integer(10),
            ],
            self::ENGINE_SET
        );

        $this->addPrimaryKey('pk_language-id', '{{%language}}', 'id');
        $this->createIndex('idx_language-slug', '{{%language}}', 'slug');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%language}}', []);
        $this->dropIndex('idx_language-slug', '{{%language}}');
        $this->dropPrimaryKey('pk_language-id', '{{%language}}');
        $this->dropTable('{{%language}}');
    }
}
