<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\daterange\DateRangePicker;
use yii\helpers\ArrayHelper;
use backend\modules\user\models\AuthItem;

/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['id'=>$model->formName()]); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password_hash')->passwordInput() ?>

    <?= $form->field($model, 'status')->widget(Select2::classname(), [
                        'options' => ['placeholder' => 'Select Status'],
                        'hideSearch' => false,
                        'data' => [10 => 'Active', 20 => 'Banned'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ]
                    ]);
    ?>

    <?= $form->field($model, 'flag_multiple')->widget(Select2::classname(), [
                        'options' => ['placeholder' => 'Select Multiple Login'],
                        'hideSearch' => false,
                        'data' => [0 => 'No', 1 => 'Yes'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ]
                    ]);
    ?>
    
    <?= 
        $form->field($model, 'active_date',['addon'=>['prepend'=>['content'=>'<i class="glyphicon glyphicon-calendar"></i>']],'options'=>['class'=>'drp-container form-group','readonly'=>'readonly']])->widget(DateRangePicker::classname(), [
            'useWithAddon'=>true,
            'convertFormat'=>true,
            'pluginOptions'=>[
                'singleDatePicker'=>true,
                'locale'=>[
                    'format'=>'Y-m-d',
                ],
            ]
        ]) 
    ?>

    <?= $form->field($model, 'rtries_count')->textInput() ?>

    <?= $form->field($model, 'passage1')->textInput() ?>

    <?= $form->field($model, 'passage2')->textInput() ?>
    <?php

    $data = AuthItem::find('distinct description')->where(['not',['description'=>'is null']])->asArray()->all();
    
    $ary = [];
    foreach ($data as $key => $value) {
        $ary[$value['description']]=$value['description'];
    }
    ?>
    <?= $form->field($model, 'usermode')->widget(Select2::classname(), [
                        'options' => ['placeholder' => 'Select Multiple Login'],
                        'hideSearch' => false,
                        'data' => $ary,
                        'pluginOptions' => [
                            'allowClear' => true
                        ]
                    ]);
    ?>
    
    <?= $form->field($model, 'ip')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$url = $_SERVER["SCRIPT_NAME"].'?r=user/'.$this->context->id;
$js = <<<JS
    $('form#{$model->formName()}').on('beforeSubmit',function(e){
        var \$form = $(this);
        $.post(
            \$form.attr('action'),// serialize yii2 form
            \$form.serialize()
        )
        .done(function(result){
            if (result == 1) 
            {
                $(\$form).trigger("reset");
                $("#modal").modal('hide');
                $.pjax.reload({container:'#user-grid',async:false}); 
            }
            else
            {
                $("#message").html(result);
            }
        })
        .fail(function(){
            console.log("server error");
        });
    return false;
    });
JS;
$this->registerJs($js);
?> 