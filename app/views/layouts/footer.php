</main>
<footer class="py-4 mt-5">
  <div class="container">
    <div class="row">
      <div class="col-md-3">
        <h5 class="fw-bold"><?php echo htmlspecialchars((require __DIR__ . '/../../config/app.php')['app_name']); ?></h5>
        <p class="mb-0">Suivi des prix des fruits et légumes à Maurice. Contribuez et consultez les prix locaux.</p>
      </div>
      <div class="col-md-3">
        <h6>Liens utiles</h6>
        <ul class="list-unstyled">
          <li><a href="<?php echo (require __DIR__ . '/../../config/app.php')['base_url']; ?>/home" class="text-light text-decoration-none">Accueil</a></li>
          <li><a href="<?php echo (require __DIR__ . '/../../config/app.php')['base_url']; ?>/prices" class="text-light text-decoration-none">Prix</a></li>
          <li><a href="<?php echo (require __DIR__ . '/../../config/app.php')['base_url']; ?>/prices/submit" class="text-light text-decoration-none">Contribuer</a></li>
        </ul>
      </div>
      <div class="col-md-3">
        <h6>Contact</h6>
        <p class="mb-0"><i class="bi bi-envelope me-1"></i> contact@market.mu</p>
        <p class="mb-0"><i class="bi bi-telephone me-1"></i> +230 123 4567</p>
      </div>
      <div class="col-md-3">
        <h6>Suivez-nous</h6>
        <div>
          <a href="#" class="text-light me-3"><i class="bi bi-facebook"></i></a>
          <a href="#" class="text-light me-3"><i class="bi bi-twitter"></i></a>
          <a href="#" class="text-light me-3"><i class="bi bi-instagram"></i></a>
          <a href="#" class="text-light"><i class="bi bi-youtube"></i></a>
        </div>
      </div>
    </div>
    <hr class="my-3">
    <div class="text-center small">© <?php echo date('Y'); ?> Market Prices MU. Tous droits réservés.</div>
  </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script src="<?php echo (require __DIR__ . '/../../config/app.php')['base_url']; ?>/assets/js/app.js"></script>
</body>
</html>
