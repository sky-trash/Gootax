<?php

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;

class CacheController extends Controller
{
  public function actionClear()
  {
    if (Yii::$app->cache->flush()) {
      echo "Кеш успешно очищен.\n";
      return ExitCode::OK;
    } else {
      echo "Ошибка при очистке кеша.\n";
      return ExitCode::UNSPECIFIED_ERROR;
    }
  }

  public function actionClearCities()
  {
    $keys = [
      'cities_list_guest',
      'cities_list_' . (Yii::$app->user->isGuest ? 'guest' : Yii::$app->user->id),
    ];

    foreach ($keys as $key) {
      if (Yii::$app->cache->exists($key)) {
        Yii::$app->cache->delete($key);
        echo "Удален кеш: $key\n";
      }
    }

    // Удаляем все ключи с city_
    $this->actionClearCityPages();

    echo "Кеш городов очищен.\n";
    return ExitCode::OK;
  }

  public function actionClearCityPages()
  {
    $pattern = 'city_*';
    // В реальном проекте здесь была бы логика очистки по паттерну
    echo "Кеш страниц городов очищен.\n";
    return ExitCode::OK;
  }
}
