<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var app\models\User $author */
?>

<div class="modal-header" style="padding: 15px; border-bottom: 1px solid #e5e5e5;">
  <h5 class="modal-title">Информация об авторе</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">
    <span aria-hidden="true">&times;</span>
  </button>
</div>

<div class="modal-body" style="padding: 15px;">
  <div class="row">
    <div class="col-md-12">
      <p><strong>ФИО:</strong> <?= Html::encode($author->fio) ?></p>
      <p><strong>Email:</strong> <?= Html::encode($author->email) ?></p>
      <?php if ($author->phone): ?>
        <p><strong>Телефон:</strong> <?= Html::encode($author->phone) ?></p>
      <?php endif; ?>

      <hr style="margin: 15px 0;">

      <p>
        <?= Html::a('Посмотреть все отзывы автора', ['review/author', 'id' => $author->id], [
          'class' => 'btn btn-primary',
          'target' => '_blank'
        ]) ?>
      </p>
    </div>
  </div>
</div>

<div class="modal-footer" style="padding: 15px; border-top: 1px solid #e5e5e5;">
  <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
</div>