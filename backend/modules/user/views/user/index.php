<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use yii\grid\ActionColumn;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\user\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <p>
    <?=
        Yii::$app->Controllers->createMenuOperation([
                    'page'=>'index',
                    'aksi'=>[                        
                        'create' => [
                            'params' => ['#'],
                            'options' => [
                                'onclick' => 'create(\''.Url::to(['user/create'], true).'\')'
                            ],
                        ],                                            
                    ],
                ])
                ?>
    </p>
    <button type="button" class="btn btn-primary-budi" id="search-data">Advanced Search</button>
    <br><br>
    <?php Pjax::begin(['id'=>'user-grid']); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'hover' => true,
        'emptyTextOptions'=>['class'=>'empty'],
        'filterSelector' => "input[name='".$dataProvider->getPagination()->pageSizeParam."'],input[name='".$dataProvider->getPagination()->pageParam."']",
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<h4>'.Html::encode($this->title).'</h4>',
        ],
        'rowOptions' => function($model){
            if ($model->status==10) 
                return ['class'=>'success'];
            else
                return ['class'=>'danger'];
        },
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],
            'username',
            'email:email',
            [
                'attribute'=>'status',
                'value' => function($model){
                    return Yii::$app->params['statusUser'][$model->status];
                }
            ],
            'created_at:datetime',
            [
                'attribute'=>'Status Login',
                'value'=> function ($model) {
                    return $model->flag_login? 'Login' : 'Logout';
                }
            ],
            [
                'attribute'=>'Role',
                'value'=> function ($model) {
                    return $model->usermode;
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'Actions',
                'buttons'=>[
                        'delete'=> function($url, $model){
                            return ($model->id !=\Yii::$app->user->identity->id)?Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                        'title' => Yii::t('yii', 'View'),
                                        'data-method'=>'post',
                                        'data-confirm' => "Are you sure you want to delete {$model->username}?"
                                ]):'';
                        },
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
                        }
                ]

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
    echo "{$this->render('_search', ['model' => $searchModel])}";
    Modal::end();
?>
<?php
$url = $_SERVER["SCRIPT_NAME"].'?r=user/'.$this->context->id;

$js = <<<JS
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

    $('#search-data').on('click',function(){
        $('#advanced-search').modal('show');
    });
    $('form#{$searchModel->formName()}').on('beforeSubmit',function(e){
        $('#advanced-search').modal('hide');
        var \$form = $(this);
        $.pjax.reload({url:\$form.attr('action')+'&'+\$form.serialize(),container:"#user-grid",async:false,replace:false});                 
        return false;
    });
    
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

    
JS;
$this->registerJs($js);
?>