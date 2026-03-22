<div class="page-header">
  <span class="section-num"><?php echo I18n::t('auth.member_access'); ?></span>
  <h1 class="page-title"><?php echo I18n::t('nav.login'); ?></h1>
</div>

<div class="auth-wrapper">
  <?php if (!empty($error)): ?>
    <div class="alert alert-danger mb-4"><?php echo htmlspecialchars($error); ?></div>
  <?php endif; ?>

  <form method="post" class="auth-card" style="max-width:100%; margin:0 0 1.5rem;">
    <input type="hidden" name="csrf" value="<?php echo htmlspecialchars(Auth::csrfToken()); ?>">

    <div class="mb-3">
      <label class="form-label"><?php echo I18n::t('auth.email'); ?></label>
      <input type="email" name="email" class="form-control" required
             autocomplete="email" placeholder="<?php echo I18n::t('auth.email_placeholder'); ?>">
    </div>

    <div class="mb-1">
      <label class="form-label"><?php echo I18n::t('auth.password'); ?></label>
      <div class="position-relative">
        <input type="password" name="password" id="password" class="form-control"
               required autocomplete="current-password">
        <i class="bi bi-eye position-absolute top-50 end-0 translate-middle-y me-3"
           onclick="togglePassword('password')"
           style="cursor:pointer; color:var(--text-muted); font-size:0.9rem;"></i>
      </div>
    </div>

    <p class="mb-4" style="font-size:0.82rem; margin-top:0.5rem;">
      <a href="<?php echo $app['base_url']; ?>/forgot-password"
         style="font-family:var(--f-handwritten);font-size:0.95rem;color:var(--text-muted);text-decoration:none;border-bottom:1px dashed var(--border-light);">
        <?php echo I18n::t('auth.forgot_password_link'); ?>
      </a>
    </p>

    <button class="btn btn-primary w-100" type="submit" id="submitBtn">
      <?php echo I18n::t('auth.login'); ?>
    </button>
  </form>

  <p class="text-center mt-3" style="font-size:0.84rem; color:var(--text-muted);">
    <?php echo I18n::t('auth.no_account'); ?>
    <a href="<?php echo $app['base_url']; ?>/register"
       style="color:var(--green); font-weight:600; text-decoration:none;">
      <?php echo I18n::t('auth.sign_up'); ?>
    </a>
  </p>
</div>
