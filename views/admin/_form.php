<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Post $model */
/** @var ActiveForm $form */
?>

<div class="post-form">
  <?php $form = ActiveForm::begin(); ?>

  <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label('Заголовок') ?>

  <?= $form->field($model, 'content')->textarea(['rows' => 6])->label('Содержание') ?>

  <?= $form->field($model, 'status')->dropDownList([
    $model::STATUS_DRAFT => 'Черновик',
    $model::STATUS_PUBLISHED => 'Опубликовано',
  ])->label('Статус') ?>

  <?= $form->field($model, 'author_id')->hiddenInput(['value' => 1])->label(false) ?>

  <div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
  </div>

  <?php ActiveForm::end(); ?>
</div>