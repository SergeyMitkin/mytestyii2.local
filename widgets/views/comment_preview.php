<?php
use yii\helpers\Url;
/** @var $model \app\models\tables\Comments */

$model2 = new \app\models\tables\Picture();
$query = $model2::getByCommentQuery($model->id);
$dataProvider = new \yii\data\ActiveDataProvider([
    'query' => $query
]);

?>

<div class="task-container">
    <a class="task-preview-link" href="<?= Url::to(['comment/one', 'id' => $model->id]); ?>">
        <div class="comment-preview">
            <div class="task-preview-user">Комментарий пользователя <?= $model->user->login ?>: </div>
            <div class="task-preview-header"><?= $model->comment_text ?></div>
    <?= \yii\widgets\ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => function ($model2) {
                return \app\widgets\PicturePreview::widget(['model' => $model2]);
            },
            'summary' => false,
            'showOnEmpty' => true,
            'options' => [
                'class' => 'preview-container'
            ]
        ]);
   ?>
        </div>
        </a>
</div>
