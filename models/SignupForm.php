<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 04.05.2019
 * Time: 3:16
 */

namespace app\models;

use app\models\tables\Users;
use yii\base\Model;

class SignupForm extends Model
{
    public $login;
    public $password;

    public function rules() {
        return [
            [['login', 'password'], 'required', 'message' => 'Заполните поле'],
            ['login', 'unique', 'targetClass' => Users::className(),  'message' => 'Этот логин уже занят'],
        ];
    }

    public function attributeLabels() {
        return [
            'login' => 'Логин',
            'password' => 'Пароль',
        ];
    }

    public function authAssignment($id){
        $am = \Yii::$app->authManager;
        $role = $am->getRole('moderator');
        $am->assign($role, $id);
        }
}