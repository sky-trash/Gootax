<?php

// Проверяем, не подключен ли уже Yii
if (!class_exists('yii\BaseYii', false)) {
  require __DIR__ . '/vendor/autoload.php';
  require __DIR__ . '/vendor/yiisoft/yii2/Yii.php';
}

$config = [
  'id' => 'reset',
  'basePath' => __DIR__,
  'components' => [
    'db' => [
      'class' => 'yii\db\Connection',
      'dsn' => 'sqlite:' . __DIR__ . '/feedback.db',
      'username' => '',
      'password' => '',
      'charset' => 'utf8',
    ],
  ],
];

$app = new yii\console\Application($config);

try {
  echo "=== СБРОС БАЗЫ ДАННЫХ ===\n\n";

  echo "Вы уверены, что хотите сбросить базу данных? (yes/no): ";
  $handle = fopen("php://stdin", "r");
  $line = fgets($handle);
  fclose($handle);

  if (trim($line) != 'yes') {
    echo "Отменено.\n";
    exit(0);
  }

  echo "1. Удаление таблиц...\n";

  // Удаляем таблицы в правильном порядке (с учетом foreign keys)
  $tables = ['review', 'user', 'city'];

  foreach ($tables as $table) {
    try {
      $app->db->createCommand()->dropTable($table)->execute();
      echo "✅ Таблица {$table} удалена\n";
    } catch (Exception $e) {
      echo "ℹ️  Таблица {$table} не существует или не может быть удалена: " . $e->getMessage() . "\n";
    }
  }

  echo "\n2. Запуск миграций...\n";
  $app->runAction('migrate/up', ['interactive' => false]);
  echo "✅ Миграции выполнены\n";

  echo "\n3. Очистка загруженных файлов...\n";
  $uploadDir = 'web/uploads/reviews';
  if (is_dir($uploadDir)) {
    $files = glob($uploadDir . '/*');
    foreach ($files as $file) {
      if (is_file($file)) {
        unlink($file);
      }
    }
    echo "✅ Загруженные файлы удалены\n";
  }

  echo "\n4. Очистка кеша...\n";
  if (is_dir('runtime/cache')) {
    $files = glob('runtime/cache/*');
    foreach ($files as $file) {
      if (is_file($file)) {
        unlink($file);
      }
    }
    echo "✅ Кеш очищен\n";
  }

  echo "\n🎉 БАЗА ДАННЫХ СБРОШЕНА!\n";
  echo "Теперь запустите setup-complete.php для начальной настройки.\n";
} catch (Exception $e) {
  echo "❌ Ошибка сброса: " . $e->getMessage() . "\n";
}
