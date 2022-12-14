<?php
declare(strict_types=1);

use yii\console\controllers\MigrateController;
use yii\redis\Cache;

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'cache' => [
            'class' => Cache::class,
        ],
    ],
    'controllerMap' => [
        'migrate' => [
            'class' => MigrateController::class,
            'migrationPath' => null,
            'migrationNamespaces' => [
                'console\migrations',
            ],
        ],
    ],
    'language' => 'en',
    'timeZone' => 'UTC',
    'vendorPath' => dirname(__DIR__, 2) . '/vendor',
];
