<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\FixedCost */

$this->title = 'Create Fixed Cost';
$this->params['breadcrumbs'][] = ['label' => 'Fixed Costs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fixed-cost-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
