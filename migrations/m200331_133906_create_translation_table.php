<?php

/**
 * Class m200331_133906_create_translation_table
 *
 * @package       gloobus
 * @subpackage    gloobus\gsb\migrations
 * @version       1.0.0
 * @since         1.0.0
 * @author        Tamas Palecian <palecian.tamas@gloobus.it>
 * @copyright     Copyright (c) 2020 Gloobus SRL
 */
class m200331_133906_create_translation_table extends \gloobus\gsb\database\Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            '{{%translation}}',
            [
                'id'          => $this->string(36)->notNull(),
                'slug'        => $this->string(50)->notNull(),
                'value'       => $this->text(),
                'language_id' => $this->string(36)->notNull(),
                'source_id'   => $this->string(36),
                'created_at'  => $this->integer(10)->notNull(),
                'updated_at'  => $this->integer(10),
            ],
            self::ENGINE_SET
        );

        $this->addPrimaryKey('pk_translation-id', '{{%translation}}', 'id');
        $this->createIndex('idx_translation-slug', '{{%translation}}', 'slug');
        $this->createIndex('idx_translation-language-id', '{{%translation}}', 'language_id');
        $this->createIndex('idx_translation-source-id', '{{%translation}}', 'source_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%translation}}', []);
        $this->dropIndex('idx_translation-source-id', '{{%translation}}');
        $this->dropIndex('idx_translation-language-id', '{{%translation}}');
        $this->dropIndex('idx_translation-slug', '{{%translation}}');
        $this->dropPrimaryKey('pk_translation-id', '{{%translation}}');
        $this->dropTable('{{%translation}}');
    }
}
