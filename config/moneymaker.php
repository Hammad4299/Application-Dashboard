<?php

return [
    'leaderboards'=>[
        'coin'=>[
            'name'=>'Coins',
            'id'=>1
        ],
        'ingot'=>[
            'name'=>'Ingots',
            'id'=>2
        ]
    ],
    'currency'=>'$',
    'backend_config'=>[
        'mappedName' => 'moneymaker',
        'routePrefix' => 'money-maker',
        'routeNamePrefix' => 'moneymaker.',
        'viewPrefix' =>'moneymaker.',
        'controllerNamespace'=>'App\Http\Controllers\MoneyMaker'
    ]
];
