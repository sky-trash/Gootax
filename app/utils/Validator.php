<?php

class Validator
{
    public static function validateEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function validateRequired(string $value, int $minLength = 1): bool
    {
        return strlen(trim($value)) >= $minLength;
    }

    public static function sanitize(string $input): string
    {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }

    public static function validateInArray($value, array $allowed): bool
    {
        return in_array($value, $allowed, true);
    }
}
