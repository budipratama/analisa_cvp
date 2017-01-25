<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\FixedCost */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Fixed Costs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fixed-cost-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id_fixed_cost',
            'date',
            'name',
            'description',
            'price',
        ],
    ]) ?>

</div>
