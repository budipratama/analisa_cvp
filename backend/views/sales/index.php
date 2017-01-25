<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SalesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sales';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-index">
    <p>
        <?=
            Yii::$app->Controllers->createMenuOperation([
                    'page'=>'index',
                    'aksi'=>[                        
                        'create' => [
                            'params' => ['#'],
                            'options' => [
                                'onclick' => 'create(\''.Url::to([Yii::$app->controller->id.'/create'], true).'\')'
                            ],
                        ],                                            
                    ],
            ]);
        ?>
	</p>
    <button type="button" class="btn btn-primary-budi" id="search-data">Search</button>
    <br><br>    
    
    <?php Pjax::begin(['id'=>'sales-grid','enablePushState'=>false]);?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'hover' => true,
		'filterSelector' => "input[name='".$dataProvider->getPagination()->pageSizeParam."'],input[name='".$dataProvider->getPagination()->pageParam."']",
		'panel'=>[
			'type'=>GridView::TYPE_PRIMARY,
			'heading'=>'<h4>'.Html::encode($this->title).'</h4>'
		],
        'columns' => [
            'date',
            'unit',
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
                'buttons' => [                        
                        'view'=> function($url, $model,$key){
                            return (Yii::$app->Controllers->checkAuthorizedUser('view'))?Html::a('<span class="glyphicon glyphicon-eye-open"></span>', '#', [
                                        'title' => Yii::t('yii', 'View'),
                                        'class' => 'view'
                            ]):'';
                        },
                        'update'=> function($url, $model,$key){
                            return (Yii::$app->Controllers->checkAuthorizedUser('update'))?Html::a('<span class="glyphicon glyphicon-pencil"></span>', '#', [
                                        'title' => Yii::t('yii', 'Update'),
                                        'class'=>'update',
                            ]):'';
                        },
                        'delete'=> function($url, $model,$key){
                            return (Yii::$app->Controllers->checkAuthorizedUser('delete'))?Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                        'title' => Yii::t('yii', 'Delete'),
                                        'data-method'=>'post',
                                        'data-confirm' => "Are you sure you want to delete?"
                                
                            ]):'';
                        },
                ],               
              ],
        ],
    ]); ?>
    <?php Pjax::end();?>
</div>
<?php
    Modal::begin([
        'header' => '<h4>Advanced Search</h4>',
        'id' => 'advanced-search',
        'size' => 'modal-lg',        
    ]);
    echo $this->render('_search', ['model' => $searchModel]);
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
        $.pjax.reload({url:\$form.attr('action')+'&per-page='+$("input[name='per-page']").val()+'&'+\$form.serialize(),container:"#sales-grid",async:false,replace:false});                 
        return false;
    });
    
    $(document).on('ready pjax:success', function() {
        $('.update').on('click',function(){
            var id = $(this).closest('tr').data('key');
            $('#modal').modal('show')
                .find('#modalContent')
                .load('$url/update&id='+id);
        });
        
        $('.view').on('click',function(){
            var id = $(this).closest('tr').data('key');
            $('#modal').modal('show')
                .find('#modalContent')
                .load('$url/view&id='+id);
        });
    });
    
JS;
$this->registerJs($js);
?>