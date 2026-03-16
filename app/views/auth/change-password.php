<div class="page-header">
  <span class="section-num">Paramètres du compte</span>
  <h1 class="page-title"><?php echo I18n::t('auth.change_password'); ?></h1>
</div>

<div class="auth-wrapper">
  <?php if (!empty($error)): ?>
    <div class="alert alert-danger mb-4"><?php echo htmlspecialchars($error); ?></div>
  <?php endif; ?>
  <?php if (!empty($success)): ?>
    <div class="alert alert-success mb-4"><?php echo htmlspecialchars($success); ?></div>
  <?php endif; ?>

  <form method="post" class="card" style="padding: 2.5rem;">
    <input type="hidden" name="csrf" value="<?php echo htmlspecialchars(Auth::csrfToken()); ?>">

    <div class="mb-3">
      <label class="form-label"><?php echo I18n::t('auth.current_password'); ?></label>
      <div class="position-relative">
        <input type="password" name="current_password" id="current_password"
               class="form-control" required>
        <i class="bi bi-eye position-absolute top-50 end-0 translate-middle-y me-3"
           onclick="togglePassword('current_password')"
           style="cursor:pointer; color:var(--text-muted); font-size:0.9rem;"></i>
      </div>
    </div>
    <div class="mb-3">
      <label class="form-label"><?php echo I18n::t('auth.new_password'); ?></label>
      <div class="position-relative">
        <input type="password" name="new_password" id="new_password"
               class="form-control" required minlength="8">
        <i class="bi bi-eye position-absolute top-50 end-0 translate-middle-y me-3"
           onclick="togglePassword('new_password')"
           style="cursor:pointer; color:var(--text-muted); font-size:0.9rem;"></i>
      </div>
    </div>
    <div class="mb-4">
      <label class="form-label"><?php echo I18n::t('auth.confirm_password'); ?></label>
      <div class="position-relative">
        <input type="password" name="confirm_password" id="confirm_password"
               class="form-control" required>
        <i class="bi bi-eye position-absolute top-50 end-0 translate-middle-y me-3"
           onclick="togglePassword('confirm_password')"
           style="cursor:pointer; color:var(--text-muted); font-size:0.9rem;"></i>
      </div>
    </div>

    <button class="btn btn-primary w-100" type="submit" id="submitBtn">
      <?php echo I18n::t('auth.change_password'); ?>
    </button>
  </form>
</div>
