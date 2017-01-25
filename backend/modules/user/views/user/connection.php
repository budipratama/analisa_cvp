<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\user\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users Connection';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
<br>
<br>
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
            'lastvisit:datetime',

            [
                'class'     => 'yii\grid\ActionColumn',
                'header'    => 'Actions',
                'template'  => '{kick}',
                'buttons'   =>[
                                'kick'=> function($url,$model){
                                    return ($model->id !=\Yii::$app->user->identity->id)?Html::a(Html::img('@web/../img/kick.png',['class'=>'kick']), $url, [
                                        'title' => Yii::t('yii', 'Kick User'),

                                ]):'';
                                }
                ]

            ],
        ],
    ]); ?>

</div>
