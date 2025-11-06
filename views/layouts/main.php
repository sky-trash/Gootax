<?php

/** @var yii\web\View $this */
/** @var string $content */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
    <?php $this->beginBody() ?>

    <div class="wrap">
        <?php
        NavBar::begin([
            'brandLabel' => 'Система отзывов',
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]);

        $menuItems = [
            ['label' => 'Главная', 'url' => ['/site/index']],
        ];

        if (Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => 'Вход', 'url' => ['/auth/login']];
            $menuItems[] = ['label' => 'Регистрация', 'url' => ['/auth/register']];
        } else {
            $menuItems[] = ['label' => 'Мои отзывы', 'url' => ['/review-manage/index']];
            $menuItems[] = ['label' => 'Создать отзыв', 'url' => ['/review-manage/create']];
            $menuItems[] = '<li>'
                . Html::beginForm(['/auth/logout'], 'post')
                . Html::submitButton(
                    'Выход (' . Yii::$app->user->identity->fio . ')',
                    ['class' => 'btn btn-link logout', 'style' => 'padding: 10px 15px; border: none;']
                )
                . Html::endForm()
                . '</li>';
        }

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => $menuItems,
        ]);
        NavBar::end();
        ?>

        <div class="container" style="margin-top: 70px;">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; Система отзывов <?= date('Y') ?></p>
            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

    <!-- Модальное окно для информации об авторе -->
    <div class="modal fade" id="author-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Контент будет загружен через AJAX -->
            </div>
        </div>
    </div>

    <!-- Прелоадер для AJAX -->
    <div id="ajax-loader" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 9999; background: rgba(255,255,255,0.8); padding: 20px; border-radius: 5px;">
        <div class="text-center">
            <i class="glyphicon glyphicon-refresh glyphicon-spin" style="font-size: 40px;"></i>
            <p>Загрузка...</p>
        </div>
    </div>

    <?php
    $js = <<<JS
$(document).on('click', '.author-link', function(e) {
    e.preventDefault();
    var authorId = $(this).data('author-id');
    
    $('#author-modal .modal-content').html('<div class="text-center"><i class="glyphicon glyphicon-refresh glyphicon-spin"></i> Загрузка...</div>');
    $('#author-modal').modal('show');
    
    $.get('/review/view?id=' + authorId, function(data) {
        $('#author-modal .modal-content').html(data);
    }).fail(function() {
        $('#author-modal .modal-content').html('<div class="alert alert-danger">Ошибка загрузки данных</div>');
    });
});

// Прелоадер для AJAX запросов
$(document).ajaxStart(function() {
    $('#ajax-loader').show();
}).ajaxStop(function() {
    $('#ajax-loader').hide();
});
JS;

    $this->registerJs($js);
    ?>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>