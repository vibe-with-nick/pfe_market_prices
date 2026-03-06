<h1 class="h4 mb-3"><?php echo I18n::t('admin.pending'); ?></h1>

<div class="card">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover align-middle">
        <thead><tr><th>Produit</th><th>Marché</th><th>Prix</th><th>Date</th><th>Contributeur</th><th>Action</th></tr></thead>
        <tbody>
          <?php foreach ($rows as $r): ?>
            <tr>
              <td><?php echo htmlspecialchars($r['product']); ?></td>
              <td><?php echo htmlspecialchars($r['market']); ?></td>
              <td class="fw-bold">Rs <?php echo number_format((float)$r['price_rs'],2); ?></td>
              <td><?php echo htmlspecialchars($r['price_date']); ?></td>
              <td><?php echo htmlspecialchars($r['contributor']); ?></td>
              <td>
                <form method="post" action="<?php echo $app['base_url']; ?>/admin/approve" class="d-inline">
                  <input type="hidden" name="csrf" value="<?php echo htmlspecialchars(Auth::csrfToken()); ?>">
                  <input type="hidden" name="id" value="<?php echo (int)$r['id']; ?>">
                  <button class="btn btn-success btn-sm">Approuver</button>
                </form>
                <form method="post" action="<?php echo $app['base_url']; ?>/admin/reject" class="d-inline">
                  <input type="hidden" name="csrf" value="<?php echo htmlspecialchars(Auth::csrfToken()); ?>">
                  <input type="hidden" name="id" value="<?php echo (int)$r['id']; ?>">
                  <button class="btn btn-outline-danger btn-sm">Rejeter</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
          <?php if (!$rows): ?><tr><td colspan="6" class="text-muted">Aucune soumission en attente.</td></tr><?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
