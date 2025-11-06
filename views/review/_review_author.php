<?php

use yii\helpers\Html;

/** @var app\models\Review $model */
?>

<div class="review-item panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">
      <?= Html::encode($model->title) ?>
      <span class="label label-info pull-right"><?= $model->cityName ?></span>
    </h3>
  </div>
  <div class="panel-body">
    <p><?= nl2br(Html::encode($model->text)) ?></p>

    <div class="rating">
      <strong>Рейтинг:</strong>
      <?php for ($i = 1; $i <= 5; $i++): ?>
        <span class="glyphicon glyphicon-star<?= $i <= $model->rating ? '' : '-empty' ?>"></span>
      <?php endfor; ?>
      (<?= $model->rating ?>/5)
    </div>

    <?php if ($model->img): ?>
      <div style="margin-top: 15px;">
        <?= Html::img('@web/uploads/reviews/' . $model->img, [
          'class' => 'img-thumbnail',
          'style' => 'max-width: 200px;',
          'alt' => Html::encode($model->title)
        ]) ?>
      </div>
    <?php endif; ?>

    <hr>

    <div class="review-meta">
      <small class="text-muted">
        Опубликовано: <?= Yii::$app->formatter->asDatetime($model->date_create) ?>
      </small>
    </div>
  </div>
</div>