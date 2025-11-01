<?php

require_once __DIR__ . '/../app/utils/Database.php';

try {
  $config = require __DIR__ . '/../app/config/database.php';

  echo "Инициализация SQLite базы данных...\n";
  $pdo = Database::getConnection();
  $schema = "
    CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        email VARCHAR(255) UNIQUE NOT NULL,
        password_hash VARCHAR(255) NOT NULL,
        name VARCHAR(100) NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );

    CREATE TABLE IF NOT EXISTS feedback (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        subject VARCHAR(255) NOT NULL,
        message TEXT NOT NULL,
        rating TEXT CHECK(rating IN ('poor', 'average', 'good', 'excellent')) NOT NULL,
        categories TEXT NOT NULL,
        contact_method TEXT CHECK(contact_method IN ('email', 'phone', 'none')) NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    );
    ";

  $pdo->exec($schema);
  echo "Таблицы созданы успешно!\n";
  $testUsers = [
    ['user@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Test User'],
    ['admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin User']
  ];

  $stmt = $pdo->prepare("INSERT OR IGNORE INTO users (email, password_hash, name) VALUES (?, ?, ?)");

  foreach ($testUsers as $user) {
    $stmt->execute($user);
  }

  echo "Тестовые пользователи созданы!\n";
  echo "Email: user@example.com\n";
  echo "Пароль: password\n";
  echo "Файл базы: {$config['database']}\n";
  echo "Готово! Теперь запускайте сервер.\n";
} catch (Exception $e) {
  echo "Ошибка: " . $e->getMessage() . "\n";
  echo  "Файл: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
