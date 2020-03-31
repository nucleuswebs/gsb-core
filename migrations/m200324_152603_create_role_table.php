<?php

use yii\behaviors\TimestampBehavior;

/**
 * Class m200324_152603_create_role_table
 *
 * @package       gloobus
 * @subpackage    gloobus\gsb\migrations
 * @version       1.0.0
 * @since         1.0.0
 * @author        Tamas Palecian <palecian.tamas@gloobus.it>
 * @copyright     Copyright (c) 2020 Gloobus SRL
 */
class m200324_152603_create_role_table extends \gloobus\gsb\database\Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            '{{%role}}',
            [
                'id'         => $this->string(36)->notNull(),
                'name'       => $this->string(255)->notNull(),
                'slug'       => $this->string(255)->notNull(),
                'created_at' => $this->integer(10)->notNull(),
                'updated_at' => $this->integer(10),
            ],
            self::ENGINE_SET
        );

        $this->addPrimaryKey('pk_role-id', '{{%role}}', 'id');
        $this->createIndex('idx_role-name', '{{%role}}', 'name');
        $this->createIndex('idx_role-slug', '{{%role}}', 'slug', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%role}}', []);
        $this->dropIndex('idx_role-slug', '{{%role}}');
        $this->dropIndex('idx_role-name', '{{%role}}');
        $this->dropPrimaryKey('pk_role-id', '{{%role}}');
        $this->dropTable('{{%role}}');
    }
}
