<h1 class="h4 mb-1"><?php echo I18n::t('auth.forgot_password'); ?></h1>
<p class="text-muted mb-4" style="font-size:.85rem;"><?php echo I18n::t('auth.forgot_password_hint'); ?></p>

<?php if (!empty($success)): ?>
  <div class="alert alert-success fade-in" style="max-width:520px">
    <i class="bi bi-check-circle me-2"></i><?php echo htmlspecialchars($success); ?>
  </div>
  <p class="mt-3" style="font-size:.85rem;">
    <a href="<?php echo $app['base_url']; ?>/login">&larr; <?php echo I18n::t('nav.login'); ?></a>
  </p>
<?php else: ?>

<form method="post" class="card p-4 fade-in" style="max-width:520px">
  <input type="hidden" name="csrf" value="<?php echo htmlspecialchars(Auth::csrfToken()); ?>">

  <div class="mb-4">
    <label class="form-label"><?php echo I18n::t('auth.email'); ?></label>
    <input type="email" name="email" class="form-control" required autofocus
           placeholder="vous@exemple.com"
           value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
  </div>

  <button class="btn btn-primary w-100" type="submit" id="submitBtn">
    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
    <?php echo I18n::t('auth.send_reset_link'); ?>
  </button>

  <p class="text-center mt-3 mb-0" style="font-size:.8rem;">
    <a href="<?php echo $app['base_url']; ?>/login">&larr; <?php echo I18n::t('nav.login'); ?></a>
  </p>
</form>

<?php endif; ?>
