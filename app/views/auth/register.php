<div class="page-header">
  <span class="section-num">Accès membre</span>
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
             placeholder="Votre nom complet">
    </div>
    <div class="mb-3">
      <label class="form-label"><?php echo I18n::t('auth.email'); ?></label>
      <input type="email" name="email" class="form-control" required
             placeholder="votre@email.com">
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
      <label class="form-label">Langue préférée</label>
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
    Déjà un compte ?
    <a href="<?php echo $app['base_url']; ?>/login"
       style="color:var(--green); font-weight:600; text-decoration:none;">
      Se connecter &rarr;
    </a>
  </p>
</div>
