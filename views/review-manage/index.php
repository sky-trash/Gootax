<?php

use yii\helpers\Html;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Мои отзывы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="review-manage-index">
  <div class="row">
    <div class="col-md-12">
      <h1><?= Html::encode($this->title) ?></h1>

      <p>
        <?= Html::a('Создать отзыв', ['create'], ['class' => 'btn btn-success']) ?>
      </p>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
          ['class' => 'yii\grid\SerialColumn'],
          'title',
          [
            'attribute' => 'id_city',
            'value' => function ($model) {
              return $model->cityName;
            },
            'label' => 'Город'
          ],
          'rating',
          [
            'attribute' => 'date_create',
            'format' => 'datetime',
            'label' => 'Дата создания'
          ],
          [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view} {update} {delete}',
            'buttons' => [
              'view' => function ($url, $model) {
                // Проверяем, существует ли город
                if ($model->city && $model->city->id) {
                  return Html::a('Просмотр', ['review/city', 'id' => $model->city->id], [
                    'class' => 'btn btn-sm btn-default'
                  ]);
                } else {
                  // Альтернативное действие, если город не указан
                  return Html::a('Просмотр', ['view', 'id' => $model->id], [
                    'class' => 'btn btn-sm btn-default'
                  ]);
                }
              },
              'update' => function ($url, $model) {
                return Html::a('Редактировать', ['update', 'id' => $model->id], [
                  'class' => 'btn btn-sm btn-primary'
                ]);
              },
              'delete' => function ($url, $model) {
                return Html::a('Удалить', ['delete', 'id' => $model->id], [
                  'class' => 'btn btn-sm btn-danger',
                  'data' => [
                    'confirm' => 'Вы уверены, что хотите удалить этот отзыв?',
                    'method' => 'post',
                  ],
                ]);
              }
            ],
          ],
        ],
      ]); ?>
    </div>
  </div>
</div>