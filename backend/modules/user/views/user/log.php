<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\user\models\ActivityHistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Activity Histories';
$this->params['breadcrumbs'][] = $this->title;
 // print_r(Yii::$app->request->queryParams)
?>
<div class="activity-history-index">

    <button type="button" class="btn btn-primary-budi" id="search-data">Advanced Search</button>
    <br><br>
    <?php Pjax::begin(['id'=>'virtual-grid']); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'hover' => true,
        'emptyTextOptions'=>['class'=>'empty'],
        'filterSelector' => "input[name='".$dataProvider->getPagination()->pageSizeParam."'],input[name='".$dataProvider->getPagination()->pageParam."']",
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<h4>'.Html::encode($this->title).'</h4>',
        ],
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],
            'username',
            'berita',
            'date',
            'ip',
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
<?php
    Modal::begin([
        'header' => '<h4>Advanced Search</h4>',
        'id' => 'advanced-search',
        'size' => 'modal-lg',        
    ]);
    echo "{$this->render('_search_log', ['model' => $searchModel])}";
    Modal::end();
?>

<?php
$url = $_SERVER["SCRIPT_NAME"].'?r='.$this->context->id;

$js = <<<JS
    $('#search-data').on('click',function(){
        $('#advanced-search').modal('show');
    });

    $('form#{$searchModel->formName()}').on('beforeSubmit',function(e){
        $('#advanced-search').modal('hide');
        var \$form = $(this);
        $.pjax.reload({url:\$form.attr('action')+'&'+\$form.serialize(),container:"#virtual-grid",async:false,replace:false});                 
        return false;
    });
    
JS;
$this->registerJs($js);
?>