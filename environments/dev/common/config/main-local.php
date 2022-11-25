<?php
declare(strict_types=1);

use yii\db\Connection as DbConnection;
use yii\redis\Connection as RedisConnection;
use yii\symfonymailer\Mailer;

return [
    'components' => [
        'db' => [
            'class' => DbConnection::class,
            'dsn' => 'mysql:host=mysql;dbname=yii-girl-rating',
            'username' => 'yii',
            'password' => 'password',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => Mailer::class,
            'viewPath' => '@common/mail',
            'useFileTransport' => true,
        ],
        'redis' => [
            'class' => RedisConnection::class,
            'database' => 0,
            'hostname' => 'redis',
            'port' => 6379,
        ],
    ],
];
