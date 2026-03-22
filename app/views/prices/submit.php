<div class="page-header">
  <span class="section-num">02 — Contribution</span>
  <h1 class="page-title"><?php echo I18n::t('price.submit'); ?></h1>
  <p class="page-subtitle">Votre contribution alimente les données du marché</p>
</div>

<?php if (!empty($errors)): ?>
  <div class="alert alert-danger mb-4">
    <ul class="mb-0 ps-3">
      <?php foreach ($errors as $e): ?>
        <li><?php echo htmlspecialchars($e); ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<div style="max-width:680px;">
  <form method="post" class="card" style="border-left:none; padding:2.5rem;">
    <input type="hidden" name="csrf" value="<?php echo htmlspecialchars(Auth::csrfToken()); ?>">

    <div class="row g-3 mb-3">
      <div class="col-md-6">
        <label class="form-label"><?php echo I18n::t('price.market'); ?></label>
        <select name="market_id" class="form-select" required>
          <option value="">🏪 Choisir un marché</option>
          <?php foreach ($markets as $m): ?>
            <option value="<?php echo (int)$m['id']; ?>">
              <?php echo htmlspecialchars($m['name']); ?> (<?php echo htmlspecialchars($m['region']); ?>)
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-6">
        <label class="form-label"><?php echo I18n::t('price.product'); ?></label>
        <select name="product_id" class="form-select" required>
          <option value="">🥦 Choisir un produit</option>
          <?php foreach ($products as $p): ?>
            <option value="<?php echo (int)$p['id']; ?>">
              <?php echo htmlspecialchars($p['name']); ?> (<?php echo htmlspecialchars($p['unit']); ?>)
            </option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div class="row g-3 mb-3">
      <div class="col-md-4">
        <label class="form-label"><?php echo I18n::t('price.price_rs'); ?></label>
        <div class="input-group">
          <span class="input-group-text">Rs</span>
          <input type="number" name="price_rs" class="form-control" required min="0.01" step="0.01" placeholder="0.00">
        </div>
      </div>
      <div class="col-md-4">
        <label class="form-label"><?php echo I18n::t('price.date'); ?></label>
        <input type="date" name="price_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
      </div>
      <div class="col-md-4">
        <label class="form-label"><?php echo I18n::t('price.source'); ?></label>
        <input type="text" name="source" class="form-control" placeholder="Ex : visite marché">
      </div>
    </div>

    <div class="mb-4">
      <label class="form-label"><?php echo I18n::t('price.note'); ?></label>
      <textarea name="note" class="form-control" rows="3" placeholder="Remarques supplémentaires…"></textarea>
    </div>

    <button class="btn btn-primary" type="submit" id="submitBtn">
      <i class="bi bi-send me-1"></i><?php echo I18n::t('price.submit'); ?>
    </button>
  </form>
</div>

<?php if (!empty($success)): ?>
<div class="modal fade" id="successModal" tabindex="-1" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius:20px; border:none; background:var(--bg-card); box-shadow:0 24px 80px rgba(28,34,24,0.18);">
      <div class="modal-body text-center py-5 px-4">
        <div class="mb-3">
          <i class="bi bi-check-circle-fill" style="font-size:3.5rem;color:var(--accent-up);"></i>
        </div>
        <h5 style="font-family:var(--f-serif);font-size:1.6rem;font-weight:700;margin-bottom:0.5rem;">Contribution soumise !</h5>
        <p class="text-muted mb-4">Merci pour votre contribution. Le prix sera visible après validation par notre équipe.</p>
        <div class="d-flex gap-2 justify-content-center">
          <a href="<?php echo $app['base_url']; ?>/prices" class="btn btn-primary">
            <i class="bi bi-bar-chart-line me-1"></i>Voir les prix
          </a>
          <button type="button" class="btn btn-ghost" data-bs-dismiss="modal">Soumettre un autre</button>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    new bootstrap.Modal(document.getElementById('successModal')).show();
  });
</script>
<?php endif; ?>
