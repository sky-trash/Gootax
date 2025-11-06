<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/yiisoft/yii2/Yii.php';

// Создаем простое приложение для тестирования
$config = [
    'id' => 'test',
    'basePath' => __DIR__,
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'sqlite:' . __DIR__ . '/blog.db',
            'username' => '',
            'password' => '',
            'charset' => 'utf8',
        ],
    ],
];

new yii\console\Application($config);

try {
    // Тестируем модели
    $user = app\models\User::findOne(1);
    if ($user) {
        echo "User found: " . $user->username . "\n";
    } else {
        echo "No users found\n";
    }
    
    $posts = app\models\Post::find()->all();
    echo "Number of posts: " . count($posts) . "\n";
    
    foreach ($posts as $post) {
        echo "- " . $post->title . " (by " . ($post->author->username ?? 'Unknown') . ")\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}