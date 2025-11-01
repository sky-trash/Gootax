<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/yiisoft/yii2/Yii.php';

$config = [
  'dsn' => 'sqlite:' . __DIR__ . '/blog.db',
  'charset' => 'utf8',
];

try {
  $db = new yii\db\Connection($config);
  $db->open();
  echo "SQLite database connection successful!\n";

  // Проверим, можем ли создать таблицу
  $db->createCommand('CREATE TABLE IF NOT EXISTS test (id INTEGER PRIMARY KEY)')->execute();
  echo "Test table created successfully!\n";
} catch (Exception $e) {
  echo "Database connection failed: " . $e->getMessage() . "\n";
}
