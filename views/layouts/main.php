<?php

/** @var yii\web\View $this */
/** @var string $content */

use yii\helpers\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\bootstrap5\Breadcrumbs;
use app\assets\AppAsset;

// Временно используем CDN вместо AssetBundle
// AppAsset::register($this);
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

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

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
                'class' => 'navbar navbar-expand-lg navbar-dark bg-dark fixed-top',
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
            $menuItems[] = '<li class="nav-item">'
                . Html::beginForm(['/auth/logout'])
                . Html::submitButton(
                    'Выход (' . Yii::$app->user->identity->fio . ')',
                    ['class' => 'nav-link btn btn-link border-0']
                )
                . Html::endForm()
                . '</li>';
        }

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav ms-auto'],
            'items' => $menuItems,
        ]);
        NavBar::end();
        ?>

        <div class="container" style="margin-top: 76px;">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>

            <?php if (Yii::$app->session->hasFlash('success')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <?= Yii::$app->session->getFlash('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (Yii::$app->session->hasFlash('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <?= Yii::$app->session->getFlash('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (Yii::$app->session->hasFlash('info')): ?>
                <div class="alert alert-info alert-dismissible fade show">
                    <?= Yii::$app->session->getFlash('info') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?= $content ?>
        </div>
    </div>

    <footer class="footer mt-auto py-3 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <span class="text-muted">&copy; Система отзывов <?= date('Y') ?></span>
                </div>
                <div class="col-md-6 text-end">
                    <span class="text-muted"><?= Yii::powered() ?></span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Модальное окно для информации об авторе -->
    <div class="modal fade" id="author-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Контент будет загружен через AJAX -->
            </div>
        </div>
    </div>

    <!-- Прелоадер для AJAX -->
    <div id="ajax-loader" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 9999; background: rgba(255,255,255,0.9); padding: 20px; border-radius: 5px; border: 1px solid #ddd;">
        <div class="text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Загрузка...</span>
            </div>
            <p class="mt-2">Загрузка...</p>
        </div>
    </div>

    <?php
    $js = <<<JS
$(document).on('click', '.author-link', function(e) {
    e.preventDefault();
    var authorId = $(this).data('author-id');
    
    $('#author-modal .modal-content').html('<div class="text-center p-4"><div class="spinner-border"></div><br>Загрузка...</div>');
    var modal = new bootstrap.Modal(document.getElementById('author-modal'));
    modal.show();
    
    $.get('/review/view?id=' + authorId, function(data) {
        $('#author-modal .modal-content').html(data);
    }).fail(function() {
        $('#author-modal .modal-content').html('<div class="alert alert-danger m-0">Ошибка загрузки данных</div>');
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