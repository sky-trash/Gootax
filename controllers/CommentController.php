<?php

namespace app\controllers;

use Yii;
use app\models\Comment;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CommentController extends Controller
{
  public function actionCreate($post_id)
  {
    $comment = new Comment();
    $comment->post_id = $post_id;
    $comment->author_id = 1; // временно фиксированный автор

    if ($comment->load(Yii::$app->request->post()) && $comment->save()) {
      Yii::$app->session->setFlash('success', 'Комментарий успешно добавлен.');
    } else {
      Yii::$app->session->setFlash('error', 'Ошибка при добавлении комментария.');
    }

    return $this->redirect(['post/view', 'id' => $post_id]);
  }
}
