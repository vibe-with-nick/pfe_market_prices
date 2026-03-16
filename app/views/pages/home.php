<div class="hero">
  <span class="section-num">01 &mdash; Marchés de l'Île Maurice</span>
  <h1 class="display-6"><?php echo I18n::t('home.title'); ?></h1>
  <span class="title-rule"></span>
  <p><?php echo I18n::t('home.subtitle'); ?></p>
  <div class="d-flex gap-3 flex-wrap">
    <a class="btn btn-primary" href="<?php echo $app['base_url']; ?>/prices">
      <?php echo I18n::t('btn.view_prices'); ?>
    </a>
    <a class="btn btn-outline-secondary" href="<?php echo $app['base_url']; ?>/prices/submit"
       style="border-color: rgba(201,168,76,0.30); color: var(--text-muted-light);">
      <?php echo I18n::t('btn.contribute'); ?>
    </a>
  </div>
</div>

<div class="d-flex justify-content-between align-items-baseline mb-3">
  <span class="section-num mb-0">02 &mdash; Derniers prix approuvés</span>
  <a href="<?php echo $app['base_url']; ?>/prices"
     style="font-size:0.75rem; letter-spacing:0.10em; text-transform:uppercase; color:var(--gold); text-decoration:none;">
    Voir tout <i class="bi bi-arrow-right ms-1"></i>
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
            <th>Prix</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($latest as $r): ?>
            <tr>
              <td><?php echo htmlspecialchars($r['product']); ?></td>
              <td><?php echo htmlspecialchars($r['market']); ?></td>
              <td class="fw-bold">Rs&nbsp;<?php echo number_format((float)$r['price_rs'], 2); ?></td>
              <td><?php echo htmlspecialchars($r['price_date']); ?></td>
            </tr>
          <?php endforeach; ?>
          <?php if (!$latest): ?>
            <tr>
              <td colspan="4" class="text-muted text-center" style="padding:3rem;">
                Aucune donnée disponible.
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
