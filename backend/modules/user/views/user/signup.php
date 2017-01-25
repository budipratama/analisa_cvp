<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */
//namespace backend\modules\user\models;

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\widgets\Select2;
use yii\widgets\MaskedInput;
use kartik\datetime\DateTimePicker;

$this->title = 'Create User';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to signup:</p>

    <div class="row">
        <div class="col-lg-12">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username') ?>

                <?= $form->field($model, 'email') ?>
                
                <?= $form->field($model, 'password')->passwordInput() ?>
                
                <?= $form->field($model, 'password_repeat')->passwordInput() ?>

                <?php
                    foreach ($roles as $row) {
                        $CT_IDS[$row['description']] = $row['description'];
                    }                               
                ?>
                <?= $form->field($model, 'usermode')->dropDownList($CT_IDS,['prompt'=>'Select Role']);
                ?>

                <?= $form->field($model, 'active_date')->widget(DateTimePicker::classname(), [
                        'options' => ['placeholder' => 'Active Date'],
                        'pluginOptions' => [
                            'autoclose' => true
                        ]
                    ]);
                ?>
                <?= $form->field($model, 'flag_multiple')->dropDownList(Yii::$app->params['flag_multiple']);
                ?>

                <?= $form->field($model, 'rtries_count',[
                            'inputOptions' => [
                                'value' => 3,
                            ],
                        ])->textInput() ;
                ?>
                
                <?= $form->field($model, 'passage1',[
                            'inputOptions' => [
                                'value' => 100,
                            ],
                        ])->textInput() ?>
                
                <?= $form->field($model, 'passage2',[
                            'inputOptions' => [
                                'value' => 100,
                            ],
                        ])->textInput() ?>

                <?= $form->field($model, 'ip',[
                            'inputOptions' => [
                                'value' => '*.*.*.*',
                            ],
                        ])->textInput() ?>
                
                
                         
                <div class="form-group">
                    <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
