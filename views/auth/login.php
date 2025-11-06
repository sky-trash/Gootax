<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\LoginForm $model */

$this->title = 'Вход в систему';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-login">
  <div class="row justify-content-center">
    <div class="col-md-4">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title text-center"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="card-body">
          <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

          <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

          <?= $form->field($model, 'password')->passwordInput() ?>

          <?= $form->field($model, 'rememberMe')->checkbox() ?>

          <div class="form-group">
            <?= Html::submitButton('Войти', ['class' => 'btn btn-primary w-100', 'name' => 'login-button']) ?>
          </div>

          <?php ActiveForm::end(); ?>

          <div class="text-center mt-3">
            <?= Html::a('Регистрация', ['register']) ?>
          </div>

          <?php if (Yii::$app->session->hasFlash('success')): ?>
            <div class="alert alert-success alert-dismissible fade show mt-3">
              <?= Yii::$app->session->getFlash('success') ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          <?php endif; ?>
        </div>
      </div>

      <div class="alert alert-info mt-3">
        <strong>Тестовый доступ:</strong><br>
        Email: admin@example.com<br>
        Пароль: admin123
      </div>
    </div>
  </div>
</div>