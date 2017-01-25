<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */
$searchModelClass = StringHelper::basename($generator->searchModelClass);
$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use yii\helpers\Html;
use kartik\date\DatePicker;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\export\ExportMenu;
use <?= $generator->indexWidgetType === 'grid' ? "kartik\\grid\\GridView" : "yii\\widgets\\ListView" ?>;

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
$this->params['breadcrumbs'][] = $this->title;
$columnExport=[
<?php
$count = 0;
$tableSchema = $generator->getTableSchema();
    foreach ($tableSchema->columns as $column) {
        $format = $generator->generateColumnFormat($column);
        if (!StringHelper::hideColumn($column->name)) {
            echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        } else {
            echo "            // '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        }
    }

?>
];
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-sm-11">Filter</div>
            <div class="col-sm-1">
            <?= "<?= " ?>ExportMenu::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => $columnExport,
                            'showConfirmAlert' => false,
                            'showColumnSelector' => false,
                            'target' => ExportMenu::TARGET_SELF,
                            'exportConfig' => [
                                ExportMenu::FORMAT_HTML => false,
                                ExportMenu::FORMAT_EXCEL => false,
                                ExportMenu::FORMAT_EXCEL_X => false,
                                ExportMenu::FORMAT_PDF => false,
                                ExportMenu::FORMAT_TEXT => false,
                                ExportMenu::FORMAT_CSV => [
                                        'label' => 'Export CSV'
                                ]
                            ],
                            'filename' => date('Y-m-d'),
                            
            ]); 
            ?>
            </div>
        </div><!--end row-->
    </div><!--end panel-heading-->  

    <div class="panel-body">
        <div class="form" style="display:none">
            <?="<?php \n"?>             $form = ActiveForm::begin([
                        'action'=>['index'],
                        'method'=>'get',
                        'id'=>$model->formName(),
                        'enableAjaxValidation'=>true,
                        //'validationUrl'=>Url::toRoute('<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>/validation')
            ]);
            ?>
            <div class="row">
                <div class="col-sm-3">
                    <?= "<?="?> DatePicker::widget([
                            'model' => $model,
                            'attribute' => 'startDate',
                            'readonly' => true,
                            'form' => $form,
                            'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                            'value' => isset($_GET['<?=$searchModelClass?>'])?$_GET['<?=$searchModelClass?>']['startDate']:date('Y-m-d'),
                            'pluginOptions' => [
                                'autoclose'=>true,
                            ]
                    ]);
                    ?>
                </div>
                <div class="col-sm-3">
                    <?= "<?="?> DatePicker::widget([
                            'model' => $model,
                            'attribute' => 'endDate',
                            'readonly' => true,
                            'form' => $form,
                            'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                            'value' => isset($_GET['<?=$searchModelClass?>'])?$_GET['<?=$searchModelClass?>']['endDate']:date('Y-m-d'),
                            'pluginOptions' => [
                                'autoclose'=>true,
                                // 'format' => 'dd-M-yyyy'
                            ]
                    ]);
                    ?>
                </div>
            </div><!--row-->
            <div class="form-group">
                <?="<?="?> Html::submitButton('View',['class'=>'btn btn-success','id'=>'view_button'])?>
            </div>
            <?="<?php"?> ActiveForm::end();?>
        </div><!--form-->
        <div class="form-group">
            <?="<?="?> Html::button('Filter', ['class' => 'btn btn-success','id' => 'filter_button']);?>
        </div>
    </div><!--panel body-->
</div><!--panel-->
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index">

    <h1><?= "<?= " ?>Html::encode($this->title) ?></h1>
<?php if(!empty($generator->searchModelClass)): ?>
<?= "    <?php " . ($generator->indexWidgetType === 'grid' ? "// " : "") ?>echo $this->render('_search', ['model' => $searchModel]); ?>
<?php endif; ?>

    

<?php if ($generator->indexWidgetType === 'grid'): ?>
    <?= "<?php " ?>Pjax::begin(['enablePushState'=>false,'id'=>'<?php echo Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-grid']); ?>
    <?= "<?= " ?>GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $columnExport,
        'filterSelector' => "input[name='".$dataProvider->getPagination()->pageSizeParam."'],input[name='".$dataProvider->getPagination()->pageParam."']",
            'hover' => true,
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<h4>'.Html::encode($this->title).'</h4>'
            ],
            'export' => false,
            'toggleData' => false,
            'columns' => $columnExport,
    ]); ?>
    <?= "<?php " ?>Pjax::end(); ?>
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
<?= "<?php " ?> 
$url = $_SERVER["SCRIPT_NAME"].'?r='.$this->context->id;
$showGrid = isset($_GET)?true:false;
$js = <<<JS
    var ganteng = $(".<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index");
        if ('$showGrid') 
            if (ganteng.css('display')=='none') 
                ganteng.css({"display":""});
    $("#filter_button").on("click",function(){
        $(".form").toggle("slow");
        $("#filter_button").toggle("slow");     
    });     
JS;
$this->registerJs($js);
?>