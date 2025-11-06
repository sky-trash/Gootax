<?php

try {
  echo "=== ПРОВЕРКА БАЗЫ ДАННЫХ ===\n\n";

  if (!file_exists('feedback.db')) {
    echo "❌ База данных feedback.db не существует\n";
    echo "Запустите create-database.php для создания базы\n";
    exit(1);
  }

  $db = new PDO('sqlite:feedback.db');
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  echo "✅ База данных подключена\n";

  // Проверяем таблицы
  $tables = ['city', 'user', 'review'];
  foreach ($tables as $table) {
    $result = $db->query("SELECT COUNT(*) FROM $table")->fetchColumn();
    echo "✅ Таблица {$table}: {$result} записей\n";
  }

  // Проверяем тестового пользователя
  $user = $db->query("SELECT * FROM user WHERE email = 'admin@example.com'")->fetch(PDO::FETCH_ASSOC);
  if ($user) {
    echo "✅ Тестовый пользователь: {$user['fio']} ({$user['email']})\n";
  } else {
    echo "❌ Тестовый пользователь не найден\n";
  }

  echo "\n🎉 БАЗА ДАННЫХ В ПОРЯДКЕ!\n";
} catch (Exception $e) {
  echo "❌ Ошибка: " . $e->getMessage() . "\n";
}
