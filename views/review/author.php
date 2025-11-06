<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var app\models\User $author */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Все отзывы автора: ' . $author->fio;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="review-author">
  <div class="row">
    <div class="col-md-12">
      <h1><?= Html::encode($this->title) ?></h1>

      <div class="author-info" style="background: #f8f9fa; padding: 15px; border-radius: 4px; margin-bottom: 20px;">
        <p><strong>Email:</strong> <?= Html::encode($author->email) ?></p>
        <?php if ($author->phone): ?>
          <p><strong>Телефон:</strong> <?= Html::encode($author->phone) ?></p>
        <?php endif; ?>
        <p><strong>Зарегистрирован:</strong> <?= Yii::$app->formatter->asDatetime($author->date_create) ?></p>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_review_author',
        'layout' => "{items}\n{pager}",
        'emptyText' => 'У этого автора пока нет отзывов.',
      ]) ?>
    </div>
  </div>
</div>