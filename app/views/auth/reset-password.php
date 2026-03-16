<h1 class="h4 mb-1"><?php echo I18n::t('auth.reset_password'); ?></h1>
<p class="text-muted mb-4" style="font-size:.85rem;"><?php echo I18n::t('auth.reset_password_hint'); ?></p>

<?php if (!empty($error) && empty($token)): ?>
  <div class="alert alert-danger fade-in" style="max-width:520px">
    <i class="bi bi-exclamation-triangle me-2"></i><?php echo htmlspecialchars($error); ?>
  </div>
  <p class="mt-3" style="font-size:.85rem;">
    <a href="<?php echo $app['base_url']; ?>/forgot-password"><?php echo I18n::t('auth.request_new_link'); ?></a>
  </p>

<?php elseif (!empty($success)): ?>
  <div class="alert alert-success fade-in" style="max-width:520px">
    <i class="bi bi-check-circle me-2"></i><?php echo htmlspecialchars($success); ?>
  </div>
  <p class="mt-3" style="font-size:.85rem;">
    <a href="<?php echo $app['base_url']; ?>/login">&rarr; <?php echo I18n::t('nav.login'); ?></a>
  </p>

<?php else: ?>

  <?php if (!empty($error)): ?>
    <div class="alert alert-danger fade-in" style="max-width:520px">
      <i class="bi bi-exclamation-triangle me-2"></i><?php echo htmlspecialchars($error); ?>
    </div>
  <?php endif; ?>

  <form method="post" action="?token=<?php echo urlencode($token ?? ''); ?>"
        class="card p-4 fade-in" style="max-width:520px">
    <input type="hidden" name="csrf"  value="<?php echo htmlspecialchars(Auth::csrfToken()); ?>">

    <div class="mb-3">
      <label class="form-label"><?php echo I18n::t('auth.new_password'); ?></label>
      <div class="position-relative">
        <input type="password" name="new_password" id="new_password"
               class="form-control" required minlength="8" autofocus>
        <i class="bi bi-eye position-absolute top-50 end-0 translate-middle-y me-3"
           onclick="togglePassword('new_password')" style="cursor:pointer;"></i>
      </div>
      <div class="form-text" style="font-size:.72rem;letter-spacing:.04em;text-transform:uppercase;">
        <?php echo I18n::t('auth.new_password_short'); ?>
      </div>
    </div>

    <div class="mb-4">
      <label class="form-label"><?php echo I18n::t('auth.confirm_password'); ?></label>
      <div class="position-relative">
        <input type="password" name="confirm_password" id="confirm_password"
               class="form-control" required>
        <i class="bi bi-eye position-absolute top-50 end-0 translate-middle-y me-3"
           onclick="togglePassword('confirm_password')" style="cursor:pointer;"></i>
      </div>
    </div>

    <button class="btn btn-primary w-100" type="submit" id="submitBtn">
      <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
      <?php echo I18n::t('auth.reset_password_btn'); ?>
    </button>
  </form>

<?php endif; ?>
