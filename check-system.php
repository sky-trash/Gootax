<?php

echo "=== ПРОВЕРКА СИСТЕМЫ ===\n\n";

// Проверяем PHP версию
echo "1. PHP версия: " . PHP_VERSION . " ";
if (version_compare(PHP_VERSION, '8.0.0') >= 0) {
  echo "✅ OK\n";
} else {
  echo "❌ Требуется PHP 8.0+\n";
}

// Проверяем расширения
$extensions = ['pdo_sqlite', 'gd', 'mbstring', 'xml', 'json'];
foreach ($extensions as $ext) {
  echo "2. Расширение {$ext}: ";
  if (extension_loaded($ext)) {
    echo "✅ OK\n";
  } else {
    echo "❌ Отсутствует\n";
  }
}

// Проверяем папки
$folders = [
  'web/uploads/reviews' => 'Загрузки',
  'runtime/cache' => 'Кеш',
  'runtime/mail' => 'Почта',
  'vendor' => 'Зависимости'
];

foreach ($folders as $folder => $name) {
  echo "3. Папка {$name}: ";
  if (is_dir($folder)) {
    echo "✅ OK\n";
  } else {
    echo "❌ Отсутствует\n";
  }
}

// Проверяем базу данных
if (file_exists('feedback.db')) {
  echo "4. База данных: ✅ Существует\n";

  try {
    $db = new PDO('sqlite:feedback.db');
    $tables = $db->query("SELECT name FROM sqlite_master WHERE type='table'")->fetchAll(PDO::FETCH_COLUMN);
    echo "5. Таблицы в БД: " . count($tables) . " ✅\n";

    foreach (['city', 'user', 'review'] as $table) {
      if (in_array($table, $tables)) {
        $count = $db->query("SELECT COUNT(*) FROM $table")->fetchColumn();
        echo "   - {$table}: {$count} записей\n";
      }
    }
  } catch (Exception $e) {
    echo "5. База данных: ❌ Ошибка: " . $e->getMessage() . "\n";
  }
} else {
  echo "4. База данных: ❌ Отсутствует\n";
}

echo "\n=== ПРОВЕРКА ЗАВЕРШЕНА ===\n";
