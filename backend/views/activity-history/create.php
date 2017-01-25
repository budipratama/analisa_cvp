<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ActivityHistory */

$this->title = 'Create Activity History';
$this->params['breadcrumbs'][] = ['label' => 'Activity Histories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activity-history-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
