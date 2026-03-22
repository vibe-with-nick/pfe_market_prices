</main>

<?php
try {
  $pdo = Database::pdo();
  $footerStats = $pdo->query("
    SELECT
      (SELECT COUNT(*) FROM price_submissions WHERE status='approved') AS total_prices,
      (SELECT COUNT(*) FROM markets)  AS total_markets,
      (SELECT COUNT(*) FROM products) AS total_products
  ")->fetch();
} catch (Exception $e) {
  $footerStats = ['total_prices'=>0,'total_markets'=>0,'total_products'=>0];
}
?>

<!-- Mobile bottom nav -->
<nav class="mobile-bottom-nav d-lg-none" aria-label="Navigation mobile">
  <a href="<?php echo $app['base_url']; ?>/home" class="mobile-nav-item" data-page="home">
    <span class="mobile-nav-indicator"></span>
    <i class="bi bi-house"></i>
    <span><?php echo I18n::t('nav.home'); ?></span>
  </a>
  <a href="<?php echo $app['base_url']; ?>/prices" class="mobile-nav-item" data-page="prices">
    <span class="mobile-nav-indicator"></span>
    <i class="bi bi-bar-chart"></i>
    <span><?php echo I18n::t('nav.prices'); ?></span>
  </a>
  <a href="<?php echo $app['base_url']; ?>/prices/predict" class="mobile-nav-item" data-page="predict">
    <span class="mobile-nav-indicator"></span>
    <i class="bi bi-graph-up-arrow"></i>
    <span>Predict</span>
  </a>
  <a href="<?php echo $app['base_url']; ?>/prices/submit" class="mobile-nav-item" data-page="submit">
    <span class="mobile-nav-indicator"></span>
    <i class="bi bi-plus-circle"></i>
    <span><?php echo I18n::t('btn.contribute'); ?></span>
  </a>
  <?php if (Auth::check()): ?>
    <a href="<?php echo $app['base_url']; ?>/logout" class="mobile-nav-item" data-page="logout">
      <span class="mobile-nav-indicator"></span>
      <i class="bi bi-box-arrow-right"></i>
      <span>Logout</span>
    </a>
  <?php else: ?>
    <a href="<?php echo $app['base_url']; ?>/login" class="mobile-nav-item" data-page="login">
      <span class="mobile-nav-indicator"></span>
      <i class="bi bi-person"></i>
      <span>Login</span>
    </a>
  <?php endif; ?>
</nav>

<!-- Wavy separator -->
<div class="footer-wave">
  <svg viewBox="0 0 1440 48" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" style="height:48px;width:100%;">
    <path d="M0,32 C240,50 480,14 720,32 C960,50 1200,14 1440,32 L1440,48 L0,48 Z" fill="#0f1f15"/>
  </svg>
</div>

<footer>
  <div class="container">

    <!-- Fait du jour -->
    <p class="footer-fait-du-jour">
      "Les marchés de Maurice, c'est l'histoire d'une île qui nourrit ses habitants depuis des siècles — à l'heure où les étals s'animent à l'aube."
    </p>

    <!-- Stats -->
    <div class="footer-stats">
      <div class="footer-stat-capsule">
        <i class="bi bi-check2-circle"></i>
        <strong><?php echo number_format((int)($footerStats['total_prices']??0)); ?></strong>
        prix approuvés
      </div>
      <div class="footer-stat-capsule">
        <i class="bi bi-shop"></i>
        <strong><?php echo (int)($footerStats['total_markets']??0); ?></strong>
        marchés
      </div>
      <div class="footer-stat-capsule">
        <i class="bi bi-basket2"></i>
        <strong><?php echo (int)($footerStats['total_products']??0); ?></strong>
        produits
      </div>
    </div>

    <div class="row g-5">
      <div class="col-md-5">
        <h5><?php echo htmlspecialchars($app['app_name']); ?></h5>
        <p style="color:rgba(136,160,139,0.72); line-height:1.8; max-width:340px;">
          Suivez les prix des fruits et légumes dans les marchés de l'île Maurice.
          Contribuez, comparez, anticipez.
        </p>
        <div class="social-links d-flex gap-2 mt-3">
          <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
          <a href="#" aria-label="Twitter"><i class="bi bi-twitter-x"></i></a>
          <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <h6>Navigation</h6>
        <ul class="list-unstyled mb-0">
          <li><a href="<?php echo $app['base_url']; ?>/home">Accueil</a></li>
          <li><a href="<?php echo $app['base_url']; ?>/prices">Prix du marché</a></li>
          <li><a href="<?php echo $app['base_url']; ?>/prices/submit">Contribuer</a></li>
          <li><a href="<?php echo $app['base_url']; ?>/prices/predict">Prédiction IA</a></li>
        </ul>
      </div>
      <div class="col-6 col-md-4">
        <h6>Contact</h6>
        <p class="mb-1" style="color:rgba(136,160,139,0.72);">
          <i class="bi bi-envelope me-2"></i>contact@market.mu
        </p>
        <p class="mb-0" style="color:rgba(136,160,139,0.72);">
          <i class="bi bi-telephone me-2"></i>+230 123 4567
        </p>
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
