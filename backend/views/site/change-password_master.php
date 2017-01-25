<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Change Password';
// $this->params['breadcrumbs'][] = $this->title;
//echo $session['id_user'];//['lifetime'];
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to login:</p>

    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <!-- <div style="display:none"> -->
                <?= $form->field($model, 'username',['inputOptions'=>['value'=>$username,'readonly'=>'readonly']]) ?>
                <!-- </div> -->
                <?= $form->field($model, 'old_password')->passwordInput() ?>
                
                <?= $form->field($model, 'new_password')->passwordInput() ?>
                
                <?= $form->field($model, 'repeat_password')->passwordInput() ?>
                
                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary-budi', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>


