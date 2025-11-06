<?php

namespace app\controllers;

use Yii;
use app\models\Post;
use app\models\Comment;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;

class PostController extends Controller
{
  public function actionIndex()
  {
    $dataProvider = new ActiveDataProvider([
      'query' => Post::find()->published()->with('author'),
      'pagination' => [
        'pageSize' => 10,
      ],
      'sort' => [
        'defaultOrder' => [
          'created_at' => SORT_DESC,
        ]
      ],
    ]);

    $this->view->title = 'Все записи блога';

    return $this->render('index', [
      'dataProvider' => $dataProvider,
    ]);
  }

  public function actionView($id)
  {
    $post = $this->findModel($id);
    $comment = new Comment();
    $comment->post_id = $id;

    if ($comment->load(Yii::$app->request->post()) && $comment->save()) {
      Yii::$app->session->setFlash('success', 'Комментарий успешно добавлен.');
      return $this->refresh();
    }

    $this->view->title = $post->title;

    return $this->render('view', [
      'post' => $post,
      'comment' => $comment,
    ]);
  }

  protected function findModel($id)
  {
    if (($model = Post::findOne($id)) !== null) {
      return $model;
    }

    throw new NotFoundHttpException('Запрошенная запись не существует.');
  }
}
