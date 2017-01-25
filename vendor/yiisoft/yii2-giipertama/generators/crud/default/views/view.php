<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = $model-><?= $generator->getNameAttribute() ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-view">

    <div class="panel panel-success">
        <div class="panel-heading">
            <?= "<?= Yii::\$app->controllers->createMenuOperation([
                    'page' => 'view',
                    'aksi' => [
                        'update' => [
                            'params' => ['id' => \$model->".$generator->getNameAttribute()."]
                        ],
                        'delete' => [
                            'params' => ['id' => \$model->".$generator->getNameAttribute()."],
                            'msg' => ['text' => ".$generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))).".\$model->".$generator->getNameAttribute()."]
                        ],
                    ]
            ]); ?>\n " ?>
            <h1 class="panel-title-custom"><?= "<?= " ?>Html::encode($this->title) <?= "?>" ?></h1>
        </div>
        <div class="panel-body">
            <?= "<?= " ?>DetailView::widget([
                'model' => $model,
                'attributes' => [
                <?php
                if (($tableSchema = $generator->getTableSchema()) === false) {
                    foreach ($generator->getColumnNames() as $name) {
                        if(($name != 'first_update') && ($name != 'first_user') && ($name != 'first_ip') && ($name != 'last_update') && ($name != 'last_user') && ($name != 'last_ip')){
                            echo "            '" . $name . "',\n";
                        }
                    }
                } else {
                    foreach ($generator->getTableSchema()->columns as $column) {
                        if(($column->name != 'first_update') && ($column->name != 'first_user') && ($column->name != 'first_ip') && ($column->name != 'last_update') && ($column->name != 'last_user') && ($column->name != 'last_ip')){
                            $format = $generator->generateColumnFormat($column);
                            echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
                        }
                    }
                }
                ?>
                ],
            ]) ?>
            <?php // Yii::$app->controllers->info($model) ?>
        </div>
    </div>

</div>
