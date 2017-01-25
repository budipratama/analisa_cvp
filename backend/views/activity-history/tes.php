<?php
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\grid\GridView;

?>
<?php Pjax::begin(); ?>
<?= Html::a("Refresh", ['activity-history/tes'], ['class' => 'btn btn-lg btn-primary-budi']);?>
<h1>Current time: <?= $time ?></h1>
<?php Pjax::end(); ?>

<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
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