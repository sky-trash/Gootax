<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\User $user */
?>
<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
  <h2 style="color: #333;">Подтверждение регистрации</h2>

  <p>Здравствуйте, <?= Html::encode($user->fio) ?>!</p>

  <p>Для завершения регистрации в системе отзывов о городах перейдите по ссылке:</p>

  <p style="text-align: center; margin: 30px 0;">
    <?= Html::a(
      'Подтвердить email',
      Url::to(['/auth/confirm-email', 'token' => $user->email_confirm_token], true),
      [
        'style' => 'display: inline-block; padding: 12px 24px; background: #007bff; color: white; text-decoration: none; border-radius: 4px;'
      ]
    ) ?>
  </p>

  <p>Если вы не регистрировались в нашей системе, просто проигнорируйте это письмо.</p>

  <hr style="border: none; border-top: 1px solid #eee; margin: 20px 0;">

  <p style="color: #666; font-size: 0.9em;">
    С уважением,<br>
    Команда <?= Yii::$app->name ?>
  </p>
</div>