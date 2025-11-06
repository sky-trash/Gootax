<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\LoginForm $model */

$this->title = 'Вход в систему';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-login">
  <div class="row">
    <div class="col-md-4 col-md-offset-4">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="panel-body">
          <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

          <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

          <?= $form->field($model, 'password')->passwordInput() ?>

          <?= $form->field($model, 'rememberMe')->checkbox() ?>

          <div class="form-group">
            <?= Html::submitButton('Войти', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
          </div>

          <?php ActiveForm::end(); ?>

          <div class="text-center">
            <?= Html::a('Регистрация', ['register']) ?>
          </div>

          <?php if (Yii::$app->session->hasFlash('success')): ?>
            <div class="alert alert-success">
              <?= Yii::$app->session->getFlash('success') ?>
            </div>
          <?php endif; ?>
        </div>
      </div>

      <div class="alert alert-info">
        <strong>Тестовый доступ:</strong><br>
        Email: admin@example.com<br>
        Пароль: admin123
      </div>
    </div>
  </div>
</div>