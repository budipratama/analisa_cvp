<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\FixedCost */

$this->title = 'Update Fixed Cost: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Fixed Costs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id_fixed_cost]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="fixed-cost-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
