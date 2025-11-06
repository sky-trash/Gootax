<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;

/** @var yii\web\View $this */
/** @var app\models\RegisterForm $model */

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-register">
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="panel-body">
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
            <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-success btn-block', 'name' => 'register-button']) ?>
          </div>

          <?php ActiveForm::end(); ?>

          <div class="text-center">
            <?= Html::a('Уже есть аккаунт? Войдите', ['login']) ?>
          </div>

          <?php if (Yii::$app->session->hasFlash('info')): ?>
            <div class="alert alert-info">
              <?= Yii::$app->session->getFlash('info') ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>