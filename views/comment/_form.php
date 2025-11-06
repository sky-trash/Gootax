<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Comment;

/** @var Comment $model */
/** @var int $post_id */
?>

<div class="comment-form">
  <?php $form = ActiveForm::begin([
    'action' => ['comment/create', 'post_id' => $post_id],
  ]); ?>

  <?= $form->field($model, 'content')->textarea(['rows' => 4])->label('Ваш комментарий') ?>

  <?= $form->field($model, 'author_id')->hiddenInput(['value' => 1])->label(false) ?>

  <div class="form-group">
    <?= Html::submitButton('Добавить комментарий', ['class' => 'btn btn-success']) ?>
  </div>

  <?php ActiveForm::end(); ?>
</div>