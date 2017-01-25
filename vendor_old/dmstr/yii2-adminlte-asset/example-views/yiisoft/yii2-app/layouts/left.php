<?php
use mdm\admin\components\MenuHelper;
?>
<aside class="main-sidebar">

    <section class="sidebar">
        <i class="fa fa-angle-left pull-right"></i>
        <?php //echo "<pre>";print_r(MenuHelper::getAssignedMenu(Yii::$app->user->id));echo "</pre>";?>
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => 
                    MenuHelper::getAssignedMenu(Yii::$app->user->id)
                // [
                //     ['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
                //     ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii']],
                //     ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug']],
                //     ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                //     [
                //         'label' => 'Same tools',
                //         'icon' => 'fa fa-share',
                //         'url' => '#',
                //         'items' => [
                //             ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii'],],
                //             ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug'],],
                //             [
                //                 'label' => 'Level One',
                //                 'icon' => 'fa fa-circle-o',
                //                 'url' => '#',
                //                 'items' => [
                //                     ['label' => 'Level Two', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                //                     [
                //                         'label' => 'Level Two',
                //                         'icon' => 'fa fa-circle-o',
                //                         'url' => '#',
                //                         'items' => [
                //                             ['label' => 'Level Three', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                //                             ['label' => 'Level Three', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                //                         ],
                //                     ],
                //                 ],
                //             ],
                //         ],
                //     ],
                // ],
            ]
        ) ?>

    </section>

</aside>
