<?php

namespace app\models\tables;

use app\models\User;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property string $task_name
 * @property string $description
 * @property string $dead_line
 * @property int $id_user_manager
 * @property int $id_user_accountable
 *
 * @property Users $userManagerName
 * @property Users $userAccountable
 * @property Users $userManager
 */
class Tasks extends \yii\db\ActiveRecord
{
    public $userName;
    public $comment;

    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['dead_line'], 'safe'],
            [['id_user_manager', 'id_user_accountable'], 'integer'],
            [['task_name'], 'string', 'max' => 50],
            [['id_user_accountable'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['id_user_accountable' => 'id']],
            [['id_user_manager'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['id_user_manager' => 'id']],
            [['userManagerName', 'userAccountableName'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_name' => 'Task Name',
            'description' => 'Description',
            'dead_line' => 'Dead Line',
            'id_user_manager' => 'ManagerId',
            'id_user_accountable' => 'AccountableId',
            'userManagerName' => 'Manager',
            'userAccountableName' => 'Accountable'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserAccountable()
    {
        return $this->hasOne(Users::className(), ['id' => 'id_user_accountable']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */

    public function getUserManagerName(){
        return $this->userManager->login;
    }

    public function getUserAccountableName(){
        return $this->userAccountable->login;
    }

    public function getUserManager()
    {
        return $this->hasOne(Users::className(), ['id' => 'id_user_manager']);
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

    public function getChangeMonth(){
        $month =
            [
                0=>"All months",
                1 => "January",
                2=>"February",
                3=>"March",
                4=>"April",
                5=>"May",
                6=>"June",
                7=>"July",
                8=>"August",
                9=>"September",
                10=>"October",
                11=>"November",
                12=>"December"];
        return $month;
    }

    public static function getTaskDate3DaysBefore(){

        $dateNow = new \DateTime('+3 days');
        $dateNow = $dateNow->format('Y-m-d');
        $dateFeature = ArrayHelper::toArray($dateNow);

       $date = (new Query())
       ->select(['login', 'email'])
       ->from('tasks')
           ->join('JOIN', 'users', 'users.id = tasks.id_user_accountable')
           ->where(['dead_line' => "$dateFeature[0]"])
           ->all();
       return $date;
    }

    public static function getByMonthQuery($month){
        return static::find()
            ->with('userAccountable')
            ->with('userManager')
            ->where(['MONTH(dead_line)' => $month]);
    }

    public static function getByUserQuery($userId){

        return static::find()
            ->where(['id_user_accountable' => $userId]);

        $user = \Yii::$app->db
            ->createCommand('SELECT * FROM tasks WHERE id_user_accountable = ' . $userId)
            ->queryAll();
        return $user;
    }

}
