<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\Post $model */
/** @var ActiveForm $form */
?>

<div class="post-form">
  <?php $form = ActiveForm::begin(); ?>

  <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

  <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

  <?= $form->field($model, 'status')->dropDownList([
    $model::STATUS_DRAFT => 'Draft',
    $model::STATUS_PUBLISHED => 'Published',
  ]) ?>

  <?= $form->field($model, 'author_id')->hiddenInput(['value' => 1])->label(false) ?>

  <div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
  </div>

  <?php ActiveForm::end(); ?>
</div>