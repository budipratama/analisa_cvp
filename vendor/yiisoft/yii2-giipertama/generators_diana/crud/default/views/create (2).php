<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

echo "<?php\n";
?>

use kartik\helpers\Html;


/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = <?= $generator->generateString('Create ' . Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-create col-sm-6">

    <?= "<?= Html::panel([
            'heading' => '<b class=\"title\">'.Html::encode(\$this->title).'</b> '.Yii::\$app->controllers->createMenuOperation(['page'=>'create']),
            'body' => '<div class=\"panel-body\">'.\$this->render('_form',['model' => \$model,]).'</div>'\n],\nHtml::TYPE_SUCCESS);
        ?>" ?>
    
    
</div>
