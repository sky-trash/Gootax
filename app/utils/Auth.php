<?php

class Auth
{
    public static function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function login(int $userId, string $email, string $name): void
    {
        self::startSession();
        $_SESSION['user_id'] = $userId;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_name'] = $name;
    }

    public static function logout(): void
    {
        self::startSession();
        session_destroy();
    }

    public static function isLoggedIn(): bool
    {
        self::startSession();
        return isset($_SESSION['user_id']);
    }

    public static function getUserId(): ?int
    {
        self::startSession();
        return $_SESSION['user_id'] ?? null;
    }

    public static function getUserEmail(): ?string
    {
        self::startSession();
        return $_SESSION['user_email'] ?? null;
    }

    public static function getUserName(): ?string
    {
        self::startSession();
        return $_SESSION['user_name'] ?? null;
    }

    public static function requireAuth(): void
    {
        if (!self::isLoggedIn()) {
            header('Location: /login.php');
            exit;
        }
    }
}
