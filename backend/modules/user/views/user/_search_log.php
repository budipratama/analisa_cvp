<?php

use yii\helpers\Html;
use kartik\typeahead\TypeaheadBasic;
use common\models\User;
use kartik\widgets\ActiveForm;
use kartik\daterange\DateRangePicker;
/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\ActivityHistorySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="activity-history-search">

    <?php 
        $form = ActiveForm::begin([
            'action' => ['log'],
             'method' => 'get',
        ]); 
    ?>

    <?php 
        if (Yii::$app->user->usermode!='developer') 
            $dataSql = User::findBySql('SELECT DISTINCT username FROM user WHERE usermode !="developer"')->asArray()->all();
        else
            $dataSql = User::findBySql('SELECT DISTINCT username FROM user')->asArray()->all();

        foreach ($dataSql as $row) {
            $CT_IDS[] = $row['username'];
        }
    ?>

    <?= $form->field($model, 'username')->widget(TypeaheadBasic::classname(), [
            'data' => $CT_IDS,
            'pluginOptions' => ['highlight' => true],
            'options' => ['placeholder' => 'All'],
        ]);
    ?>
    <?php
    echo $form->field($model, 'start_date', 
                        [
                            'addon'=>['prepend'=>['content'=>'<i class="glyphicon glyphicon-calendar"></i>']],
                            'options'=>['class'=>'drp-container form-group','readonly'=>'readonly']
                        ])->widget(DateRangePicker::classname(), [
        'useWithAddon'=>true,
        'convertFormat'=>true,
        'pluginOptions'=>[
            'locale'=>[
                'format'=>'Y-m-d',
            ],
        ]
    ]);
    ?>
    
     
    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script type="text/javascript">
/*
$("#w1").val("<?= date('Y-m-d')?>");
$("#activityhistorysearch-end_date").val("2015-09-12");
*/
</script>
