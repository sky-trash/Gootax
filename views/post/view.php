<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var app\models\Post $post */

$this->title = $post->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-view">
  <article class="post">
    <h1><?= Html::encode($post->title) ?></h1>

    <div class="post-meta">
      <span class="author">By <?= Html::encode($post->author->username ?? 'Unknown') ?></span>
      <span class="date">on <?= Yii::$app->formatter->asDatetime($post->created_at) ?></span>
      <span class="status">Status: <?= $post->getStatusLabel() ?></span>
    </div>

    <div class="post-content">
      <?= Yii::$app->formatter->asParagraphs($post->content) ?>
    </div>
  </article>

  <div class="post-actions">
    <?= Html::a('Back to Posts', ['index'], ['class' => 'btn btn-default']) ?>
  </div>
</div>