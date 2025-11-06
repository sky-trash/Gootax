<?php

// Простой скрипт для создания базы данных без Yii зависимостей

try {
  echo "=== СОЗДАНИЕ БАЗЫ ДАННЫХ ===\n\n";

  // Удаляем старую базу если существует
  if (file_exists('feedback.db')) {
    unlink('feedback.db');
    echo "✅ Старая база данных удалена\n";
  }

  // Создаем новую базу
  $db = new PDO('sqlite:feedback.db');
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "✅ Новая база данных создана\n";

  // Создаем таблицы
  $tables = [
    'city' => "CREATE TABLE city (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name VARCHAR(255) NOT NULL UNIQUE,
            date_create INTEGER NOT NULL
        )",

    'user' => "CREATE TABLE user (
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

    'review' => "CREATE TABLE review (
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
    echo "✅ Таблица {$tableName} создана\n";
  }

  // Добавляем индексы
  $indexes = [
    "CREATE INDEX idx_city_name ON city (name)",
    "CREATE INDEX idx_city_date ON city (date_create)",
    "CREATE INDEX idx_user_email ON user (email)",
    "CREATE INDEX idx_user_status ON user (status)",
    "CREATE INDEX idx_user_date ON user (date_create)",
    "CREATE INDEX idx_review_city ON review (id_city)",
    "CREATE INDEX idx_review_author ON review (id_author)",
    "CREATE INDEX idx_review_rating ON review (rating)",
    "CREATE INDEX idx_review_date ON review (date_create)",
  ];

  foreach ($indexes as $index) {
    $db->exec($index);
  }
  echo "✅ Индексы созданы\n";

  // Добавляем тестовые города
  $cities = ['Москва', 'Санкт-Петербург', 'Екатеринбург', 'Новосибирск', 'Казань', 'Ижевск'];
  $stmt = $db->prepare("INSERT INTO city (name, date_create) VALUES (?, ?)");

  foreach ($cities as $city) {
    $stmt->execute([$city, time()]);
  }
  echo "✅ Тестовые города добавлены\n";

  // Добавляем тестового пользователя
  $passwordHash = password_hash('admin123', PASSWORD_DEFAULT);
  $db->prepare("INSERT INTO user (fio, email, phone, password_hash, status, date_create) 
                  VALUES (?, ?, ?, ?, ?, ?)")
    ->execute([
      'Администратор',
      'admin@example.com',
      '+79991234567',
      $passwordHash,
      2, // STATUS_EMAIL_CONFIRMED
      time()
    ]);
  echo "✅ Тестовый пользователь создан\n";

  // Добавляем тестовые отзывы
  $reviews = [
    ['Отличный город для жизни', 'Очень понравилась инфраструктура и развитая транспортная сеть. Много парков и мест для отдыха.', 5, 1, 1, time() - 86400],
    ['Красивый исторический центр', 'Прекрасная архитектура, много музеев и достопримечательностей. Обязательно к посещению!', 4, 2, 1, time() - 172800],
    ['Комфортный город', 'Хорошие дороги, чистота на улицах. Приятная атмосфера для жизни и работы.', 4, 3, 1, time() - 259200],
    ['Современный мегаполис', 'Быстро развивающийся город с хорошими перспективами. Много возможностей для карьеры.', 4, 4, 1, time() - 345600],
    ['Общие впечатления', 'Путешествовал по многим городам России. Везде нашел что-то интересное и уникальное.', 5, null, 1, time() - 432000],
  ];

  $stmt = $db->prepare("INSERT INTO review (title, text, rating, id_city, id_author, date_create) 
                          VALUES (?, ?, ?, ?, ?, ?)");

  foreach ($reviews as $review) {
    $stmt->execute($review);
  }
  echo "✅ Тестовые отзывы добавлены\n";

  echo "\n🎉 БАЗА ДАННЫХ УСПЕШНО СОЗДАНА!\n\n";
  echo "Тестовый доступ:\n";
  echo "Email: admin@example.com\n";
  echo "Пароль: admin123\n\n";
} catch (Exception $e) {
  echo "❌ Ошибка: " . $e->getMessage() . "\n";
}
