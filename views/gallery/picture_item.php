<h4>Картинка: "<?=$model->picture_title?>"</h4>

<?php
echo ('<img src = /img/' . $model->picture_source . '>') ?>
<p>
<?= \yii\helpers\Html::a('Delete', ['delete', 'id' => $model->id], [
    'class' => 'btn btn-danger',
    'data' => [
        'confirm' => 'Are you sure you want to delete this item?',
        'method' => 'post',
    ],
]) ?>
</p>



