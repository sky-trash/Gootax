<?php require_once __DIR__ . '/header.php'; ?>

<div class="row">
  <div class="col-lg-8 mx-auto">
    <div class="card shadow">
      <div class="card-body">
        <h2 class="card-title mb-4">Форма обратной связи</h2>

        <?php if (isset($_GET['success'])): ?>
          <div class="alert alert-success">
            Спасибо за ваш отзыв! Он был успешно отправлен.
          </div>
        <?php endif; ?>

        <?php if (isset($errors['general'])): ?>
          <div class="alert alert-danger"><?= htmlspecialchars($errors['general']) ?></div>
        <?php endif; ?>

        <form method="POST" action="/feedback.php">
          <div class="mb-3">
            <label for="subject" class="form-label">Тема *</label>
            <input type="text"
              class="form-control <?= isset($errors['subject']) ? 'is-invalid' : '' ?>"
              id="subject"
              name="subject"
              value="<?= htmlspecialchars($data['subject'] ?? '') ?>"
              required>
            <?php if (isset($errors['subject'])): ?>
              <div class="invalid-feedback"><?= htmlspecialchars($errors['subject']) ?></div>
            <?php endif; ?>
          </div>
          <div class="mb-3">
            <label for="message" class="form-label">Сообщение *</label>
            <textarea class="form-control <?= isset($errors['message']) ? 'is-invalid' : '' ?>"
              id="message"
              name="message"
              rows="5"
              required><?= htmlspecialchars($data['message'] ?? '') ?></textarea>
            <?php if (isset($errors['message'])): ?>
              <div class="invalid-feedback"><?= htmlspecialchars($errors['message']) ?></div>
            <?php endif; ?>
          </div>
          <div class="mb-3">
            <label class="form-label">Оценка *</label>
            <div>
              <?php $currentRating = $data['rating'] ?? ''; ?>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="rating" id="rating_poor"
                  value="poor" <?= $currentRating === 'poor' ? 'checked' : '' ?> required>
                <label class="form-check-label" for="rating_poor">Плохо</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="rating" id="rating_average"
                  value="average" <?= $currentRating === 'average' ? 'checked' : '' ?>>
                <label class="form-check-label" for="rating_average">Удовлетворительно</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="rating" id="rating_good"
                  value="good" <?= $currentRating === 'good' ? 'checked' : '' ?>>
                <label class="form-check-label" for="rating_good">Хорошо</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="rating" id="rating_excellent"
                  value="excellent" <?= $currentRating === 'excellent' ? 'checked' : '' ?>>
                <label class="form-check-label" for="rating_excellent">Отлично</label>
              </div>
            </div>
            <?php if (isset($errors['rating'])): ?>
              <div class="text-danger small"><?= htmlspecialchars($errors['rating']) ?></div>
            <?php endif; ?>
          </div>
          <div class="mb-3">
            <label class="form-label">Категории</label>
            <div>
              <?php $currentCategories = $data['categories'] ?? []; ?>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="categories[]"
                  id="category_service" value="service"
                  <?= in_array('service', $currentCategories) ? 'checked' : '' ?>>
                <label class="form-check-label" for="category_service">Обслуживание</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="categories[]"
                  id="category_quality" value="quality"
                  <?= in_array('quality', $currentCategories) ? 'checked' : '' ?>>
                <label class="form-check-label" for="category_quality">Качество</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="categories[]"
                  id="category_price" value="price"
                  <?= in_array('price', $currentCategories) ? 'checked' : '' ?>>
                <label class="form-check-label" for="category_price">Цена</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="categories[]"
                  id="category_support" value="support"
                  <?= in_array('support', $currentCategories) ? 'checked' : '' ?>>
                <label class="form-check-label" for="category_support">Поддержка</label>
              </div>
            </div>
            <?php if (isset($errors['categories'])): ?>
              <div class="text-danger small"><?= htmlspecialchars($errors['categories']) ?></div>
            <?php endif; ?>
          </div>
          <div class="mb-3">
            <label for="contact_method" class="form-label">Предпочтительный способ связи *</label>
            <select class="form-select <?= isset($errors['contact_method']) ? 'is-invalid' : '' ?>"
              id="contact_method" name="contact_method" required>
              <option value="">Выберите вариант...</option>
              <option value="email" <?= ($data['contact_method'] ?? '') === 'email' ? 'selected' : '' ?>>Email</option>
              <option value="phone" <?= ($data['contact_method'] ?? '') === 'phone' ? 'selected' : '' ?>>Телефон</option>
              <option value="none" <?= ($data['contact_method'] ?? '') === 'none' ? 'selected' : '' ?>>Не связываться</option>
            </select>
            <?php if (isset($errors['contact_method'])): ?>
              <div class="invalid-feedback"><?= htmlspecialchars($errors['contact_method']) ?></div>
            <?php endif; ?>
          </div>
          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Отправить отзыв</button>
            <button type="reset" class="btn btn-secondary">Сбросить форму</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>