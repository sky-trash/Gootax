<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use app\models\Review;
use app\models\City;
use app\models\User;

class ReviewController extends Controller
{
  public function actionCity($id)
  {
    $city = City::findOne($id);
    if (!$city) {
      throw new NotFoundHttpException('Город не найден.');
    }

    $this->checkCitySession($id);

    $dataProvider = new ActiveDataProvider([
      'query' => Review::find()
        ->where(['id_city' => $id])
        ->with(['author', 'city'])
        ->orderBy(['date_create' => SORT_DESC]),
      'pagination' => [
        'pageSize' => 10,
      ],
    ]);

    return $this->render('city', [
      'city' => $city,
      'dataProvider' => $dataProvider,
    ]);
  }

  public function actionAuthor($id)
  {
    $author = User::findOne($id);
    if (!$author) {
      throw new NotFoundHttpException('Автор не найден.');
    }

    $dataProvider = new ActiveDataProvider([
      'query' => Review::find()
        ->where(['id_author' => $id])
        ->with(['author', 'city'])
        ->orderBy(['date_create' => SORT_DESC]),
      'pagination' => [
        'pageSize' => 10,
      ],
    ]);

    return $this->render('author', [
      'author' => $author,
      'dataProvider' => $dataProvider,
    ]);
  }

  public function actionView($id)
  {
    $review = Review::find()
      ->where(['id' => $id])
      ->with(['author', 'city'])
      ->one();

    if (!$review) {
      throw new NotFoundHttpException('Отзыв не найден.');
    }

    if (Yii::$app->request->isAjax) {
      return $this->renderPartial('_author_modal', [
        'author' => $review->author,
      ]);
    }

    throw new NotFoundHttpException('Страница не найдена.');
  }

  private function checkCitySession($cityId)
  {
    $sessionCityId = Yii::$app->session->get('selected_city_id');
    $sessionTime = Yii::$app->session->get('selected_city_time');

    if (
      !$sessionCityId || !$sessionTime ||
      (time() - $sessionTime > 7200) ||
      $sessionCityId != $cityId
    ) {

      Yii::$app->session->remove('selected_city_id');
      Yii::$app->session->remove('selected_city_time');

      return $this->redirect(['site/index']);
    }

    return true;
  }
}
