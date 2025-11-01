<?php

class AuthController
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->showLoginForm();
            return;
        }

        $email = Validator::sanitize($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $errors = [];

        if (!Validator::validateEmail($email)) {
            $errors['email'] = 'Пожалуйста, введите корректный email адрес';
        }

        if (!Validator::validateRequired($password)) {
            $errors['password'] = 'Пароль обязателен для заполнения';
        }

        if (empty($errors)) {
            $user = $this->userModel->findByEmail($email);

            if ($user && $this->userModel->verifyPassword($password, $user['password_hash'])) {
                Auth::login($user['id'], $user['email'], $user['name']);
                header('Location: /feedback.php');
                exit;
            } else {
                $errors['general'] = 'Неверный email или пароль';
            }
        }

        $this->showLoginForm($errors, $email);
    }

    public function showLoginForm(array $errors = [], string $email = ''): void
    {
        require __DIR__ . '/../../templates/login_form.php';
    }

    public function logout(): void
    {
        Auth::logout();
        header('Location: /login.php');
        exit;
    }
}
