<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\data\ActiveDataProvider;

/** @var ActiveDataProvider $dataProvider */

$this->title = 'Все записи блога';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">
  <h1><?= Html::encode($this->title) ?></h1>

  <?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_post',
    'layout' => "{items}\n{pager}",
    'options' => ['class' => 'post-list'],
    'itemOptions' => ['class' => 'post-item'],
  ]) ?>
</div>