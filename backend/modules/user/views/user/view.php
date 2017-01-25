<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1>View User <?= Html::encode($this->title) ?></h1>

  
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            
            'username',
            // 'auth_key',
            // 'password_hash',
            // 'password_reset_token',
            'email:email',
            // 'status',
            [
                'label'=>'Status',
                'value'=>$model->status==10?"Active":"Blocked"
            ],

            'created_at:datetime',
            'updated_at:datetime',
            // 'active_date',
            // 'rtries_count',
            // 'rtries_count_use',
            // 'change_pass_date',
            // 'passage1',
            // 'passage2',
            'usermode',
            // 'flag_multiple',
            [
                'label'=>'Double Login',
                'value'=>$model->flag_multiple?"Yes":"No"
            ],
            // 'last_action',
            'ip',
        ],
    ]) ?>

</div>
