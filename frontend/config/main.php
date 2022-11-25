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
            'baseUrl' => '',
            'csrfParam' => '_csrf-frontend',
        ],
        'session' => [
            'class' => Session::class,
            'name' => 'advanced-frontend',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'rules' => [
                '' => 'site/index',
                '<controller:\w+>' => '<controller>/index',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>/' => '<controller>/<action>',
            ],
            'showScriptName' => false,
        ],
        'user' => [
            'enableAutoLogin' => true,
            'identityClass' => User::class,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
    ],
    'controllerNamespace' => 'frontend\controllers',
    'id' => 'app-frontend',
    'params' => $params,
];
