<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var app\models\City $city */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Отзывы о городе: ' . $city->name;
$this->params['breadcrumbs'][] = ['label' => 'Выбор города', 'url' => ['site/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="review-city">
  <div class="row">
    <div class="col-md-12">
      <h1><?= Html::encode($this->title) ?></h1>

      <div style="margin-bottom: 20px;">
        <?= Html::a('Сменить город', ['site/clear-city'], [
          'class' => 'btn btn-default'
        ]) ?>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_review',
        'layout' => "{items}\n{pager}",
        'emptyText' => 'Пока нет отзывов об этом городе.',
      ]) ?>
    </div>
  </div>
</div>