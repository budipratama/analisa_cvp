<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ActivityHistorySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="activity-history-search">
<?= $model->formName();?>
    <?php 
        $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'post',
            'id'=>$model->formName(),
        ]); 
    ?>

    
    <?= $form->field($model, 'iduser') ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'berita') ?>

    <?= $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'ip') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary-budi']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>
   
</div>


