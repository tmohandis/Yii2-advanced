<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%project_user}}`.
 */
class m191128_215024_create_project_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('project_user', [
            'id' => $this->primaryKey(),
            'project_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
        ]);
        $this->execute("ALTER TABLE `project_user` ADD `role` ENUM 
 ('manager', 'developer', 'tester')");
        $this->addForeignKey('fk_project_user_user', 'project_user', 'user_id',
            'user', 'id', 'cascade');
        $this->addForeignKey('fk_project_user_project', 'project_user', 'project_id',
            'project', 'id', 'cascade');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_project_user_user', 'project_user' );
        $this->dropForeignKey('fk_project_user_project', 'project_user' );
        $this->dropTable('project_user');
    }
}
