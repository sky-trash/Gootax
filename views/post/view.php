<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ListView;
use yii\data\ActiveDataProvider;
use app\models\Comment;

/** @var app\models\Post $post */

$this->title = $post->title;
$this->params['breadcrumbs'][] = ['label' => 'Все записи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-view">
  <article class="post">
    <h1><?= Html::encode($post->title) ?></h1>

    <div class="post-meta">
      <span class="author">Автор: <?= Html::encode($post->author->username ?? 'Неизвестен') ?></span>
      <span class="date">Опубликовано: <?= Yii::$app->formatter->asDatetime($post->created_at) ?></span>
      <span class="status">Статус: <?= $post->getStatusLabel() ?></span>
    </div>

    <div class="post-content">
      <?= nl2br(Html::encode($post->content)) ?>
    </div>
  </article>

  <!-- Комментарии -->
  <div class="comments-section">
    <h3>Комментарии</h3>

    <?php
    $commentsDataProvider = new ActiveDataProvider([
      'query' => Comment::find()->where(['post_id' => $post->id])->with('author'),
      'pagination' => [
        'pageSize' => 10,
      ],
      'sort' => [
        'defaultOrder' => [
          'created_at' => SORT_ASC,
        ]
      ],
    ]);
    ?>

    <?= ListView::widget([
      'dataProvider' => $commentsDataProvider,
      'itemView' => '_comment',
      'layout' => "{items}\n{pager}",
      'emptyText' => 'Пока нет комментариев.',
    ]) ?>

    <!-- Форма комментария -->
    <div class="comment-form">
      <h4>Добавить комментарий</h4>
      <?php $commentModel = new Comment(); ?>
      <?= $this->render('../comment/_form', [
        'model' => $commentModel,
        'post_id' => $post->id,
      ]) ?>
    </div>
  </div>

  <div class="post-actions">
    <?= Html::a('Назад к записям', ['index'], ['class' => 'btn btn-default']) ?>
  </div>
</div>