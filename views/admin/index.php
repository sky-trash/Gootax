<?php

use yii\helpers\Html;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Управление записями';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-index">
  <h1><?= Html::encode($this->title) ?></h1>

  <p>
    <?= Html::a('Создать запись', ['create'], ['class' => 'btn btn-success']) ?>
  </p>

  <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
      ['class' => 'yii\grid\SerialColumn'],
      'id',
      'title',
      [
        'attribute' => 'author_id',
        'value' => function ($model) {
          return $model->author->username ?? 'Неизвестен';
        },
        'label' => 'Автор'
      ],
      [
        'attribute' => 'status',
        'value' => function ($model) {
          return $model->getStatusLabel();
        },
        'label' => 'Статус'
      ],
      [
        'attribute' => 'created_at',
        'format' => 'datetime',
        'label' => 'Создано'
      ],
      [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{view} {update} {delete}',
        'header' => 'Действия'
      ],
    ],
  ]); ?>
</div>