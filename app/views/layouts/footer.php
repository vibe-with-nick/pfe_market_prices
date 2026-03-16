</main>

<!-- Navigation mobile (bas d'écran) -->
<nav class="mobile-bottom-nav d-lg-none" aria-label="Navigation mobile">
  <a href="<?php echo $app['base_url']; ?>/home" class="mobile-nav-item">
    <i class="bi bi-house"></i>
    <span><?php echo I18n::t('nav.home'); ?></span>
  </a>
  <a href="<?php echo $app['base_url']; ?>/prices" class="mobile-nav-item">
    <i class="bi bi-bar-chart"></i>
    <span><?php echo I18n::t('nav.prices'); ?></span>
  </a>
  <a href="<?php echo $app['base_url']; ?>/prices/predict" class="mobile-nav-item">
    <i class="bi bi-graph-up-arrow"></i>
    <span>Predict</span>
  </a>
  <a href="<?php echo $app['base_url']; ?>/prices/submit" class="mobile-nav-item">
    <i class="bi bi-plus-circle"></i>
    <span><?php echo I18n::t('btn.contribute'); ?></span>
  </a>
  <?php if (Auth::check()): ?>
    <a href="<?php echo $app['base_url']; ?>/logout" class="mobile-nav-item">
      <i class="bi bi-box-arrow-right"></i>
      <span>Logout</span>
    </a>
  <?php else: ?>
    <a href="<?php echo $app['base_url']; ?>/login" class="mobile-nav-item">
      <i class="bi bi-person"></i>
      <span>Login</span>
    </a>
  <?php endif; ?>
</nav>

<footer>
  <div class="container">
    <div class="row g-5">
      <div class="col-md-4">
        <h5><?php echo htmlspecialchars($app['app_name']); ?></h5>
        <p style="color: rgba(168,164,158,0.75); line-height:1.8;">
          Suivi des prix des fruits et légumes à Maurice.
          Contribuez et consultez les données du marché local.
        </p>
      </div>
      <div class="col-md-2 offset-md-1">
        <h6>Navigation</h6>
        <ul class="list-unstyled mb-0">
          <li><a href="<?php echo $app['base_url']; ?>/home">Accueil</a></li>
          <li><a href="<?php echo $app['base_url']; ?>/prices">Prix</a></li>
          <li><a href="<?php echo $app['base_url']; ?>/prices/submit">Contribuer</a></li>
          <li><a href="<?php echo $app['base_url']; ?>/prices/predict">Prédiction</a></li>
        </ul>
      </div>
      <div class="col-md-3">
        <h6>Contact</h6>
        <p class="mb-1" style="color: rgba(168,164,158,0.75);">
          <i class="bi bi-envelope me-2" style="font-size:.85rem;"></i>contact@market.mu
        </p>
        <p class="mb-3" style="color: rgba(168,164,158,0.75);">
          <i class="bi bi-telephone me-2" style="font-size:.85rem;"></i>+230 123 4567
        </p>
      </div>
      <div class="col-md-2">
        <h6>Réseaux</h6>
        <div class="d-flex gap-3">
          <a href="#"><i class="bi bi-facebook"></i></a>
          <a href="#"><i class="bi bi-twitter-x"></i></a>
          <a href="#"><i class="bi bi-instagram"></i></a>
        </div>
      </div>
    </div>
    <hr class="my-4">
    <div class="text-center small">
      © <?php echo date('Y'); ?> <?php echo htmlspecialchars($app['app_name']); ?> &mdash; Tous droits réservés.
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script src="<?php echo $app['base_url']; ?>/assets/js/app.js"></script>
</body>
</html>
