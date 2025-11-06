<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'feedback-system',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'], // Убрали 'debug', 'gii'
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'your-cookie-validation-key-here',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@runtime/cache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['auth/login'],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'confirm-email/<token:\w+>' => 'auth/confirm-email',
                'city/<id:\d+>' => 'review/city',
                'author/<id:\d+>' => 'review/author',
                'login' => 'auth/login',
                'register' => 'auth/register',
                'logout' => 'auth/logout',
                'my-reviews' => 'review-manage/index',
                'create-review' => 'review-manage/create',
                '' => 'site/index',
                '<action:\w+>' => 'site/<action>',
            ],
        ],
        'ipGeo' => [
            'class' => 'app\components\IpGeoService',
        ],
        'session' => [
            'class' => 'yii\web\Session',
            'timeout' => 7200,
        ],
        'cityApi' => [
            'class' => 'app\components\CityApiService',
            'apiKey' => 'your-api-key-here',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
            'fileTransportPath' => '@runtime/mail',
        ],
    ],
    'params' => $params,
];

// Закомментируем debug и gii для production
/*
if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}
*/

return $config;
