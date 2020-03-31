<?php

/**
 * Class m200326_135747_create_permission_table
 *
 * @package       gloobus
 * @subpackage    gloobus\gsb\migrations
 * @version       1.0.0
 * @since         1.0.0
 * @author        Tamas Palecian <palecian.tamas@gloobus.it>
 * @copyright     Copyright (c) 2020 Gloobus SRL
 */
class m200326_135747_create_permission_table extends \gloobus\gsb\database\Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            '{{%permission}}',
            [
                'id'          => $this->string(36)->notNull(),
                'name'        => $this->string(255)->notNull(),
                'description' => $this->text(),
                'slug'        => $this->string(255)->notNull(),
                'created_at'  => $this->integer(10)->notNull(),
                'updated_at'  => $this->integer(10),
            ],
            self::ENGINE_SET
        );

        $this->addPrimaryKey('pk_permission-id', '{{%permission}}', 'id');
        $this->createIndex('idx_permission-name', '{{%permission}}', 'name');
        $this->createIndex('idx_permission-slug', '{{%permission}}', 'slug', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%permission}}', []);
        $this->dropIndex('idx_permission-slug', '{{%permission}}');
        $this->dropIndex('idx_permission-name', '{{%permission}}');
        $this->dropPrimaryKey('pk_permission-id', '{{%permission}}');
        $this->dropTable('{{%permission}}');
    }
}
