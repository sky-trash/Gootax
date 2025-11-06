<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/yiisoft/yii2/Yii.php';

$db = new yii\db\Connection([
  'dsn' => 'sqlite:' . __DIR__ . '/blog.db',
  'username' => '',
  'password' => '',
  'charset' => 'utf8',
]);

try {
  $db->open();

  // Проверим, есть ли уже пользователи
  $userCount = $db->createCommand("SELECT COUNT(*) FROM user")->queryScalar();

  if ($userCount == 0) {
    // Создаем администратора
    $db->createCommand()->insert('user', [
      'username' => 'admin',
      'password' => Yii::$app->getSecurity()->generatePasswordHash('admin'),
      'email' => 'admin@blog.com',
      'created_at' => time(),
      'updated_at' => time(),
    ])->execute();

    echo "Admin user created successfully!\n";
    echo "Username: admin\n";
    echo "Password: admin\n";
  } else {
    echo "Users already exist in database. Count: " . $userCount . "\n";
  }
} catch (Exception $e) {
  echo "Error: " . $e->getMessage() . "\n";
}
