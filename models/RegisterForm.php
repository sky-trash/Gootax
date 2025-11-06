<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\Html;

class RegisterForm extends Model
{
  public $fio;
  public $email;
  public $phone;
  public $password;
  public $password_repeat;
  public $verifyCode;

  public function rules()
  {
    return [
      [['fio', 'email', 'phone', 'password', 'password_repeat'], 'required'],
      ['email', 'email'],
      ['email', 'unique', 'targetClass' => User::class],
      ['phone', 'match', 'pattern' => '/^\+7\d{10}$/', 'message' => 'Телефон должен быть в формате +79991234567'],
      ['password', 'string', 'min' => 6],
      ['password_repeat', 'compare', 'compareAttribute' => 'password'],
      ['verifyCode', 'captcha', 'captchaAction' => 'auth/captcha'],
    ];
  }

  public function attributeLabels()
  {
    return [
      'fio' => 'ФИО',
      'email' => 'Email',
      'phone' => 'Телефон',
      'password' => 'Пароль',
      'password_repeat' => 'Повторите пароль',
      'verifyCode' => 'Проверочный код',
    ];
  }

  public function register()
  {
    if (!$this->validate()) {
      return false;
    }

    $user = new User();
    $user->fio = $this->fio;
    $user->email = $this->email;
    $user->phone = $this->phone;
    $user->setPassword($this->password);
    $user->generateEmailConfirmToken();

    if ($user->save()) {
      // В реальном проекте здесь была бы отправка email
      // $this->sendConfirmationEmail($user);

      // Для демонстрации просто выводим ссылку
      Yii::$app->session->setFlash(
        'info',
        'Для демонстрации: ' .
          Html::a('Подтвердить email', ['auth/confirm-email', 'token' => $user->email_confirm_token])
      );

      return true;
    }

    return false;
  }

  protected function sendConfirmationEmail($user)
  {
    // Реальная отправка email в продакшене
    return Yii::$app->mailer->compose('emailConfirm', ['user' => $user])
      ->setTo($user->email)
      ->setSubject('Подтверждение регистрации')
      ->send();
  }
}
