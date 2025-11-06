<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\captcha\Captcha;

/** @var yii\web\View $this */
/** @var app\models\RegisterForm $model */

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-register">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title text-center"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="card-body">
          <?php $form = ActiveForm::begin(['id' => 'register-form']); ?>

          <?= $form->field($model, 'fio')->textInput(['autofocus' => true]) ?>

          <?= $form->field($model, 'email') ?>

          <?= $form->field($model, 'phone')->textInput(['placeholder' => '+79991234567']) ?>

          <?= $form->field($model, 'password')->passwordInput() ?>

          <?= $form->field($model, 'password_repeat')->passwordInput() ?>

          <?= $form->field($model, 'verifyCode')->widget(Captcha::class, [
            'template' => '<div class="row"><div class="col-lg-6">{image}</div><div class="col-lg-6">{input}</div></div>',
          ]) ?>

          <div class="form-group">
            <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-success w-100', 'name' => 'register-button']) ?>
          </div>

          <?php ActiveForm::end(); ?>

          <div class="text-center mt-3">
            <?= Html::a('Уже есть аккаунт? Войдите', ['login']) ?>
          </div>

          <?php if (Yii::$app->session->hasFlash('info')): ?>
            <div class="alert alert-info alert-dismissible fade show mt-3">
              <?= Yii::$app->session->getFlash('info') ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>