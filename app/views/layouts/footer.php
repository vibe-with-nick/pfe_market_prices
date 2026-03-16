</main>
<footer class="py-5 mt-5">
  <div class="container">
    <div class="row g-4">
      <div class="col-md-4">
        <h5><?php echo htmlspecialchars($app['app_name']); ?></h5>
        <p class="mb-0">Suivi des prix des fruits et légumes à Maurice. Contribuez et consultez les prix locaux.</p>
      </div>
      <div class="col-md-2">
        <h6>Navigation</h6>
        <ul class="list-unstyled mb-0">
          <li class="mb-1"><a href="<?php echo $app['base_url']; ?>/home">Accueil</a></li>
          <li class="mb-1"><a href="<?php echo $app['base_url']; ?>/prices">Prix</a></li>
          <li class="mb-1"><a href="<?php echo $app['base_url']; ?>/prices/submit">Contribuer</a></li>
        </ul>
      </div>
      <div class="col-md-3">
        <h6>Contact</h6>
        <p class="mb-1"><i class="bi bi-envelope me-2"></i>contact@market.mu</p>
        <p class="mb-0"><i class="bi bi-telephone me-2"></i>+230 123 4567</p>
      </div>
      <div class="col-md-3">
        <h6>Suivez-nous</h6>
        <div class="d-flex gap-3">
          <a href="#"><i class="bi bi-facebook"></i></a>
          <a href="#"><i class="bi bi-twitter-x"></i></a>
          <a href="#"><i class="bi bi-instagram"></i></a>
          <a href="#"><i class="bi bi-youtube"></i></a>
        </div>
      </div>
    </div>
    <hr class="my-4">
    <div class="text-center small">© <?php echo date('Y'); ?> <?php echo htmlspecialchars($app['app_name']); ?> — Tous droits réservés.</div>
  </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script src="<?php echo $app['base_url']; ?>/assets/js/app.js"></script>
</body>
</html>
