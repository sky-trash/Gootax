<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var app\models\Review $model */
?>

<div class="review-item panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><?= Html::encode($model->title) ?></h3>
  </div>
  <div class="panel-body">
    <div class="row">
      <div class="col-md-8">
        <p><?= nl2br(Html::encode($model->text)) ?></p>

        <div class="rating">
          <strong>Рейтинг:</strong>
          <?php for ($i = 1; $i <= 5; $i++): ?>
            <span class="glyphicon glyphicon-star<?= $i <= $model->rating ? '' : '-empty' ?>"></span>
          <?php endfor; ?>
          (<?= $model->rating ?>/5)
        </div>
      </div>

      <?php if ($model->img): ?>
        <div class="col-md-4">
          <?= Html::img('@web/uploads/reviews/' . $model->img, [
            'class' => 'img-responsive img-thumbnail',
            'alt' => Html::encode($model->title)
          ]) ?>
        </div>
      <?php endif; ?>
    </div>

    <hr>

    <div class="review-meta">
      <small class="text-muted">
        Автор:
        <?php if (Yii::$app->user->isGuest): ?>
          <?= Html::encode($model->author->fio) ?>
        <?php else: ?>
          <a href="#" class="author-link" data-author-id="<?= $model->author->id ?>">
            <?= Html::encode($model->author->fio) ?>
          </a>
        <?php endif; ?>

        | Опубликовано: <?= Yii::$app->formatter->asDatetime($model->date_create) ?>
      </small>
    </div>
  </div>
</div>