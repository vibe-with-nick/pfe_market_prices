<div class="page-header">
  <span class="section-num">02 &mdash; Données du marché</span>
  <h1 class="page-title"><?php echo I18n::t('nav.prices'); ?></h1>
  <p class="page-subtitle">Prix approuvés en temps réel — Île Maurice</p>
</div>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
  <form class="d-flex gap-2 align-items-end flex-wrap" method="get" style="flex:1;">
    <div style="min-width:220px; flex:1;">
      <label class="form-label"><?php echo I18n::t('price.market'); ?></label>
      <select name="market_id" class="form-select">
        <option value="">Tous les marchés</option>
        <?php foreach ($markets as $m): ?>
          <option value="<?php echo (int)$m['id']; ?>" <?php echo ($marketId==$m['id'])?'selected':''; ?>>
            <?php echo htmlspecialchars($m['name']); ?> &mdash; <?php echo htmlspecialchars($m['region']); ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
    <div style="min-width:220px; flex:1;">
      <label class="form-label"><?php echo I18n::t('price.product'); ?></label>
      <select name="product_id" class="form-select">
        <option value="">Tous les produits</option>
        <?php foreach ($products as $p): ?>
          <option value="<?php echo (int)$p['id']; ?>" <?php echo ($productId==$p['id'])?'selected':''; ?>>
            <?php echo htmlspecialchars($p['name']); ?> (<?php echo htmlspecialchars($p['unit']); ?>)
          </option>
        <?php endforeach; ?>
      </select>
    </div>
    <div>
      <label class="form-label" style="visibility:hidden; display:block;">Filtrer</label>
      <button class="btn btn-primary">Filtrer</button>
    </div>
  </form>
  <a class="btn btn-outline-secondary" href="<?php echo $app['base_url']; ?>/prices/submit"
     style="align-self:flex-end;">
    <?php echo I18n::t('btn.contribute'); ?>
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
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $r): ?>
            <tr>
              <td>
                <?php echo htmlspecialchars($r['product']); ?>
                <span class="badge text-bg-light ms-1"><?php echo htmlspecialchars($r['unit']); ?></span>
              </td>
              <td>
                <?php echo htmlspecialchars($r['market']); ?>
                <span class="badge text-bg-secondary ms-1"><?php echo htmlspecialchars($r['region']); ?></span>
              </td>
              <td class="fw-bold">Rs <?php echo number_format((float)$r['price_rs'],2); ?></td>
              <td><?php echo htmlspecialchars($r['price_date']); ?></td>
              <td class="text-muted"><?php echo htmlspecialchars($r['contributor']); ?></td>
            </tr>
          <?php endforeach; ?>
          <?php if (!$rows): ?>
            <tr>
              <td colspan="5" class="text-muted text-center" style="padding:3rem;">
                Aucun résultat pour ces critères.
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
