<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\VariableCost */

$this->title = 'Update Variable Cost: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Variable Costs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id_variable_cost]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="variable-cost-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
