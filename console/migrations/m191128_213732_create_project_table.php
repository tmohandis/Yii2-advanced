<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%project}}`.
 */
class m191128_213732_create_project_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('project', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'description' => $this->text()->notNull(),
            'active' => $this->boolean()->defaultValue(0),
            'creator_id' => $this->integer()->notNull(),
            'updater_id' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer(),

        ]);
        $this->addForeignKey('fk_project_user_creator', 'project', 'creator_id',
            'user', 'id', 'cascade');
        $this->addForeignKey('fk_project_user_updater', 'project', 'updater_id',
        'user', 'id', 'cascade');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_project_user_creator', 'project');
        $this->dropForeignKey('fk_project_user_updater', 'project');
        $this->dropTable('project');
    }
}
