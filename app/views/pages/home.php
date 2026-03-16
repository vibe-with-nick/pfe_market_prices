<div class="hero fade-in">
  <h1 class="display-6 fw-bold"><i class="bi bi-shop-window me-2"></i><?php echo I18n::t('home.title'); ?></h1>
  <p><?php echo I18n::t('home.subtitle'); ?></p>
  <div class="d-flex gap-2">
    <a class="btn btn-primary" href="<?php echo $app['base_url']; ?>/prices"><i class="bi bi-eye me-1"></i><?php echo I18n::t('btn.view_prices'); ?></a>
    <a class="btn btn-outline-secondary" href="<?php echo $app['base_url']; ?>/prices/submit"><i class="bi bi-plus-circle me-1"></i><?php echo I18n::t('btn.contribute'); ?></a>
  </div>
</div>

<div class="card mt-section fade-in">
  <div class="card-header fw-bold">Derniers prix</div>
  <div class="card-body" style="padding: 0;">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead><tr><th>Produit</th><th>Marché</th><th>Prix</th><th>Date</th></tr></thead>
        <tbody>
          <?php foreach ($latest as $r): ?>
            <tr>
              <td><?php echo htmlspecialchars($r['product']); ?></td>
              <td><?php echo htmlspecialchars($r['market']); ?></td>
              <td class="fw-bold">Rs&nbsp;<?php echo number_format((float)$r['price_rs'], 2); ?></td>
              <td><?php echo htmlspecialchars($r['price_date']); ?></td>
            </tr>
          <?php endforeach; ?>
          <?php if (!$latest): ?><tr><td colspan="4" class="text-muted">Aucune donnée.</td></tr><?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
