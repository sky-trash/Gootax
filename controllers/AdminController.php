<?php

namespace app\controllers;

use Yii;
use app\models\Post;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class AdminController extends Controller
{
  public function behaviors()
  {
    return [
      'verbs' => [
        'class' => VerbFilter::class,
        'actions' => [
          'delete' => ['POST'],
        ],
      ],
    ];
  }

  public function actionIndex()
  {
    $dataProvider = new ActiveDataProvider([
      'query' => Post::find()->with('author'),
      'pagination' => [
        'pageSize' => 20,
      ],
      'sort' => [
        'defaultOrder' => [
          'created_at' => SORT_DESC,
        ]
      ],
    ]);

    $this->view->title = 'Управление записями';

    return $this->render('index', [
      'dataProvider' => $dataProvider,
    ]);
  }

  public function actionView($id)
  {
    return $this->render('view', [
      'model' => $this->findModel($id),
    ]);
  }

  public function actionCreate()
  {
    $model = new Post();

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      Yii::$app->session->setFlash('success', 'Запись успешно создана.');
      return $this->redirect(['view', 'id' => $model->id]);
    }

    $this->view->title = 'Создать запись';

    return $this->render('create', [
      'model' => $model,
    ]);
  }

  public function actionUpdate($id)
  {
    $model = $this->findModel($id);

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      Yii::$app->session->setFlash('success', 'Запись успешно обновлена.');
      return $this->redirect(['view', 'id' => $model->id]);
    }

    $this->view->title = 'Редактировать запись: ' . $model->title;

    return $this->render('update', [
      'model' => $model,
    ]);
  }

  public function actionDelete($id)
  {
    $this->findModel($id)->delete();
    Yii::$app->session->setFlash('success', 'Запись успешно удалена.');
    return $this->redirect(['index']);
  }

  protected function findModel($id)
  {
    if (($model = Post::findOne($id)) !== null) {
      return $model;
    }

    throw new NotFoundHttpException('Запрошенная запись не существует.');
  }
}
