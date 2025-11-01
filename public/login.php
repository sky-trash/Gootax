<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($email === 'user@example.com' && $password === 'password') {
        $_SESSION['user_id'] = 1;
        $_SESSION['user_email'] = 'user@example.com';
        $_SESSION['user_name'] = 'Тестовый Пользователь';

        header('Location: /feedback.php');
        exit;
    } else {
        $error = 'Неверный email или пароль';
    }
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход - Система обратной связи</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .login-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card login-card">
                    <div class="card-body p-5">
                        <h2 class="text-center mb-4 text-dark">Вход в систему</h2>

                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Email адрес</label>
                                <input type="email" name="email" class="form-control form-control-lg"
                                    value="user@example.com" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Пароль</label>
                                <input type="password" name="password" class="form-control form-control-lg"
                                    value="password" required>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">
                                Войти
                            </button>
                        </form>

                        <div class="text-center">
                            <small class="text-muted">
                                Тестовые данные: <strong>user@example.com</strong> / <strong>password</strong>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>