<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\tables\Users */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-form">

    <?php $form = ActiveForm::begin();
    // В модель или контроллер:
    /*
     $roles_values = \Yii::$app->db->createCommand('SELECT DISTINCT item_name FROM auth_assignment')
        ->queryColumn();

    $roles = array_combine($roles_values, $roles_values);
    */

    /*$params = [
            'prompt' => 'Выберите статус...'
    ];*/
    ?>

    <?= $form->field($model, 'login')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model2, 'item_name')->dropDownList($model2->getRolesArray()) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
