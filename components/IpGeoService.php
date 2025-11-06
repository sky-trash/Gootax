<?php

namespace app\components;

use Yii;
use yii\base\Component;

class IpGeoService extends Component
{
  public function getCityByIp($ip = null)
  {
    if ($ip === null) {
      $ip = Yii::$app->request->getUserIP();
    }

    // Для тестирования используем фиктивные данные
    $testData = [
      '77.88.8.8' => 'Москва',
      '93.158.134.0' => 'Москва',
      '5.45.207.0' => 'Санкт-Петербург',
      '178.248.232.0' => 'Екатеринбург',
      '195.208.131.0' => 'Новосибирск',
      '178.176.68.0' => 'Казань',
      '31.173.80.0' => 'Ижевск',
    ];

    foreach ($testData as $testIp => $city) {
      if (strpos($ip, $testIp) === 0) {
        return $city;
      }
    }

    return null;
  }

  public function findCityInDatabase($cityName)
  {
    return \app\models\City::find()
      ->where(['like', 'name', $cityName])
      ->one();
  }

  public function addCityFromApi($cityName)
  {
    $city = new \app\models\City();
    $city->name = $cityName;

    if ($city->save()) {
      return $city;
    }

    return null;
  }
}
