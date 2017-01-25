<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Sign In';

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>

<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>BINTAN BATAM</b> TELEKOMUNIKASI</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Change Password </p>

        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>
        <div class="hide">
            <?= $form
                ->field($model, 'username', ['inputOptions'=>['value'=>$username,'readonly'=>'readonly']])
                ->textInput(['placeholder' => $model->getAttributeLabel('username')]) 
            ?>    
        </div>

        <?= $form->field($model, 'old_password', $fieldOptions2)->passwordInput()
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('old_password')]) ?>
        
        <?= $form->field($model, 'new_password', $fieldOptions2)->passwordInput()
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('new_password')])
        ?>
        
        <?= $form->field($model, 'repeat_password', $fieldOptions2)->passwordInput()
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('repeat_password')])
         ?>
              
        <div class="row">
            <div class="col-xs-8">
                <?php //$form->field($model, 'rememberMe')->checkbox() ?>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <?= Html::submitButton('Sign in', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
            </div>
            <!-- /.col -->
        </div>


        <?php ActiveForm::end(); ?>       

    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->
