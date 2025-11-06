<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/** @var yii\web\View $this */
/** @var app\models\Review $model */

$this->title = 'Создать отзыв';
$this->params['breadcrumbs'][] = ['label' => 'Мои отзывы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="review-manage-create">
  <div class="row">
    <div class="col-md-8">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="panel-body">
          <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

          <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

          <?= $form->field($model, 'text')->textarea(['rows' => 6, 'maxlength' => 255]) ?>

          <?= $form->field($model, 'rating')->dropDownList([
            1 => '1 - Ужасно',
            2 => '2 - Плохо',
            3 => '3 - Нормально',
            4 => '4 - Хорошо',
            5 => '5 - Отлично'
          ]) ?>

          <?= $form->field($model, 'id_city')->widget(Select2::class, [
            'options' => ['placeholder' => 'Начните вводить название города...'],
            'pluginOptions' => [
              'allowClear' => true,
              'minimumInputLength' => 2,
              'ajax' => [
                'url' => \yii\helpers\Url::to(['city-autocomplete']),
                'dataType' => 'json',
                'data' => new \yii\web\JsExpression('function(params) { return {q:params.term}; }'),
                'processResults' => new \yii\web\JsExpression('function(data) { return {results: data}; }')
              ],
            ],
          ])->label('Город (оставьте пустым, если отзыв для всех городов)') ?>

          <?= $form->field($model, 'imageFile')->fileInput() ?>

          <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
          </div>

          <?php ActiveForm::end(); ?>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="panel panel-info">
        <div class="panel-heading">
          <h3 class="panel-title">Правила создания отзывов</h3>
        </div>
        <div class="panel-body">
          <ul>
            <li>Название отзыва - до 100 символов</li>
            <li>Текст отзыва - до 255 символов</li>
            <li>Рейтинг от 1 до 5</li>
            <li>Можно загрузить одно изображение</li>
            <li>Если не выбрать город, отзыв будет для всех городов</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>