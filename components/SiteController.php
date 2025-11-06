<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\models\City;

class SiteController extends Controller
{
  public function actions()
  {
    return [
      'error' => [
        'class' => 'yii\web\ErrorAction',
      ],
    ];
  }

  public function actionIndex()
  {
    // Проверяем, есть ли уже выбранный город в сессии
    $selectedCityId = Yii::$app->session->get('selected_city_id');
    $selectedCity = null;

    if ($selectedCityId) {
      $selectedCity = City::findOne($selectedCityId);
    }

    // Если город выбран и сессия активна, показываем отзывы
    if ($selectedCity) {
      return $this->redirect(['review/city', 'id' => $selectedCity->id]);
    }

    // Пытаемся определить город по IP
    $detectedCityName = Yii::$app->ipGeo->getCityByIp();
    $detectedCity = null;

    if ($detectedCityName) {
      $detectedCity = Yii::$app->ipGeo->findCityInDatabase($detectedCityName);
    }

    // Получаем список всех городов с отзывами
    $cities = City::find()
      ->joinWith('reviews')
      ->orderBy(['name' => SORT_ASC])
      ->all();

    return $this->render('index', [
      'detectedCity' => $detectedCity,
      'detectedCityName' => $detectedCityName,
      'cities' => $cities,
    ]);
  }

  public function actionSelectCity($id = null, $confirm = null)
  {
    if ($id) {
      $city = City::findOne($id);
      if ($city) {
        // Сохраняем выбор города в сессии на 2 часа
        Yii::$app->session->set('selected_city_id', $city->id);
        Yii::$app->session->set('selected_city_time', time());

        return $this->redirect(['review/city', 'id' => $city->id]);
      }
    }

    if ($confirm === 'no') {
      // Пользователь отказался от определенного города
      Yii::$app->session->set('city_detection_refused', true);
      return $this->redirect(['index']);
    }

    return $this->redirect(['index']);
  }

  public function actionClearCity()
  {
    Yii::$app->session->remove('selected_city_id');
    Yii::$app->session->remove('selected_city_time');
    Yii::$app->session->remove('city_detection_refused');

    return $this->redirect(['index']);
  }
}
