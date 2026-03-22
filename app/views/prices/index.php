<div class="page-header">
  <span class="section-num"><?php echo I18n::t('prices.section'); ?></span>
  <h1 class="page-title"><?php echo I18n::t('nav.prices'); ?></h1>
  <p class="page-subtitle"><?php echo I18n::t('prices.subtitle'); ?></p>
</div>

<div class="d-flex justify-content-between align-items-end mb-4 flex-wrap gap-3">
  <div class="predict-form-card" style="flex:1; margin-bottom:0; padding:1.25rem 1.5rem;">
    <form class="d-flex gap-2 align-items-end flex-wrap" method="get">
      <div style="min-width:200px; flex:1;">
        <label class="form-label"><?php echo I18n::t('price.market'); ?></label>
        <select name="market_id" class="form-select">
          <option value=""><?php echo I18n::t('prices.all_markets'); ?></option>
          <?php foreach ($markets as $m): ?>
            <option value="<?php echo (int)$m['id']; ?>" <?php echo ($marketId==$m['id'])?'selected':''; ?>>
              <?php echo htmlspecialchars($m['name']); ?> — <?php echo htmlspecialchars($m['region']); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div style="min-width:200px; flex:1;">
        <label class="form-label"><?php echo I18n::t('price.product'); ?></label>
        <select name="product_id" class="form-select">
          <option value=""><?php echo I18n::t('prices.all_products'); ?></option>
          <?php foreach ($products as $p): ?>
            <option value="<?php echo (int)$p['id']; ?>" <?php echo ($productId==$p['id'])?'selected':''; ?>>
              <?php echo htmlspecialchars($p['name']); ?> (<?php echo htmlspecialchars($p['unit']); ?>)
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div>
        <label class="form-label" style="visibility:hidden; display:block;"><?php echo I18n::t('prices.filter'); ?></label>
        <button class="btn btn-primary"><?php echo I18n::t('prices.filter'); ?></button>
      </div>
    </form>
  </div>
  <a class="btn btn-outline-secondary" href="<?php echo $app['base_url']; ?>/prices/submit">
    <i class="bi bi-plus-circle me-1"></i><?php echo I18n::t('btn.contribute'); ?>
  </a>
</div>

<div class="card" style="border-left:none;">
  <div class="card-body" style="padding:0;">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead>
          <tr>
            <th><?php echo I18n::t('col.product'); ?></th>
            <th><?php echo I18n::t('col.market'); ?></th>
            <th><?php echo I18n::t('col.price'); ?></th>
            <th><?php echo I18n::t('col.date'); ?></th>
            <th><?php echo I18n::t('col.contributor'); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $i => $r): ?>
            <tr class="animate-on-scroll" style="transition-delay:<?php echo $i*0.04; ?>s;">
              <td>
                <?php echo htmlspecialchars($r['product']); ?>
                <span class="chip chip-neutral ms-1"><?php echo htmlspecialchars($r['unit']); ?></span>
              </td>
              <td>
                <span style="color:var(--text-dark);"><?php echo htmlspecialchars($r['market']); ?></span>
                <br><span style="font-size:0.75rem;color:var(--text-muted);"><?php echo htmlspecialchars($r['region']); ?></span>
              </td>
              <td>
                <span class="price-pill">Rs&nbsp;<?php echo number_format((float)$r['price_rs'],2); ?></span>
              </td>
              <td style="color:var(--text-muted);font-size:0.82rem;"><?php echo htmlspecialchars($r['price_date']); ?></td>
              <td style="color:var(--text-muted);font-size:0.82rem;"><?php echo htmlspecialchars($r['contributor']); ?></td>
            </tr>
          <?php endforeach; ?>
          <?php if (!$rows): ?>
            <tr>
              <td colspan="5" class="text-muted text-center" style="padding:3rem;"><?php echo I18n::t('prices.no_results'); ?></td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
