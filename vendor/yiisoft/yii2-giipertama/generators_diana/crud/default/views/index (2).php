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

$gridColumns = [
    <?php
    $count = 0;
    if (($tableSchema = $generator->getTableSchema()) === false) {
        foreach ($generator->getColumnNames() as $name) {
            if(($name != 'first_update') && ($name != 'first_user') && ($name != 'first_ip') && ($name != 'last_update') && ($name != 'last_user') && ($name != 'last_ip')){
                if (++$count < 6) {
                    echo "            '" . $name . "',\n";
                } else {
                    echo "            // '" . $name . "',\n";
                }
            }
        }
    } else {
        foreach ($tableSchema->columns as $column) {
            if(($column->name != 'first_update') && ($column->name != 'first_user') && ($column->name != 'first_ip') && ($column->name != 'last_update') && ($column->name != 'last_user') && ($column->name != 'last_ip')){
                $format = $generator->generateColumnFormat($column);
                if (++$count < 6) {
                    echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
                } else {
                    echo "            // '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
                }
            }
        }
    }
    ?>
    ['class' => 'kartik\grid\ActionColumn'],
];
?>
    <div class="row">
        <div class="col-sm-6">
            <?= "<?= Html::button('Advanced Search',['id' => 'btn_search','class' => 'btn btn-success']) ?>\n" ?>
        </div>
        <div class="col-sm-6">
            <div class="row">
                <div class="col-sm-1 col-sm-offset-7"></div>
                <div class="col-sm-4">
                    <?= "<?= Yii::\$app->controllers->createMenuOperation([
                            'page'=>'index',
                        ]);
                    ?>\n" ?>
                </div>
            </div>
        </div>
    </div>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index">
    
<?php //!empty($generator->searchModelClass) ? "'filterModel' => \$searchModel,\n        'columns' => \$gridColumns,\n" : "'columns' => \$gridColumns,\n"; ?>     
<?php if ($generator->indexWidgetType === 'grid'): ?>
    <?= "<?php Pjax::begin(['id'=>'".Inflector::camel2id(StringHelper::basename($generator->modelClass))."-grid','enablePushState'=>false]); ?>" ?>
    <?= "<?= " ?>GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns, 
        'filterSelector' => <?= '"input[name=\'".$dataProvider->getPagination()->pageSizeParam."\'],input[name=\'".$dataProvider->getPagination()->pageParam."\']"'.",\n" ?>
        'hover' => true,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => <?= "'<b class=\"title\">'."."Html::encode(\$this->title)".".'</b>'\n" ?>
        ],
        'export' => false,
        'toggleData' => false,
    ]); ?>
    <?= "<?php Pjax::end(); ?>" ?>
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

<?= "<?php
    Modal::begin([
            'header' => '<b>Advanced Search</b>',
            'id' => 'modal_search',
            'size' => 'modal_sm',
    ]);
    echo \$this->render('_search', ['model' => \$searchModel]);
    Modal::end();
?>\n" ?>

<?= "<?php 
\$js = <<<JS
	$('form#{\$searchModel->formName()}').on('beforeSubmit',function(e){
		$('#modal_search').modal('hide');
		var \$form = $(this);
		$.pjax.reload({url:\$form.attr('action')+'&per-page='+$(\"input[name='per-page']\").val()+'&'+\$form.serialize(),container:\"#gridData\",async:false,replace:false});return false;
	});
JS;
\$this->registerJs($js);
?>" ?>