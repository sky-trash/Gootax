<?php

use yii\helpers\Html;

/** @var app\models\Comment $model */
?>

<div class="comment">
  <div class="comment-meta">
    <strong><?= Html::encode($model->author->username ?? 'Аноним') ?></strong>
    <span class="comment-date"><?= Yii::$app->formatter->asRelativeTime($model->created_at) ?></span>
  </div>

  <div class="comment-content">
    <?= nl2br(Html::encode($model->content)) ?>
  </div>
</div>

<hr>