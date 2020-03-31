<?php

/**
 * Class m200330_100758_create_configuration_table
 *
 * @package       gloobus
 * @subpackage    gloobus\gsb\migrations
 * @version       1.0.0
 * @since         1.0.0
 * @author        Tamas Palecian <palecian.tamas@gloobus.it>
 * @copyright     Copyright (c) 2020 Gloobus SRL
 */
class m200330_100758_create_configuration_table extends \gloobus\gsb\database\Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            '{{%configuration}}',
            [
                'id'            => $this->string(36)->notNull(),
                'slug'          => $this->string(255)->notNull(),
                'name'          => $this->string(255)->notNull(),
                'description'   => $this->text()->notNull(),
                'value'         => $this->text(),
                'language_id'   => $this->string(36)->notNull(),
                'source_id'     => $this->string(36),
                'is_serialized' => $this->boolean()->notNull(),
                'is_core'       => $this->boolean()->notNull(),
                'created_at'    => $this->integer(10)->notNull(),
                'updated_at'    => $this->integer(10),
            ],
            self::ENGINE_SET
        );

        $this->addPrimaryKey('pk_configuration-id', '{{%configuration}}', 'id');
        $this->createIndex('idx_configuration-slug', '{{%configuration}}', 'slug');
        $this->createIndex('idx_configuration-language-id', '{{%configuration}}', 'language_id');
        $this->createIndex('idx_configuration-source-id', '{{%configuration}}', 'source_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%configuration}}', []);
        $this->dropIndex('idx_configuration-source-id', '{{%configuration}}');
        $this->dropIndex('idx_configuration-language-id', '{{%configuration}}');
        $this->dropIndex('idx_configuration-slug', '{{%configuration}}');
        $this->dropPrimaryKey('pk_configuration-id', '{{%configuration}}');
        $this->dropTable('{{%configuration}}');
    }
}
