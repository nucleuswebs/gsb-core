<?php

/**
 * Class m200228_193637_create_identity_table
 *
 * @package       gloobus
 * @subpackage    gloobus\gsb\migrations
 * @version       1.0.0
 * @since         1.0.0
 * @author        Tamas Palecian <palecian.tamas@gloobus.it>
 * @copyright     Copyright (c) 2020 Gloobus SRL
 */
class m200228_193637_create_identity_table extends \gloobus\gsb\database\Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            '{{%identity}}',
            [
                'id'              => $this->string(36)->notNull(),
                'email_address'   => $this->string(255)->notNull(),
                'password'        => $this->string(100)->notNull(),
                'first_name'      => $this->string(255)->notNull(),
                'last_name'       => $this->string(255)->notNull(),
                'role_id'         => $this->string(36)->notNull(),
                'is_confirmed'    => $this->boolean()->notNull(),
                'is_organization' => $this->boolean()->notNull(),
                'created_at'      => $this->integer(10)->notNull(),
                'updated_at'      => $this->integer(10),
            ],
            self::ENGINE_SET
        );

        $this->addPrimaryKey('pk_identity-id', '{{%identity}}', 'id');
        $this->createIndex('idx_identity-email-address', '{{%identity}}', 'email_address', true);
        $this->createIndex('idx_identity-role-id', '{{%identity}}', 'role_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%identity}}', []);
        $this->dropIndex('idx_identity-role-id', '{{%identity}}');
        $this->dropIndex('idx_identity-email-address', '{{%identity}}');
        $this->dropPrimaryKey('pk_identity-id', '{{%identity}}');
        $this->dropTable('{{%identity}}');
    }
}
