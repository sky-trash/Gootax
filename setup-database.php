<?php

require __DIR__ . '/vendor/autoload.php';

try {
  // Создаем подключение к SQLite
  $db = new PDO('sqlite:' . __DIR__ . '/feedback.db');
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  echo "SQLite database connected successfully!\n";

  // Создаем таблицы
  $tables = [
    'city' => "CREATE TABLE IF NOT EXISTS city (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name VARCHAR(255) NOT NULL UNIQUE,
            date_create INTEGER NOT NULL
        )",

    'user' => "CREATE TABLE IF NOT EXISTS user (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            fio VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            phone VARCHAR(20),
            password_hash VARCHAR(255) NOT NULL,
            auth_key VARCHAR(32),
            email_confirm_token VARCHAR(255),
            status SMALLINT NOT NULL DEFAULT 0,
            date_create INTEGER NOT NULL
        )",

    'review' => "CREATE TABLE IF NOT EXISTS review (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            id_city INTEGER,
            title VARCHAR(100) NOT NULL,
            text VARCHAR(255) NOT NULL,
            rating SMALLINT NOT NULL,
            img VARCHAR(255),
            id_author INTEGER NOT NULL,
            date_create INTEGER NOT NULL,
            FOREIGN KEY (id_city) REFERENCES city (id),
            FOREIGN KEY (id_author) REFERENCES user (id)
        )"
  ];

  foreach ($tables as $tableName => $sql) {
    $db->exec($sql);
    echo "Table '{$tableName}' created successfully!\n";
  }

  // Добавляем тестовые города
  $cities = ['Москва', 'Санкт-Петербург', 'Екатеринбург', 'Новосибирск', 'Казань', 'Ижевск'];
  foreach ($cities as $city) {
    $stmt = $db->prepare("INSERT OR IGNORE INTO city (name, date_create) VALUES (?, ?)");
    $stmt->execute([$city, time()]);
  }
  echo "Test cities added successfully!\n";

  // Добавляем тестового пользователя
  $password = password_hash('admin123', PASSWORD_DEFAULT);
  $stmt = $db->prepare("INSERT OR IGNORE INTO user (fio, email, phone, password_hash, status, date_create) VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->execute(['Администратор', 'admin@example.com', '+79991234567', $password, 2, time()]);
  echo "Test user created: admin@example.com / admin123\n";

  echo "Database setup completed!\n";
} catch (Exception $e) {
  echo "Database setup failed: " . $e->getMessage() . "\n";
}
