<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'modules' => [
        'admin' => [
            'class' => 'mdm\admin\Module',
            // 'layout' => 'left-menu',
            'mainLayout' => '@app/views/layouts/main.php',
        ],
        'menus' => [
                'assignment' => [
                    'label' => 'Grant Access' // change label
                ],
                'route' => null, // disable menu
            ],
 	],
 	'as access' => [
            'class' => 'mdm\admin\components\AccessControl',
            'allowActions' => [
                'site/*',
        ],
    ],
    'components' => [
    	'authManager' => [
            'class' => 'yii\rbac\DbManager',
            // 'defaultRoles' => ['admin', 'author'],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
