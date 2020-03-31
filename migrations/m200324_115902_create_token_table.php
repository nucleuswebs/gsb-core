<?php

/**
 * Class m200324_115902_create_token_table
 *
 * @package       gloobus
 * @subpackage    gloobus\gsb\migrations
 * @version       1.0.0
 * @since         1.0.0
 * @author        Tamas Palecian <palecian.tamas@gloobus.it>
 * @copyright     Copyright (c) 2020 Gloobus SRL
 */
class m200324_115902_create_token_table extends \gloobus\gsb\database\Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            '{{%token}}',
            [
                'id'         => $this->string(36)->notNull(),
                'type'       => $this->string(255)->notNull(),
                'entity_id'  => $this->string(36)->notNull(),
                'value'      => $this->string(36)->notNull(),
                'is_expired' => $this->boolean()->notNull(),
                'created_at' => $this->integer(10)->notNull(),
                'updated_at' => $this->integer(10),
            ],
            self::ENGINE_SET
        );

        $this->addPrimaryKey('pk_token-id', '{{%token}}', 'id');
        $this->createIndex('idx_token-type', '{{%token}}', 'type');
        $this->createIndex('idx_token-entity-id', '{{%token}}', 'entity_id');
        $this->createIndex('idx_token-value', '{{%token}}', 'value');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%token}}', []);
        $this->dropIndex('idx_token-value', '{{%token}}');
        $this->dropIndex('idx_token-entity-id', '{{%token}}');
        $this->dropIndex('idx_token-type', '{{%token}}');
        $this->dropPrimaryKey('pk_token-id', '{{%token}}');
        $this->dropTable('{{%token}}');
    }
}
