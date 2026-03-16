<div class="page-header">
  <span class="section-num">Administration</span>
  <h1 class="page-title"><?php echo I18n::t('admin.pending'); ?></h1>
  <p class="page-subtitle">Soumissions en attente de validation</p>
</div>

<div class="d-flex justify-content-between align-items-center mb-4">
  <span class="section-num mb-0">
    <?php echo count($rows); ?> soumission<?php echo count($rows) !== 1 ? 's' : ''; ?>
  </span>
  <a class="btn btn-outline-secondary btn-sm" href="<?php echo $app['base_url']; ?>/admin">
    <i class="bi bi-arrow-left me-1"></i> Tableau de bord
  </a>
</div>

<div class="card">
  <div class="card-body" style="padding:0;">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead>
          <tr>
            <th>Produit</th>
            <th>Marché</th>
            <th>Prix (Rs)</th>
            <th>Date</th>
            <th>Contributeur</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $r): ?>
            <tr>
              <td><?php echo htmlspecialchars($r['product']); ?></td>
              <td><?php echo htmlspecialchars($r['market']); ?></td>
              <td class="fw-bold">Rs <?php echo number_format((float)$r['price_rs'],2); ?></td>
              <td><?php echo htmlspecialchars($r['price_date']); ?></td>
              <td class="text-muted"><?php echo htmlspecialchars($r['contributor']); ?></td>
              <td>
                <div class="d-flex gap-2">
                  <form method="post" action="<?php echo $app['base_url']; ?>/admin/approve">
                    <input type="hidden" name="csrf" value="<?php echo htmlspecialchars(Auth::csrfToken()); ?>">
                    <input type="hidden" name="id"   value="<?php echo (int)$r['id']; ?>">
                    <button class="btn btn-success btn-sm" style="font-size:0.7rem; padding:0.4rem 0.9rem;">
                      Approuver
                    </button>
                  </form>
                  <form method="post" action="<?php echo $app['base_url']; ?>/admin/reject">
                    <input type="hidden" name="csrf" value="<?php echo htmlspecialchars(Auth::csrfToken()); ?>">
                    <input type="hidden" name="id"   value="<?php echo (int)$r['id']; ?>">
                    <button class="btn btn-outline-danger btn-sm" style="font-size:0.7rem; padding:0.4rem 0.9rem;">
                      Rejeter
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
          <?php if (!$rows): ?>
            <tr>
              <td colspan="6" class="text-muted text-center" style="padding:3.5rem;">
                Aucune soumission en attente.
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
