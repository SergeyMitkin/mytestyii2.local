<p>Комментарий пользователя: <?=$userName?></p>
<p><?=$commentText?></p>

<?=\yii\widgets\ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => function($model){
    return \app\widgets\PicturePreview::widget([
        'model' => $model
    ]);
    },
    'summary' => false,
    'options'=> [
        'class' => 'preview-container'
    ],
    'showOnEmpty' => true,
])?>


