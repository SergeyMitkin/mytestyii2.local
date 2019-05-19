<?php
echo \yii\widgets\ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => function($model){
        return \app\widgets\PicturePreview::widget([
            'model' => $model
        ]);
    },
    'summary' => false,
    'options' => [
        'class' => 'preview-container'
    ]
]);
?>
<p>Загрузите картинку</p>
<?php
$form = \yii\widgets\ActiveForm::begin();
echo $form->field($model, 'picture_title')->textInput();
echo $form->field($modelFileUpload, 'file')->fileInput();
echo \yii\helpers\Html::submitButton('Send', ['class' => 'btn btn-success']);
\yii\widgets\ActiveForm::end();