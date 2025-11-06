<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var app\models\User $author */
?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  <h4 class="modal-title">Информация об авторе</h4>
</div>

<div class="modal-body">
  <div class="row">
    <div class="col-md-12">
      <p><strong>ФИО:</strong> <?= Html::encode($author->fio) ?></p>
      <p><strong>Email:</strong> <?= Html::encode($author->email) ?></p>
      <?php if ($author->phone): ?>
        <p><strong>Телефон:</strong> <?= Html::encode($author->phone) ?></p>
      <?php endif; ?>

      <hr>

      <p>
        <?= Html::a('Посмотреть все отзывы автора', ['review/author', 'id' => $author->id], [
          'class' => 'btn btn-primary',
          'target' => '_blank'
        ]) ?>
      </p>
    </div>
  </div>
</div>

<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
</div>