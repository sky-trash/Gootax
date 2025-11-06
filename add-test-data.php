<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/yiisoft/yii2/Yii.php';

$config = [
  'id' => 'test',
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

new yii\console\Application($config);

try {
  echo "Adding test reviews...\n";

  $user = \app\models\User::findOne(1);
  $cities = \app\models\City::find()->all();

  if (!$user) {
    echo "User not found. Run setup-database.php first.\n";
    exit(1);
  }

  $reviews = [
    [
      'title' => 'Отличный город для жизни',
      'text' => 'Очень понравилась инфраструктура и развитая транспортная сеть. Много парков и мест для отдыха.',
      'rating' => 5,
      'id_city' => 1, // Москва
      'id_author' => 1,
    ],
    [
      'title' => 'Красивый исторический центр',
      'text' => 'Прекрасная архитектура, много музеев и достопримечательностей. Обязательно к посещению!',
      'rating' => 4,
      'id_city' => 2, // СПб
      'id_author' => 1,
    ],
    [
      'title' => 'Комфортный город',
      'text' => 'Хорошие дороги, чистота на улицах. Приятная атмосфера для жизни и работы.',
      'rating' => 4,
      'id_city' => 3, // Екатеринбург
      'id_author' => 1,
    ],
    [
      'title' => 'Современный мегаполис',
      'text' => 'Быстро развивающийся город с хорошими перспективами. Много возможностей для карьеры.',
      'rating' => 4,
      'id_city' => 4, // Новосибирск
      'id_author' => 1,
    ],
    [
      'title' => 'Общие впечатления о городах России',
      'text' => 'Путешествовал по многим городам России. Везде нашел что-то интересное и уникальное. Рекомендую посетить разные регионы!',
      'rating' => 5,
      'id_city' => null, // Для всех городов
      'id_author' => 1,
    ],
  ];

  foreach ($reviews as $reviewData) {
    $review = new \app\models\Review();
    $review->attributes = $reviewData;
    $review->date_create = time() - rand(0, 30 * 24 * 3600);

    if ($review->save()) {
      echo "Review created: {$review->title}\n";
    } else {
      echo "Error creating review: " . print_r($review->errors, true) . "\n";
    }
  }

  echo "Test reviews added successfully!\n";
} catch (Exception $e) {
  echo "Error: " . $e->getMessage() . "\n";
}
