<h4>Задача: <?=$taskName?></h4>
<p>Описание: <?=$taskDescription?></p>
<p>Ответсвенный: <?=$userName?></p>
<p>Руководитель: <?=$userManager?></p>
<p>Срок выполнения: <?=$date?></p>
<h4>Комментарии:</h4>

<?
echo \yii\widgets\ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => function($model){
        return \app\widgets\CommentPreview::widget(['model' => $model]);
    },
    'summary' => false,
    'showOnEmpty' => true,
    'options' => [
        'class' => 'comment-preview-container'
    ]
]);
?>
<?

//$model = new \app\models\tables\Comments();
//use yii\helpers\Html;
//use yii\widgets\ActiveForm;
//$model->load(Yii::$app->request->post()) && $model
/* @var $this yii\web\View */
/* @var $model app\models\tables\Comments */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="comments-form">

    <?php $form = \yii\widgets\ActiveForm::begin(); ?>

    <?=$form->field($model, 'comment_text')->textarea([
            'rows' => 6,
        ])?>

    <?=$form->field($model, 'user_id')->hiddenInput([
            'value' => Yii::$app->user->identity->id
    ])->label(false)?>

    <?=$form->field($model, 'task_id')->hiddenInput([
            'value' => $taskId
    ])->label(false)?>

   <?=$form->field($modelFileUpload, 'file')->fileInput()?>

    <div class="form-group">
        <?= \yii\helpers\Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php \yii\widgets\ActiveForm::end(); ?>

</div>


