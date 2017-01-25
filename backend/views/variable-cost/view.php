<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\VariableCost */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Variable Costs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="variable-cost-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'date',
            'name',
            'description',
            'price',
        ],
    ]) ?>

</div>
