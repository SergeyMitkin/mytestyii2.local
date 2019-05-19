<?php

namespace app\models\tables;

use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $login
 * @property string $password
 *
 * @property Tasks[] $tasks
 * @property Tasks[] $tasks0
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['login', 'password'], 'required'],
            [['login'], 'string', 'max' => 50],
            [['password'], 'string', 'max' => 100],
            [['login'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {

        return [
            'id' => 'ID',
            'login' => 'Login',
            'password' => 'Password',
        ];
    }

    public function fields()
    {
        return [
            'id',
            'username' => 'login',
            'password'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::className(), ['id_user_accountable' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks0()
    {
        return $this->hasMany(Tasks::className(), ['id_user_manager' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function getCreatedUserId(){
        $id = \Yii::$app->db
            ->createCommand('SELECT id FROM users ORDER BY id DESC')
            ->queryOne();

        return $id['id'];
    }

    static function getRolesArray(){
        $roles_values = \Yii::$app->db
            ->createCommand('SELECT DISTINCT item_name FROM auth_assignment')
            ->queryColumn();
        $roles = array_combine($roles_values, $roles_values);
        return $roles;
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()')
            ],
        ];
    }
}
