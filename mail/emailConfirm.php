<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\User $user */
?>
<div class="email-confirm">
  <p>Здравствуйте, <?= Html::encode($user->fio) ?>!</p>

  <p>Для завершения регистрации перейдите по ссылке:</p>

  <p><?= Html::a(
        'Подтвердить email',
        Url::to(['/auth/confirm-email', 'token' => $user->email_confirm_token], true)
      ) ?></p>

  <p>Если вы не регистрировались в нашей системе, просто проигнорируйте это письмо.</p>
</div>