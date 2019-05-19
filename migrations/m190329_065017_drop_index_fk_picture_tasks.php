<?php

use yii\db\Migration;

/**
 * Class m190329_065017_drop_index_fk_picture_tasks
 */
class m190329_065017_drop_index_fk_picture_tasks extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropIndex('fk_picture_tasks', 'picture');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190329_065017_drop_index_fk_picture_tasks cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190329_065017_drop_index_fk_picture_tasks cannot be reverted.\n";

        return false;
    }
    */
}
