<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">Feedback System</a>

            <?php if (Auth::isLoggedIn()): ?>
                <div class="navbar-nav ms-auto">
                    <span class="navbar-text me-3">
                        Welcome, <?= htmlspecialchars(Auth::getUserName(), ENT_QUOTES, 'UTF-8') ?>
                    </span>
                    <a class="nav-link" href="/feedback.php">Feedback</a>
                    <a class="nav-link" href="/login.php?action=logout">Logout</a>
                </div>
            <?php endif; ?>
        </div>
    </nav>

    <main class="container mt-4">