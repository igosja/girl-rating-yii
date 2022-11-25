<?php
declare(strict_types=1);

use yii\debug\Module as DebugModule;
use yii\gii\Module as GiiModule;

$config = [
    'components' => [
        'request' => [
            'cookieValidationKey' => '',
        ],
    ],
];

if (!YII_ENV_TEST) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'allowedIPs' => ['*'],
        'class' => DebugModule::class,
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'allowedIPs' => ['*'],
        'class' => GiiModule::class,
    ];
}

return $config;
