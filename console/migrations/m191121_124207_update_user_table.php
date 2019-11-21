<?php

use yii\db\Migration;

/**
 * Class m191121_124207_update_user_table
 */
class m191121_124207_update_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'access_token', $this->string()->notNull());
        $this->addColumn('user', 'avatar', $this->string()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'access_token');
        $this->dropColumn('user', 'avatar');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191121_124207_update_user_table cannot be reverted.\n";

        return false;
    }
    */
}
