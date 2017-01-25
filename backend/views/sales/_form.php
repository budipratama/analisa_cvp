<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use kartik\datetime\DateTimePicker;
/* @var $this yii\web\View */
/* @var $model backend\models\Sales */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sales-form">

    <?php $form = ActiveForm::begin(['id'=>$model->formName()]); ?>

    <?= $form->field($model, 'date')->widget(DateTimePicker::classname(), [
            'options' => ['placeholder' => 'Date'],
            'pluginOptions' => [
                'autoclose' => true
            ]
        ]);
    ?>

    <?= $form->field($model, 'unit')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
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
                $('#modal').modal('hide');
                $.pjax.reload({container:"#sales-grid",async:false});    
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