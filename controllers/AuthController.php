<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;
use app\models\User;
use app\models\LoginForm;
use app\models\RegisterForm;

class AuthController extends Controller
{
  public function actionLogin()
  {
    if (!Yii::$app->user->isGuest) {
      return $this->goHome();
    }

    $model = new LoginForm();

    if ($model->load(Yii::$app->request->post()) && $model->login()) {
      return $this->goBack();
    }

    $model->password = '';

    return $this->render('login', [
      'model' => $model,
    ]);
  }

  public function actionRegister()
  {
    if (!Yii::$app->user->isGuest) {
      return $this->goHome();
    }

    $model = new RegisterForm();

    if (Yii::$app->request->isPost) {
      if ($model->load(Yii::$app->request->post())) {
        if ($model->register()) {
          Yii::$app->session->setFlash(
            'success',
            'Регистрация успешна! На ваш email отправлено письмо с подтверждением.'
          );
          return $this->goHome();
        }
      }
    }

    return $this->render('register', [
      'model' => $model,
    ]);
  }

  public function actionLogout()
  {
    Yii::$app->user->logout();
    return $this->goHome();
  }

  public function actionConfirmEmail($token)
  {
    $user = User::findOne(['email_confirm_token' => $token]);

    if ($user) {
      $user->status = User::STATUS_EMAIL_CONFIRMED;
      $user->email_confirm_token = null;

      if ($user->save()) {
        Yii::$app->session->setFlash('success', 'Email успешно подтвержден! Теперь вы можете войти в систему.');
      } else {
        Yii::$app->session->setFlash('error', 'Ошибка при подтверждении email.');
      }
    } else {
      Yii::$app->session->setFlash('error', 'Неверная ссылка подтверждения.');
    }

    return $this->redirect(['login']);
  }
}
