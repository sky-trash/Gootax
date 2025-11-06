<?php

use yii\helpers\Html;
use yii\helpers\StringHelper;

/** @var app\models\Post $model */

?>
<div class="post">
  <h2><?= Html::a(Html::encode($model->title), ['view', 'id' => $model->id]) ?></h2>

  <div class="post-meta">
    <span class="author">Автор: <?= Html::encode($model->author->username ?? 'Неизвестен') ?></span>
    <span class="date">Опубликовано: <?= Yii::$app->formatter->asDatetime($model->created_at) ?></span>
  </div>

  <div class="post-content">
    <?= StringHelper::truncateWords(strip_tags($model->content), 50) ?>
  </div>

  <div class="post-read-more">
    <?= Html::a('Читать далее →', ['view', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
  </div>
</div>

<hr>