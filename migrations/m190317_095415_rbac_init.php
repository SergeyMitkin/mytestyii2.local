<?php

use yii\db\Migration;

/**
 * Class m190317_095415_rbac_init
 */
class m190317_095415_rbac_init extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $am = Yii::$app->authManager;
        $moder = $am->getRole('moderator');
        $am->assign($moder, 21);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190317_095415_rbac_init cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190317_095415_rbac_init cannot be reverted.\n";

        return false;
    }
    */
}
