<?php

namespace app\models;

use Yii;
use yii\base\Model;

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
    $user->status = User::STATUS_INACTIVE;

    if ($user->save()) {
      // В реальном проекте раскомментировать для отправки email
      // $this->sendConfirmationEmail($user);

      // Для демонстрации показываем ссылку
      Yii::$app->session->setFlash(
        'info',
        'Для завершения регистрации перейдите по ссылке: ' .
          \yii\helpers\Html::a(
            'Подтвердить email',
            ['auth/confirm-email', 'token' => $user->email_confirm_token],
            ['target' => '_blank']
          )
      );

      return true;
    }

    // Если ошибка сохранения, добавим ошибки в модель
    if ($user->hasErrors()) {
      foreach ($user->errors as $attribute => $errors) {
        foreach ($errors as $error) {
          $this->addError($attribute, $error);
        }
      }
    }

    return false;
  }

  protected function sendConfirmationEmail($user)
  {
    return Yii::$app->mailer->compose('emailConfirm', ['user' => $user])
      ->setTo($user->email)
      ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
      ->setSubject('Подтверждение регистрации в ' . Yii::$app->name)
      ->send();
  }
}
