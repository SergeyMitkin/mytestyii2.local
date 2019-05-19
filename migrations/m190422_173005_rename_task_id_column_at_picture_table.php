<?php

use yii\db\Migration;

/**
 * Class m190422_173005_rename_task_id_column_at_picture_table
 */
class m190422_173005_rename_task_id_column_at_picture_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('picture', 'task_id', 'comment_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('picture', 'comment_id', 'task_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190422_173005_rename_task_id_column_at_picture_table cannot be reverted.\n";

        return false;
    }
    */
}
