<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\City;

class SiteController extends Controller
{
    public $layout = 'basic';

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
        // Кешируем список городов на 5 минут
        $cacheKey = 'cities_list_' . (Yii::$app->user->isGuest ? 'guest' : Yii::$app->user->id);
        $cities = Yii::$app->cache->getOrSet($cacheKey, function () {
            return City::find()
                ->joinWith('reviews')
                ->orderBy(['name' => SORT_ASC])
                ->all();
        }, 300);

        $selectedCityId = Yii::$app->session->get('selected_city_id');
        $selectedCity = null;

        if ($selectedCityId) {
            $selectedCity = City::findOne($selectedCityId);
        }

        if ($selectedCity) {
            return $this->redirect(['review/city', 'id' => $selectedCity->id]);
        }

        $detectedCityName = Yii::$app->ipGeo->getCityByIp();
        $detectedCity = null;

        if ($detectedCityName) {
            $detectedCity = Yii::$app->ipGeo->findCityInDatabase($detectedCityName);
        }

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
                Yii::$app->session->set('selected_city_id', $city->id);
                Yii::$app->session->set('selected_city_time', time());

                return $this->redirect(['review/city', 'id' => $city->id]);
            }
        }

        if ($confirm === 'no') {
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
