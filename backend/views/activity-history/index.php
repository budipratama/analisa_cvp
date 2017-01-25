<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ActivityHistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Activity Histories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activity-history-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Activity History', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(['id' => 'activity-history-grid','enablePushState'=>false]) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,

        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            'iduser',
            'username',
            'berita',
            'date',
            // 'ip',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end() ?>
</div>

<?php
$js = <<<JS
$('form#{$searchModel->formName()}').on('beforeSubmit',function(e){
    var \$form = $(this);
    $.pjax.reload({url:\$form.attr('action')+'&'+\$form.serialize(),container:"#activity-history-grid",async:false,replace:false});                 
    return false;
});
    
JS;
$this->registerJs($js);
?>