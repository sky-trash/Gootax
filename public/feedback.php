<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
}

$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $success = true;
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Обратная связь - Система обратной связи</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .feedback-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">Система обратной связи</a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">
                    Добро пожаловать, <strong><?= htmlspecialchars($_SESSION['user_name'] ?? 'Пользователь') ?></strong>
                </span>
                <a class="nav-link" href="/login.php?logout=1">Выйти</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <?php if ($success): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        Спасибо за ваш отзыв! Он был успешно отправлен.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                <div class="card feedback-card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Форма обратной связи</h4>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST">
                            <div class="mb-3">
                                <label for="subject" class="form-label">Тема *</label>
                                <input type="text" class="form-control" id="subject" name="subject"
                                    placeholder="Введите тему отзыва" required>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Сообщение *</label>
                                <textarea class="form-control" id="message" name="message"
                                    rows="5" placeholder="Введите ваш подробный отзыв" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Оценка *</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="rating"
                                            id="rating_poor" value="poor" required>
                                        <label class="form-check-label" for="rating_poor">Плохо</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="rating"
                                            id="rating_average" value="average">
                                        <label class="form-check-label" for="rating_average">Удовлетворительно</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="rating"
                                            id="rating_good" value="good">
                                        <label class="form-check-label" for="rating_good">Хорошо</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="rating"
                                            id="rating_excellent" value="excellent">
                                        <label class="form-check-label" for="rating_excellent">Отлично</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Категории</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="categories[]"
                                                id="category_service" value="service">
                                            <label class="form-check-label" for="category_service">Обслуживание</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="categories[]"
                                                id="category_quality" value="quality">
                                            <label class="form-check-label" for="category_quality">Качество</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="categories[]"
                                                id="category_price" value="price">
                                            <label class="form-check-label" for="category_price">Цена</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="categories[]"
                                                id="category_support" value="support">
                                            <label class="form-check-label" for="category_support">Поддержка</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="contact_method" class="form-label">Предпочтительный способ связи *</label>
                                <select class="form-select" id="contact_method" name="contact_method" required>
                                    <option value="">Выберите вариант...</option>
                                    <option value="email">Email</option>
                                    <option value="phone">Телефон</option>
                                    <option value="none">Не связываться</option>
                                </select>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-success btn-lg">
                                    Отправить отзыв
                                </button>
                                <button type="reset" class="btn btn-outline-secondary btn-lg">
                                    Сбросить форму
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card feedback-card mt-4">
                    <div class="card-body">
                        <h5>👤 Информация о пользователе</h5>
                        <p><strong>Имя:</strong> <?= htmlspecialchars($_SESSION['user_name'] ?? 'Не указано') ?></p>
                        <p><strong>Email:</strong> <?= htmlspecialchars($_SESSION['user_email'] ?? 'Не указан') ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>