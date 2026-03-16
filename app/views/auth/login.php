<h1 class="h4 mb-3"><?php echo I18n::t('nav.login'); ?></h1>

<?php if (!empty($error)): ?>
  <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<form method="post" class="card p-3 fade-in" style="max-width:520px">
  <input type="hidden" name="csrf" value="<?php echo htmlspecialchars(Auth::csrfToken()); ?>">
  <div class="mb-3">
    <label class="form-label"><?php echo I18n::t('auth.email'); ?></label>
    <input type="email" name="email" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label"><?php echo I18n::t('auth.password'); ?></label>
    <div class="position-relative">
      <input type="password" name="password" id="password" class="form-control" required>
      <i class="bi bi-eye position-absolute top-50 end-0 translate-middle-y me-3" onclick="togglePassword('password')" style="cursor: pointer;"></i>
    </div>
  </div>
  <button class="btn btn-primary w-100" type="submit" id="submitBtn">
    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
    <?php echo I18n::t('auth.login'); ?>
  </button>

  <p class="text-center mt-3 mb-0" style="font-size:.8rem;">
    <a href="<?php echo $app['base_url']; ?>/forgot-password"><?php echo I18n::t('auth.forgot_password_link'); ?></a>
  </p>
</form>
