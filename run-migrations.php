<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/yiisoft/yii2/Yii.php';

$config = [
  'id' => 'blog-console',
  'basePath' => dirname(__DIR__),
  'components' => [
    'db' => [
      'class' => 'yii\db\Connection',
      'dsn' => 'sqlite:' . __DIR__ . '/blog.db',
      'charset' => 'utf8',
    ],
  ],
];

$app = new yii\console\Application($config);

try {
  // Запускаем миграции
  echo "Running migrations...\n";
  $result = $app->runAction('migrate/up', ['migrationPath' => '@app/migrations', 'interactive' => false]);
  echo "Migrations completed successfully!\n";
} catch (Exception $e) {
  echo "Migration failed: " . $e->getMessage() . "\n";
  echo $e->getTraceAsString() . "\n";
}
