<div class="page-header">
  <span class="section-num">Accès membre</span>
  <h1 class="page-title"><?php echo I18n::t('nav.login'); ?></h1>
</div>

<div class="auth-wrapper">
  <?php if (!empty($error)): ?>
    <div class="alert alert-danger mb-4"><?php echo htmlspecialchars($error); ?></div>
  <?php endif; ?>

  <form method="post" class="card" style="padding: 2.5rem;">
    <input type="hidden" name="csrf" value="<?php echo htmlspecialchars(Auth::csrfToken()); ?>">

    <div class="mb-3">
      <label class="form-label"><?php echo I18n::t('auth.email'); ?></label>
      <input type="email" name="email" class="form-control" required
             autocomplete="email" placeholder="votre@email.com">
    </div>

    <div class="mb-4">
      <label class="form-label"><?php echo I18n::t('auth.password'); ?></label>
      <div class="position-relative">
        <input type="password" name="password" id="password" class="form-control"
               required autocomplete="current-password">
        <i class="bi bi-eye position-absolute top-50 end-0 translate-middle-y me-3"
           onclick="togglePassword('password')"
           style="cursor:pointer; color:var(--text-muted); font-size:0.9rem;"></i>
      </div>
    </div>

    <button class="btn btn-primary w-100" type="submit" id="submitBtn">
      <?php echo I18n::t('auth.login'); ?>
    </button>

    <p class="text-center mt-4 mb-0" style="font-size:0.8rem; letter-spacing:0.04em;">
      <a href="<?php echo $app['base_url']; ?>/forgot-password"
         style="color:var(--text-muted); text-decoration:none; transition:color .3s;"
         onmouseover="this.style.color='var(--gold)'" onmouseout="this.style.color='var(--text-muted)'">
        <?php echo I18n::t('auth.forgot_password_link'); ?>
      </a>
    </p>
  </form>

  <p class="text-center mt-4" style="font-size:0.82rem; letter-spacing:0.04em; color:var(--text-muted);">
    Pas encore de compte ?
    <a href="<?php echo $app['base_url']; ?>/register"
       style="color:var(--text-dark); font-weight:500; text-decoration:none;">
      S'inscrire
    </a>
  </p>
</div>
