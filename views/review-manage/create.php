<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Review $model */

$this->title = 'Создать отзыв';
$this->params['breadcrumbs'][] = ['label' => 'Мои отзывы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs(<<<JS
    // AJAX отправка формы
    $('#review-form').on('beforeSubmit', function(e) {
        e.preventDefault();
        
        var form = $(this);
        var submitBtn = form.find('button[type="submit"]');
        var originalText = submitBtn.text();
        
        // Показываем прелоадер
        submitBtn.prop('disabled', true).text('Сохранение...');
        
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    window.location.href = response.redirectUrl;
                } else {
                    // Обновляем форму с ошибками
                    form.html($(response).find('#review-form').html());
                    initFormEvents();
                }
            },
            error: function() {
                alert('Произошла ошибка при сохранении');
                submitBtn.prop('disabled', false).text(originalText);
            }
        });
        
        return false;
    });
    
    function initFormEvents() {
        // Переинициализация событий после обновления формы
        $('#review-form').on('beforeSubmit', arguments.callee);
    }
    
    // Счетчик символов для текста
    $('#review-text').on('input', function() {
        var length = $(this).val().length;
        var maxLength = 255;
        var counter = $('#text-counter');
        
        if (!counter.length) {
            $(this).after('<div id="text-counter" style="font-size: 0.8em; color: #666;"></div>');
            counter = $('#text-counter');
        }
        
        counter.text(length + '/' + maxLength + ' символов');
        
        if (length > maxLength) {
            counter.css('color', 'red');
        } else {
            counter.css('color', '#666');
        }
    });
JS
);
?>
<div class="review-manage-create">
    <div class="row">
        <div class="col-md-8">
            <div class="panel" style="border: 1px solid #ddd; padding: 15px; border-radius: 4px;">
                <h2><?= Html::encode($this->title) ?></h2>
                
                <?php $form = ActiveForm::begin([
                    'id' => 'review-form',
                    'options' => ['enctype' => 'multipart/form-data'],
                    'enableAjaxValidation' => true,
                ]); ?>

                    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'text')->textarea(['rows' => 6, 'maxlength' => 255, 'id' => 'review-text']) ?>

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
        <div class="col-md-4">
            <div class="panel" style="background: #f8f9fa; padding: 15px; border-radius: 4px;">
                <h3>Правила создания отзывов</h3>
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