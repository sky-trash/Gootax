<?php

use yii\helpers\Html;

/** @var app\models\Review $model */
?>

<div class="review-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 4px;">
  <h3>
    <?= Html::encode($model->title) ?>
    <span style="background: #17a2b8; color: white; padding: 3px 8px; border-radius: 3px; font-size: 0.8em; margin-left: 10px;">
      <?= $model->cityName ?>
    </span>
  </h3>

  <div style="margin-bottom: 10px;">
    <p><?= nl2br(Html::encode($model->text)) ?></p>

    <div class="rating" style="margin: 10px 0;">
      <strong>Рейтинг:</strong>
      <?php for ($i = 1; $i <= 5; $i++): ?>
        <span style="color: <?= $i <= $model->rating ? '#ffd700' : '#ccc' ?>;">★</span>
      <?php endfor; ?>
      (<?= $model->rating ?>/5)
    </div>
  </div>

  <?php if ($model->img): ?>
    <div style="margin: 15px 0;">
      <?= Html::img('/uploads/reviews/' . $model->img, [
        'style' => 'max-width: 200px; height: auto; border: 1px solid #ddd; padding: 3px;',
        'alt' => Html::encode($model->title)
      ]) ?>
    </div>
  <?php endif; ?>

  <hr style="margin: 15px 0;">

  <div style="font-size: 0.9em; color: #666;">
    Опубликовано: <?= Yii::$app->formatter->asDatetime($model->date_create) ?>
  </div>
</div>