<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Review $model */

$this->title = 'Редактировать отзыв: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Мои отзывы', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="review-manage-update">
  <div class="row">
    <div class="col-md-8">
      <div class="panel" style="border: 1px solid #ddd; padding: 15px; border-radius: 4px;">
        <h2><?= Html::encode($this->title) ?></h2>

        <?php if ($model->img): ?>
          <div class="form-group">
            <label>Текущее изображение:</label><br>
            <?= Html::img('/uploads/reviews/' . $model->img, [
              'style' => 'max-width: 200px; height: auto; border: 1px solid #ddd; padding: 3px;'
            ]) ?>
            <br>
            <?= Html::a('Удалить изображение', ['delete-image', 'id' => $model->id], [
              'class' => 'btn btn-sm btn-danger',
              'style' => 'margin-top: 5px;',
              'data' => [
                'confirm' => 'Вы уверены, что хотите удалить изображение?',
                'method' => 'post',
              ],
            ]) ?>
          </div>
        <?php endif; ?>

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

        <?= $form->field($model, 'id_city')->dropDownList(
          \yii\helpers\ArrayHelper::map(
            \app\models\City::find()->orderBy('name')->all(),
            'id',
            'name'
          ),
          ['prompt' => 'Выберите город (необязательно)']
        )->label('Город (оставьте пустым, если отзыв для всех городов)') ?>

        <?= $form->field($model, 'imageFile')->fileInput() ?>

        <div class="form-group">
          <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
          <?= Html::a('Отмена', ['index'], ['class' => 'btn btn-default']) ?>
        </div>

        <?php ActiveForm::end(); ?>
      </div>
    </div>
  </div>
</div>