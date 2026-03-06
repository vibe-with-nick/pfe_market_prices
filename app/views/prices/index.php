<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="h4 mb-0"><?php echo I18n::t('nav.prices'); ?></h1>
  <a class="btn btn-primary" href="<?php echo $app['base_url']; ?>/prices/submit"><?php echo I18n::t('btn.contribute'); ?></a>
</div>

<form class="card p-3 mb-3" method="get">
  <div class="row g-2">
    <div class="col-md-5">
      <label class="form-label"><?php echo I18n::t('price.market'); ?></label>
      <select name="market_id" class="form-select">
        <option value="">Tous</option>
        <?php foreach ($markets as $m): ?>
          <option value="<?php echo (int)$m['id']; ?>" <?php echo ($marketId==$m['id'])?'selected':''; ?>>
            <?php echo htmlspecialchars($m['name']); ?> (<?php echo htmlspecialchars($m['region']); ?>)
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-5">
      <label class="form-label"><?php echo I18n::t('price.product'); ?></label>
      <select name="product_id" class="form-select">
        <option value="">Tous</option>
        <?php foreach ($products as $p): ?>
          <option value="<?php echo (int)$p['id']; ?>" <?php echo ($productId==$p['id'])?'selected':''; ?>>
            <?php echo htmlspecialchars($p['name']); ?> (<?php echo htmlspecialchars($p['unit']); ?>)
          </option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-2 d-flex align-items-end">
      <button class="btn btn-dark w-100">Filtrer</button>
    </div>
  </div>
</form>

<div class="card">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped table-hover align-middle">
        <thead><tr><th>Produit</th><th>Marché</th><th>Prix</th><th>Date</th><th>Contributeur</th></tr></thead>
        <tbody>
          <?php foreach ($rows as $r): ?>
            <tr>
              <td><?php echo htmlspecialchars($r['product']); ?> <span class="badge text-bg-light"><?php echo htmlspecialchars($r['unit']); ?></span></td>
              <td><?php echo htmlspecialchars($r['market']); ?> <span class="badge text-bg-secondary"><?php echo htmlspecialchars($r['region']); ?></span></td>
              <td class="fw-bold">Rs <?php echo number_format((float)$r['price_rs'],2); ?></td>
              <td><?php echo htmlspecialchars($r['price_date']); ?></td>
              <td><?php echo htmlspecialchars($r['contributor']); ?></td>
            </tr>
          <?php endforeach; ?>
          <?php if (!$rows): ?><tr><td colspan="5" class="text-muted">Aucune donnée.</td></tr><?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
