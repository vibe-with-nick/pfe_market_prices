<?php
/* Dernier prix approuvé pour le widget hero */
$latestForWidget = $latest[0] ?? null;

/* Items ticker — on duplique pour boucle seamless */
$tickerItems = [];
foreach ($latest as $r) {
  $tickerItems[] = htmlspecialchars($r['product']) . ' <span class="ticker-price">Rs ' . number_format((float)$r['price_rs'],2) . '</span>';
}
/* Fallback si vide */
if (empty($tickerItems)) {
  $tickerItems = ['Tomate <span class="ticker-price">Rs 45</span>','Carotte <span class="ticker-price">Rs 38</span>','Pomme de terre <span class="ticker-price">Rs 32</span>','Oignon <span class="ticker-price">Rs 55</span>','Mangue <span class="ticker-price">Rs 28</span>'];
}
$tickerHtml = '';
foreach ($tickerItems as $item) {
  $tickerHtml .= '<span class="ticker-item">' . $item . '<span class="ticker-sep">·</span></span>';
}
$tickerDouble = $tickerHtml . $tickerHtml; /* double pour boucle infinie */
?>

<div class="hero">
  <div class="hero-inner">
    <!-- Content left -->
    <div class="hero-content">
      <span class="section-num fade-up"><?php echo I18n::t('home.section1'); ?></span>
      <h1 class="display-6 fade-up fade-up-1" style="color:var(--text-light); text-shadow:0 2px 30px rgba(0,0,0,0.18);">
        <?php echo I18n::t('home.title'); ?>
      </h1>
      <span class="title-rule fade-up fade-up-1"></span>
      <p class="fade-up fade-up-2"><?php echo I18n::t('home.subtitle'); ?></p>
      <div class="d-flex gap-3 flex-wrap fade-up fade-up-3">
        <a class="btn btn-primary" href="<?php echo $app['base_url']; ?>/prices">
          <i class="bi bi-bar-chart-line me-1"></i><?php echo I18n::t('btn.view_prices'); ?>
        </a>
        <a class="btn btn-outline-secondary" href="<?php echo $app['base_url']; ?>/prices/submit"
           style="border-color:rgba(255,255,255,0.25); color:#fff;">
          <i class="bi bi-plus-circle me-1"></i><?php echo I18n::t('btn.contribute'); ?>
        </a>
      </div>
    </div>

    <!-- Widget prix en direct -->
    <?php if ($latestForWidget): ?>
    <div class="hero-widget fade-up fade-up-2">
      <div class="hero-price-widget">
        <div class="widget-label">
          <?php echo I18n::t('home.latest_price'); ?>
        </div>
        <div class="widget-price" data-count-up data-value="<?php echo number_format((float)$latestForWidget['price_rs'],2,'.',''); ?>">
          Rs <?php echo number_format((float)$latestForWidget['price_rs'],2); ?>
        </div>
        <div class="widget-product"><?php echo htmlspecialchars($latestForWidget['product']); ?></div>
        <div class="widget-market"><i class="bi bi-shop me-1"></i><?php echo htmlspecialchars($latestForWidget['market']); ?></div>
        <div style="margin-top:1rem; padding-top:1rem; border-top:1px solid rgba(255,255,255,0.08); font-size:0.75rem; color:rgba(136,160,139,0.65);">
          <?php echo htmlspecialchars($latestForWidget['price_date']); ?>
        </div>
      </div>
    </div>
    <?php endif; ?>
  </div>

  <!-- Ticker bande défilante -->
  <div class="hero-ticker">
    <div class="ticker-track"><?php echo $tickerDouble; ?></div>
  </div>
</div>

<?php if (!empty($stats)): ?>
<div class="stats-strip animate-on-scroll" style="margin-top:2.5rem;">
  <div class="stat-item">
    <span class="stat-value" data-count-up data-value="<?php echo (int)($stats['total_prices']??0); ?>"><?php echo number_format((int)($stats['total_prices']??0)); ?></span>
    <span class="stat-label"><?php echo I18n::t('home.stat_prices'); ?></span>
  </div>
  <div class="stat-item">
    <span class="stat-value" data-count-up data-value="<?php echo (int)($stats['total_markets']??0); ?>"><?php echo (int)($stats['total_markets']??0); ?></span>
    <span class="stat-label"><?php echo I18n::t('home.stat_markets'); ?></span>
  </div>
  <div class="stat-item">
    <span class="stat-value" data-count-up data-value="<?php echo (int)($stats['total_products']??0); ?>"><?php echo (int)($stats['total_products']??0); ?></span>
    <span class="stat-label"><?php echo I18n::t('home.stat_products'); ?></span>
  </div>
</div>
<?php endif; ?>

<div class="section-heading" style="margin-top:2rem;">
  <span class="section-num mb-0"><?php echo I18n::t('home.section2'); ?></span>
  <a href="<?php echo $app['base_url']; ?>/prices" class="link-gold"><?php echo I18n::t('home.see_all'); ?></a>
</div>

<div class="card card-price" style="border-left:none;">
  <div class="card-body" style="padding:0;">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead>
          <tr>
            <th><?php echo I18n::t('col.product'); ?></th>
            <th><?php echo I18n::t('col.market'); ?></th>
            <th><?php echo I18n::t('col.price'); ?></th>
            <th><?php echo I18n::t('col.date'); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($latest as $i => $r): ?>
            <tr class="animate-on-scroll" style="transition-delay:<?php echo $i*0.05; ?>s;">
              <td><?php echo htmlspecialchars($r['product']); ?></td>
              <td style="color:var(--text-muted); font-size:0.85rem;"><?php echo htmlspecialchars($r['market']); ?></td>
              <td>
                <span class="price-pill">Rs&nbsp;<?php echo number_format((float)$r['price_rs'],2); ?></span>
              </td>
              <td style="color:var(--text-muted); font-size:0.8rem;"><?php echo htmlspecialchars($r['price_date']); ?></td>
            </tr>
          <?php endforeach; ?>
          <?php if (!$latest): ?>
            <tr>
              <td colspan="4" class="text-muted text-center" style="padding:3rem;"><?php echo I18n::t('home.no_data'); ?></td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
