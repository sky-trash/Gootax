<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Post $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Управление записями', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-view">
  <h1><?= Html::encode($this->title) ?></h1>

  <p>
    <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
      'class' => 'btn btn-danger',
      'data' => [
        'confirm' => 'Вы уверены, что хотите удалить эту запись?',
        'method' => 'post',
      ],
    ]) ?>
  </p>

  <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
      'id',
      'title',
      [
        'attribute' => 'content',
        'format' => 'ntext',
        'label' => 'Содержание'
      ],
      [
        'attribute' => 'status',
        'value' => $model->getStatusLabel(),
        'label' => 'Статус'
      ],
      [
        'attribute' => 'author_id',
        'value' => $model->author->username ?? 'Неизвестен',
        'label' => 'Автор'
      ],
      [
        'attribute' => 'created_at',
        'format' => 'datetime',
        'label' => 'Создано'
      ],
      [
        'attribute' => 'updated_at',
        'format' => 'datetime',
        'label' => 'Обновлено'
      ],
    ],
  ]) ?>
</div>