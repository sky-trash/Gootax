<?php require_once __DIR__ . '/header.php'; ?>

<div class="row justify-content-center">
  <div class="col-md-6 col-lg-4">
    <div class="card shadow">
      <div class="card-body">
        <h2 class="card-title text-center mb-4">Login</h2>

        <?php if (isset($errors['general'])): ?>
          <div class="alert alert-danger"><?= htmlspecialchars($errors['general'], ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>

        <form method="POST" action="/login.php">
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email"
              class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
              id="email"
              name="email"
              value="<?= htmlspecialchars($email ?? '', ENT_QUOTES, 'UTF-8') ?>"
              required>
            <?php if (isset($errors['email'])): ?>
              <div class="invalid-feedback"><?= htmlspecialchars($errors['email'], ENT_QUOTES, 'UTF-8') ?></div>
            <?php endif; ?>
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password"
              class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>"
              id="password"
              name="password"
              required>
            <?php if (isset($errors['password'])): ?>
              <div class="invalid-feedback"><?= htmlspecialchars($errors['password'], ENT_QUOTES, 'UTF-8') ?></div>
            <?php endif; ?>
          </div>

          <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>

        <div class="mt-3 text-center">
          <small class="text-muted">
            Test credentials: user@example.com / password
          </small>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>