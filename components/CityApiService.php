<?php

namespace app\components;

use Yii;
use yii\base\Component;
use yii\httpclient\Client;

class CityApiService extends Component
{
  public $apiKey;
  public $apiUrl = 'https://api.example.com/cities'; // Заглушка для демо

  public function findCity($cityName)
  {
    // В реальном проекте здесь будет обращение к внешнему API
    // Например, к API GeoNames, Google Places или другому сервису

    // Для демонстрации используем фиктивные данные
    $demoCities = [
      'Москва' => ['name' => 'Москва', 'country' => 'Россия', 'population' => 12500000],
      'Санкт-Петербург' => ['name' => 'Санкт-Петербург', 'country' => 'Россия', 'population' => 5000000],
      'Екатеринбург' => ['name' => 'Екатеринбург', 'country' => 'Россия', 'population' => 1500000],
      'Новосибирск' => ['name' => 'Новосибирск', 'country' => 'Россия', 'population' => 1600000],
      'Казань' => ['name' => 'Казань', 'country' => 'Россия', 'population' => 1200000],
      'Ижевск' => ['name' => 'Ижевск', 'country' => 'Россия', 'population' => 600000],
    ];

    if (isset($demoCities[$cityName])) {
      return $demoCities[$cityName];
    }

    // Если город не найден в демо-данных, создаем фиктивный ответ
    return [
      'name' => $cityName,
      'country' => 'Россия',
      'population' => rand(100000, 2000000)
    ];
  }

  public function addCityFromApi($cityName)
  {
    $cityData = $this->findCity($cityName);

    if ($cityData) {
      $city = new \app\models\City();
      $city->name = $cityData['name'];

      if ($city->save()) {
        Yii::info("City added from API: {$cityName}", 'city-api');
        return $city;
      } else {
        Yii::error("Failed to save city from API: " . print_r($city->errors, true), 'city-api');
      }
    }

    return null;
  }
}
