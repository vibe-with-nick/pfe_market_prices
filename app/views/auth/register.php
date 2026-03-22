<div class="page-header">
  <span class="section-num"><?php echo I18n::t('auth.member_access'); ?></span>
  <h1 class="page-title"><?php echo I18n::t('nav.register'); ?></h1>
</div>

<div class="auth-wrapper">
  <?php if (!empty($errors)): ?>
    <div class="alert alert-danger mb-4">
      <ul class="mb-0 ps-3">
        <?php foreach ($errors as $e): ?>
          <li><?php echo htmlspecialchars($e); ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form method="post" class="auth-card" style="max-width:100%; margin:0 0 1.5rem;">
    <input type="hidden" name="csrf" value="<?php echo htmlspecialchars(Auth::csrfToken()); ?>">

    <div class="mb-3">
      <label class="form-label"><?php echo I18n::t('auth.name'); ?></label>
      <input type="text" name="name" class="form-control" required minlength="3"
             placeholder="<?php echo I18n::t('auth.name_placeholder'); ?>">
    </div>
    <div class="mb-3">
      <label class="form-label"><?php echo I18n::t('auth.email'); ?></label>
      <input type="email" name="email" class="form-control" required
             placeholder="<?php echo I18n::t('auth.email_placeholder'); ?>">
    </div>
    <div class="mb-3">
      <label class="form-label"><?php echo I18n::t('auth.password'); ?></label>
      <div class="position-relative">
        <input type="password" name="password" id="password" class="form-control"
               required minlength="8">
        <i class="bi bi-eye position-absolute top-50 end-0 translate-middle-y me-3"
           onclick="togglePassword('password')"
           style="cursor:pointer; color:var(--text-muted); font-size:0.9rem;"></i>
      </div>
    </div>
    <div class="mb-4">
      <label class="form-label"><?php echo I18n::t('auth.preferred_lang'); ?></label>
      <select class="form-select" name="lang">
        <option value="fr">🇫🇷 Français</option>
        <option value="en">🇬🇧 English</option>
        <option value="mfe">🇲🇺 Kreol</option>
      </select>
    </div>

    <button class="btn btn-primary w-100" type="submit" id="submitBtn">
      <?php echo I18n::t('auth.register'); ?>
    </button>
  </form>

  <p class="text-center mt-3" style="font-size:0.84rem; color:var(--text-muted);">
    <?php echo I18n::t('auth.already_account'); ?>
    <a href="<?php echo $app['base_url']; ?>/login"
       style="color:var(--green); font-weight:600; text-decoration:none;">
      <?php echo I18n::t('auth.sign_in_link'); ?>
    </a>
  </p>
</div>
