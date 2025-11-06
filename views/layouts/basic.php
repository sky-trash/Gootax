<?php

/** @var yii\web\View $this */
/** @var string $content */

use yii\helpers\Html;
use app\assets\SimpleAsset;

SimpleAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
  <meta charset="<?= Yii::$app->charset ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?= Html::csrfMetaTags() ?>
  <title><?= Html::encode($this->title) ?></title>
  <?php $this->head() ?>

  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    .header {
      background: #333;
      color: white;
      padding: 1rem;
    }

    .header a {
      color: white;
      text-decoration: none;
      margin: 0 10px;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px;
    }

    .footer {
      background: #f5f5f5;
      padding: 1rem;
      text-align: center;
      margin-top: 2rem;
    }

    .nav {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .nav-links {
      display: flex;
      gap: 15px;
      align-items: center;
    }

    .btn {
      padding: 8px 16px;
      background: #007bff;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      text-decoration: none;
      display: inline-block;
    }

    .btn:hover {
      background: #0056b3;
    }

    .btn-default {
      background: #6c757d;
    }

    .btn-default:hover {
      background: #545b62;
    }

    .btn-primary {
      background: #007bff;
    }

    .btn-primary:hover {
      background: #0056b3;
    }

    .btn-secondary {
      background: #6c757d;
    }

    .btn-secondary:hover {
      background: #545b62;
    }

    .btn-success {
      background: #28a745;
    }

    .btn-success:hover {
      background: #1e7e34;
    }

    .btn-danger {
      background: #dc3545;
    }

    .btn-danger:hover {
      background: #c82333;
    }

    .btn-link {
      background: none;
      color: white;
      border: none;
      padding: 0;
    }

    .btn-link:hover {
      background: none;
      color: #ccc;
    }

    .alert {
      padding: 12px;
      margin: 10px 0;
      border-radius: 4px;
    }

    .alert-success {
      background: #d4edda;
      color: #155724;
      border: 1px solid #c3e6cb;
    }

    .alert-error {
      background: #f8d7da;
      color: #721c24;
      border: 1px solid #f5c6cb;
    }

    .alert-info {
      background: #d1ecf1;
      color: #0c5460;
      border: 1px solid #bee5eb;
    }

    /* Модальное окно */
    .modal {
      display: none;
      position: fixed;
      z-index: 1000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
      background-color: #fefefe;
      margin: 5% auto;
      padding: 0;
      border: 1px solid #888;
      width: 80%;
      max-width: 500px;
      border-radius: 5px;
    }

    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
      cursor: pointer;
    }

    .close:hover {
      color: black;
    }

    /* Прелоадер */
    #ajax-loader {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      z-index: 9999;
      background: rgba(255, 255, 255, 0.9);
      padding: 20px;
      border-radius: 5px;
      border: 1px solid #ddd;
      text-align: center;
    }
  </style>
</head>

<body>
  <?php $this->beginBody() ?>

  <div class="header">
    <div class="nav">
      <h1 style="margin: 0; font-size: 1.5rem;">Система отзывов</h1>
      <div class="nav-links">
        <a href="/">Главная</a>
        <?php if (Yii::$app->user->isGuest): ?>
          <a href="/auth/login">Вход</a>
          <a href="/auth/register">Регистрация</a>
        <?php else: ?>
          <a href="/review-manage/index">Мои отзывы</a>
          <a href="/review-manage/create">Создать отзыв</a>
          <form method="post" action="/auth/logout" style="display: inline;">
            <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken ?>">
            <button type="submit" class="btn-link">Выход (<?= Yii::$app->user->identity->fio ?>)</button>
          </form>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <div class="container">
    <?php if (Yii::$app->session->hasFlash('success')): ?>
      <div class="alert alert-success"><?= Yii::$app->session->getFlash('success') ?></div>
    <?php endif; ?>

    <?php if (Yii::$app->session->hasFlash('error')): ?>
      <div class="alert alert-error"><?= Yii::$app->session->getFlash('error') ?></div>
    <?php endif; ?>

    <?php if (Yii::$app->session->hasFlash('info')): ?>
      <div class="alert alert-info"><?= Yii::$app->session->getFlash('info') ?></div>
    <?php endif; ?>

    <?= $content ?>
  </div>

  <div class="footer">
    &copy; Система отзывов <?= date('Y') ?> | <?= Yii::powered() ?>
  </div>

  <!-- Модальное окно для информации об авторе -->
  <div id="author-modal" class="modal">
    <div class="modal-content">
      <!-- Контент будет загружен через AJAX -->
    </div>
  </div>

  <!-- Прелоадер для AJAX -->
  <div id="ajax-loader">
    <div>Загрузка...</div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Обработка кликов по ссылкам авторов
      document.addEventListener('click', function(e) {
        if (e.target.classList.contains('author-link')) {
          e.preventDefault();
          var authorId = e.target.getAttribute('data-author-id');

          document.getElementById('author-modal').querySelector('.modal-content').innerHTML = '<div style="padding: 20px; text-align: center;">Загрузка...</div>';
          document.getElementById('author-modal').style.display = 'block';

          fetch('/review/view?id=' + authorId)
            .then(response => response.text())
            .then(data => {
              document.getElementById('author-modal').querySelector('.modal-content').innerHTML = data;
            })
            .catch(error => {
              document.getElementById('author-modal').querySelector('.modal-content').innerHTML = '<div class="alert alert-error">Ошибка загрузки данных</div>';
            });
        }
      });

      // Закрытие модального окна
      document.addEventListener('click', function(e) {
        if (e.target.classList.contains('close') || e.target.classList.contains('modal')) {
          document.getElementById('author-modal').style.display = 'none';
        }
      });

      // Прелоадер для AJAX
      var originalFetch = window.fetch;
      window.fetch = function(...args) {
        document.getElementById('ajax-loader').style.display = 'block';
        return originalFetch.apply(this, args)
          .then(response => {
            document.getElementById('ajax-loader').style.display = 'none';
            return response;
          })
          .catch(error => {
            document.getElementById('ajax-loader').style.display = 'none';
            throw error;
          });
      };
    });
  </script>

  <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>