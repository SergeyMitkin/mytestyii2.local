<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\filters\TasksFilter */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tasks';
$this->params['breadcrumbs'][] = $this->title;
if(Yii::$app->request->get('userName')){
    $this->params['breadcrumbs'][] .= Yii::$app->request->get('userName');
}
;
?>
<div class="tasks-index">

    <h1><?= Html::encode($this->title);
        if(Yii::$app->request->get('userName')){
            echo ' ('.Yii::$app->request->get('userName').')';
        }
        ?></h1>
    <p>
    </p>

    <p>
        <? if(!Yii::$app->request->get('userName'))
        echo Html::a('Create Task', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'task_name',
            'description:ntext',
            'dead_line',
            //'id_user_manager',
            'userManagerName',
            'userAccountableName',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>
</div>
