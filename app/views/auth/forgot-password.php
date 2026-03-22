<div class="page-header">
  <span class="section-num"><?php echo I18n::t('auth.member_access'); ?></span>
  <h1 class="page-title"><?php echo I18n::t('auth.forgot_password'); ?></h1>
  <p class="page-subtitle"><?php echo I18n::t('auth.forgot_password_hint'); ?></p>
</div>

<div class="auth-wrapper">
  <?php if (!empty($success)): ?>
    <div class="alert alert-success mb-4">
      <?php echo htmlspecialchars($success); ?>
    </div>
    <p style="font-size:0.82rem;">
      <a href="<?php echo $app['base_url']; ?>/login"
         style="color:var(--gold); text-decoration:none; letter-spacing:0.06em;">
        &larr; <?php echo I18n::t('nav.login'); ?>
      </a>
    </p>
  <?php else: ?>
    <form method="post" class="card" style="padding: 2.5rem;">
      <input type="hidden" name="csrf" value="<?php echo htmlspecialchars(Auth::csrfToken()); ?>">

      <div class="mb-4">
        <label class="form-label"><?php echo I18n::t('auth.email'); ?></label>
        <input type="email" name="email" class="form-control" required autofocus
               placeholder="<?php echo I18n::t('auth.email_placeholder'); ?>"
               value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
      </div>

      <button class="btn btn-primary w-100" type="submit" id="submitBtn">
        <?php echo I18n::t('auth.send_reset_link'); ?>
      </button>

      <p class="text-center mt-4 mb-0" style="font-size:0.8rem; letter-spacing:0.04em;">
        <a href="<?php echo $app['base_url']; ?>/login"
           style="color:var(--text-muted); text-decoration:none;">
          &larr; <?php echo I18n::t('nav.login'); ?>
        </a>
      </p>
    </form>
  <?php endif; ?>
</div>
