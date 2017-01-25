<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\bootstrap\Modal;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use mdm\admin\components\MenuHelper;
use kartik\nav\NavX;
use kartik\widgets\Select2;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
    
<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'My Company',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [];
    if (Yii::$app->user->isGuest) {
        // $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = [
            'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
            'url' => ['/site/logout'],
            'linkOptions' => ['data-method' => 'post']
        ];
    }
    // echo "<pre>";print_r(MenuHelper::getAssignedMenu(Yii::$app->user->id));echo "</pre>";
    echo NavX::widget([
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items' => MenuHelper::getAssignedMenu(Yii::$app->user->id),
    ]);
    // echo '<div class="navbar-custom-menu">
    //         <ul class="nav navbar-nav navbar-right">
    //             <!-- User Account: style can be found in dropdown.less -->
    //             <li class="dropdown user user-menu">
    //                 <a href="#" class="dropdown-toggle" data-toggle="dropdown">
    //                     <img src="img/avatar5.png" class="user-image" alt="User Image">
    //                     <span class="hidden-xs">'.Yii::$app->user->identity->username.'</span>
    //                 </a>
    //                 <ul class="dropdown-menu">
    //                     <!-- User image -->
    //                     <li class="user-header">
    //                     <img src="img/avatar5.png" class="img-circle" alt="User Image">
    //                     <p>
    //                         '.Yii::$app->user->identity->username.' - '.Yii::$app->user->usermode.'
    //                         <small>Member since Nov. 2012</small>
    //                     </p>
    //                     </li>
                                  
    //                     <!-- Menu Footer-->
    //                     <li class="user-footer">
    //                     <div class="pull-left">
    //                         <a href="#" class="btn btn-default btn-flat">Profile</a>
    //                     </div>
    //                     <div class="pull-right">
    //                         <a href="/yii2_bbt_admin_lte/backend/web/index.php?r=site%2Flogout" data-method="post" class="btn btn-default btn-flat">Sign out</a>
    //                     </div>
    //                     </li>
    //                 </ul>
    //             </li>                          
    //         </ul>
    //     </div>';
    echo NavX::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    
    NavBar::end();
    ?>
    
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
<?php
    Modal::begin([
        'header' => '<h4>Modal</h4>',
        'id' => 'modal',
        'size' => 'modal-lg',
        // 'options'=>[
        //     'tabIndex'=>false
        // ]
    ]);
    echo "<div id='modalContent'></div>";
    Modal::end();
?>


</body>
</html>
<?php $this->endPage() ?>
