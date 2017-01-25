<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
// use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model backend\models\ActivityHistory */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
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
                $("#modal-2").modal('hide');
                $.pjax.reload({container:"#activity-history-grid"});                 
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
$this->registerJs($js);?>

<div class="activity-history-form">
    <?php $form = ActiveForm::begin(['id'=>$model->formName()]); ?>

    <?= $form->field($model, 'iduser')->textInput() ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'berita')->textInput() ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'ip')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
