<?php
declare(strict_types=1);

use common\models\User;
use yii\log\DbTarget;
use yii\redis\Session;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'assetManager' => [
            'appendTimestamp' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => DbTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
            'traceLevel' => YII_DEBUG ? 3 : 0,
        ],
        'request' => [
            'baseUrl' => '/admin',
            'csrfParam' => '_csrf-backend',
        ],
        'session' => [
            'class' => Session::class,
            'name' => 'advanced-backend',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'rules' => [
                '' => 'site/index',
                'login' => 'site/login',
                'logout' => 'site/logout',
                '<controller:\w+>/' => '<controller>/index',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>/' => '<controller>/<action>',
            ],
            'showScriptName' => false,
        ],
        'user' => [
            'enableAutoLogin' => true,
            'identityClass' => User::class,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
    ],
    'controllerNamespace' => 'backend\controllers',
    'id' => 'app-backend',
    'modules' => [],
    'params' => $params,
];
