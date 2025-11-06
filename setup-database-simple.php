<?php

require __DIR__ . '/vendor/autoload.php';

try {
  // Создаем подключение к SQLite
  $db = new PDO('sqlite:' . __DIR__ . '/blog.db');
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  echo "SQLite database connected successfully!\n";

  // Создаем таблицы
  $tables = [
    'user' => "CREATE TABLE IF NOT EXISTS user (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username VARCHAR(128) NOT NULL UNIQUE,
            password VARCHAR(128) NOT NULL,
            email VARCHAR(128) NOT NULL UNIQUE,
            created_at INTEGER NOT NULL,
            updated_at INTEGER NOT NULL
        )",

    'post' => "CREATE TABLE IF NOT EXISTS post (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title VARCHAR(128) NOT NULL,
            content TEXT NOT NULL,
            status SMALLINT NOT NULL DEFAULT 1,
            author_id INTEGER NOT NULL,
            created_at INTEGER NOT NULL,
            updated_at INTEGER NOT NULL,
            FOREIGN KEY (author_id) REFERENCES user (id)
        )",

    'comment' => "CREATE TABLE IF NOT EXISTS comment (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            content TEXT NOT NULL,
            author_id INTEGER NOT NULL,
            post_id INTEGER NOT NULL,
            created_at INTEGER NOT NULL,
            updated_at INTEGER NOT NULL,
            FOREIGN KEY (author_id) REFERENCES user (id),
            FOREIGN KEY (post_id) REFERENCES post (id)
        )",

    'tag' => "CREATE TABLE IF NOT EXISTS tag (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name VARCHAR(64) NOT NULL UNIQUE,
            frequency INTEGER DEFAULT 1
        )",

    'post_tag' => "CREATE TABLE IF NOT EXISTS post_tag (
            post_id INTEGER NOT NULL,
            tag_id INTEGER NOT NULL,
            PRIMARY KEY (post_id, tag_id),
            FOREIGN KEY (post_id) REFERENCES post (id),
            FOREIGN KEY (tag_id) REFERENCES tag (id)
        )"
  ];

  foreach ($tables as $tableName => $sql) {
    $db->exec($sql);
    echo "Table '{$tableName}' created successfully!\n";
  }

  // Добавляем тестового пользователя
  $stmt = $db->prepare("SELECT COUNT(*) FROM user");
  $stmt->execute();
  $userCount = $stmt->fetchColumn();

  if ($userCount == 0) {
    $password = password_hash('admin', PASSWORD_DEFAULT);
    $stmt = $db->prepare("INSERT INTO user (username, password, email, created_at, updated_at) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute(['admin', $password, 'admin@blog.com', time(), time()]);
    echo "Admin user created: admin/admin\n";
  }

  // Добавляем тестовые посты
  $stmt = $db->prepare("SELECT COUNT(*) FROM post");
  $stmt->execute();
  $postCount = $stmt->fetchColumn();

  if ($postCount == 0) {
    $posts = [
      ['Welcome to Our Blog', 'This is the first post in our amazing blog. We are excited to share our thoughts and ideas with you.', 1, time(), time()],
      ['Getting Started with Yii2', 'Yii2 is a high-performance PHP framework best for developing Web applications.', 1, time() - 3600, time() - 3600],
      ['SQLite for Development', 'SQLite is perfect for development and testing. It requires no setup and works great with Yii2.', 1, time() - 7200, time() - 7200]
    ];

    $stmt = $db->prepare("INSERT INTO post (title, content, author_id, created_at, updated_at) VALUES (?, ?, ?, ?, ?)");
    foreach ($posts as $post) {
      $stmt->execute($post);
    }
    echo "Sample posts created successfully!\n";
  }

  echo "Database setup completed!\n";
} catch (Exception $e) {
  echo "Database setup failed: " . $e->getMessage() . "\n";
}
