<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use app\models\Review;
use app\models\City;
use yii\data\ActiveDataProvider;

class ReviewManageController extends Controller
{
  public function behaviors()
  {
    return [
      'access' => [
        'class' => AccessControl::class,
        'rules' => [
          [
            'allow' => true,
            'roles' => ['@'],
          ],
        ],
      ],
    ];
  }

  public function actionIndex()
  {
    $dataProvider = new ActiveDataProvider([
      'query' => Review::find()
        ->where(['id_author' => Yii::$app->user->id])
        ->with(['city'])
        ->orderBy(['date_create' => SORT_DESC]),
      'pagination' => [
        'pageSize' => 10,
      ],
    ]);

    return $this->render('index', [
      'dataProvider' => $dataProvider,
    ]);
  }

  public function actionCreate()
  {
    $model = new Review();
    $model->id_author = Yii::$app->user->id;

    if (Yii::$app->request->isPost) {
      $model->load(Yii::$app->request->post());
      $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

      if ($model->save() && $model->upload()) {
        Yii::$app->session->setFlash('success', 'Отзыв успешно создан.');
        return $this->redirect(['index']);
      }
    }

    return $this->render('create', [
      'model' => $model,
    ]);
  }

  public function actionUpdate($id)
  {
    $model = $this->findModel($id);

    if (Yii::$app->request->isPost) {
      $model->load(Yii::$app->request->post());
      $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

      if ($model->save() && (!$model->imageFile || $model->upload())) {
        Yii::$app->session->setFlash('success', 'Отзыв успешно обновлен.');
        return $this->redirect(['index']);
      }
    }

    return $this->render('update', [
      'model' => $model,
    ]);
  }

  public function actionDelete($id)
  {
    $model = $this->findModel($id);
    $model->delete();

    Yii::$app->session->setFlash('success', 'Отзыв успешно удален.');
    return $this->redirect(['index']);
  }

  public function actionDeleteImage($id)
  {
    $model = $this->findModel($id);

    if ($model->img && file_exists('uploads/reviews/' . $model->img)) {
      unlink('uploads/reviews/' . $model->img);
    }

    $model->img = null;
    $model->save();

    Yii::$app->session->setFlash('success', 'Изображение удалено.');
    return $this->redirect(['update', 'id' => $id]);
  }

  public function actionCityAutocomplete($q = null)
  {
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

    $cities = City::find()
      ->select(['id', 'name'])
      ->where(['like', 'name', $q])
      ->orderBy('name')
      ->asArray()
      ->all();

    return $cities;
  }

  protected function findModel($id)
  {
    $model = Review::find()
      ->where(['id' => $id, 'id_author' => Yii::$app->user->id])
      ->one();

    if ($model !== null) {
      return $model;
    }

    throw new NotFoundHttpException('Отзыв не найден или у вас нет прав для его редактирования.');
  }
}
