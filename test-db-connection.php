<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/yiisoft/yii2/Yii.php';

try {
  $db = new yii\db\Connection([
    'dsn' => 'sqlite:' . __DIR__ . '/blog.db',
    'username' => '',
    'password' => '',
    'charset' => 'utf8',
  ]);

  $db->open();
  echo "SQLite database connection successful!\n";

  // Проверим существующие таблицы
  $tables = $db->createCommand("SELECT name FROM sqlite_master WHERE type='table'")->queryAll();
  echo "Existing tables:\n";
  foreach ($tables as $table) {
    echo "- " . $table['name'] . "\n";
  }
} catch (Exception $e) {
  echo "Database connection failed: " . $e->getMessage() . "\n";
}
