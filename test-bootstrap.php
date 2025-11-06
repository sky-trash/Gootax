<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/yiisoft/yii2/Yii.php';

// Проверяем доступность bootstrap классов
$classes = [
  'yii\bootstrap\BootstrapAsset',
  'yii\bootstrap\Nav',
  'yii\bootstrap\NavBar',
];

foreach ($classes as $class) {
  if (class_exists($class)) {
    echo "$class - Доступен\n";
  } else {
    echo "$class - НЕ доступен\n";
  }
}

echo "Проверка завершена.\n";
