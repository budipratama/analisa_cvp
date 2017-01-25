<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use yii\helpers\Html;
use <?= $generator->indexWidgetType === 'grid' ? "kartik\\grid\\GridView" : "yii\\widgets\\ListView" ?>;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index">
    <p>
        <?="<?=
            Yii::\$app->Controllers->createMenuOperation([
                    'page'=>'index',
                    'aksi'=>[                        
                        'create' => [
                            'params' => ['#'],
                            'options' => [
                                'onclick' => 'create(\''.Url::to([Yii::\$app->controller->id.'/create'], true).'\')'
                            ],
                        ],                                            
                    ],
            ]);
        ?>\n\t</p>\n";?>
    <button type="button" class="btn btn-primary-budi" id="search-data">Search</button>
    <br><br>    
    
<?php if ($generator->indexWidgetType === 'grid'): ?>
    <?="<?php Pjax::begin(['id'=>'".Inflector::camel2id(StringHelper::basename($generator->modelClass))."-grid','enablePushState'=>false]);?>\n";?>
    <?= "<?= " ?>GridView::widget([
        'dataProvider' => $dataProvider,
        <?= !empty($generator->searchModelClass) ? "'hover' => true,\n\t\t'filterSelector' => \"input[name='\".\$dataProvider->getPagination()->pageSizeParam.\"'],input[name='\".\$dataProvider->getPagination()->pageParam.\"']\",\n\t\t'panel'=>[\n\t\t\t'type'=>GridView::TYPE_PRIMARY,\n\t\t\t'heading'=>'<h4>'.Html::encode(\$this->title).'</h4>'\n\t\t],\n        'columns' => [\n" : "'columns' => [\n"; ?>
<?php
$count = 0;
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        if (StringHelper::hideColumn($name)) {
            echo "            '" . $name . "',\n";
        } else {
            echo "            // '" . $name . "',\n";
        }
    }
} else {
    foreach ($tableSchema->columns as $column) {
        $format = $generator->generateColumnFormat($column);
        if (!StringHelper::hideColumn($column->name)) {
            echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        } else {
            echo "            // '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        }
    }
}
?>            [
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
    <?="<?php Pjax::end();?>";?>
<?php else: ?>
    <?= "<?= " ?>ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model-><?= $nameAttribute ?>), ['view', <?= $urlParams ?>]);
        },
    ]) ?>
<?php endif; ?>

</div>
<?="<?php
    Modal::begin([
        'header' => '<h4>Advanced Search</h4>',
        'id' => 'advanced-search',
        'size' => 'modal-lg',        
    ]);
    echo \$this->render('_search', ['model' => \$searchModel]);
    Modal::end();
?>";?>

<?="<?php
\$url = \$_SERVER[\"SCRIPT_NAME\"].'?r='.\$this->context->id;

\$js = <<<JS
    $('#search-data').on('click',function(){
        $('#advanced-search').modal('show');
    });
    $('form#{\$searchModel->formName()}').on('beforeSubmit',function(e){
        $('#advanced-search').modal('hide');";?>

        var \$form = $(this);
        $.pjax.reload({url:\$form.attr('action')+'&per-page='+$("input[name='per-page']").val()+'&'+\$form.serialize(),container:"#<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-grid",async:false,replace:false});                 
        return false;
    });
    
    <?="$(document).on('ready pjax:success', function() {
        $('.update').on('click',function(){
            var id = $(this).closest('tr').data('key');
            $('#modal').modal('show')
                .find('#modalContent')
                .load('\$url/update&id='+id);
        });
        
        $('.view').on('click',function(){
            var id = $(this).closest('tr').data('key');
            $('#modal').modal('show')
                .find('#modalContent')
                .load('\$url/view&id='+id);
        });
    });
    
JS;
\$this->registerJs(\$js);
?>";?>