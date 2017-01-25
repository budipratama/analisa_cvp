<?php
return [
    // keperluan untuk nilai default
    'adminEmail' => 'admin@example.com',
    'company'=>'BUDI PRATAMA',  
    'companyClient'=>'ANTRIAN',  
    'companyClient2'=>'ANTRIAN',  
    'defaultPage' => [
        'index' => ['create' => 'create'],
        'view' => ['index' => 'index','update' => 'update','delete' => 'delete'],
        'update' => ['index' => 'index','create' => 'create','view' => 'view'],
        'create' => ['index' => 'index'],
    ],
    'defaultIcon' => [
        'create' => ['label' => 'Create','icon' => 'glyphicon glyphicon-plus','url' => ['create']],
        'update' => ['label' => 'Update','icon' => 'glyphicon glyphicon-pencil'],
        'view' => ['label' => 'View','icon' => 'glyphicon glyphicon-eye-open'],
        'delete' => ['label' => 'Delete','icon' => 'glyphicon glyphicon-trash'],
        'index' => ['label' => 'List','icon' => 'glyphicon glyphicon-list','url' => ['index']]
    ], 
    // 'defaultPaginationPageSize' => 20, 
    'statusUser'=>[
        10 => 'Active',
        20 => 'Banned',
    ],
    'flag_multiple'=>[
        0 => 'No',
        1 => 'Yes'
    ]
    // param untuk web

];
