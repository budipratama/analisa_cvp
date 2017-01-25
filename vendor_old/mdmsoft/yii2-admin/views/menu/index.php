<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mdm\admin\models\searchs\Menu */

$this->title = Yii::t('rbac-admin', 'Menus');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-index">
    <p>
    <?=
        Yii::$app->Controllers->createMenuOperation([
                    'page'=>'index',
                    'aksi'=>[                        
                        'create' => [
                            'params' => ['#'],
                            'options' => [
                                'onclick' => 'create(\''.Url::to(['menu/create'], true).'\')'
                            ],
                        ],                                            
                    ],
                ])
                ?>
    </p>
    <button type="button" class="btn btn-primary-budi" id="search-data">Advanced Search</button>
    <br><br>
    <?php
    Pjax::begin(['formSelector' => 'form', 'enablePushState' => false]);
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'hover' => true,
        'filterSelector' => "input[name='".$dataProvider->getPagination()->pageSizeParam."'],input[name='".$dataProvider->getPagination()->pageParam."']",
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<h4>'.Html::encode($this->title).'</h4>',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'attribute' => 'menuParent.name',
                'filter' => Html::activeTextInput($searchModel, 'parent_name', [
                    'class' => 'form-control', 'id' => null
                ]),
                'label' => Yii::t('rbac-admin', 'Parent'),
            ],
            'route',
            'order',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    Pjax::end();
    ?>

</div>
