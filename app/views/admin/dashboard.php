<div class="page-header">
  <span class="section-num">Administration</span>
  <h1 class="page-title"><?php echo I18n::t('admin.panel'); ?></h1>
</div>

<span class="section-num mb-3 d-block" style="font-size:1.1rem;"><?php echo I18n::t('admin.overview'); ?></span>

<div class="stat-row">
  <div class="stat-card card-postit">
    <div class="stat-card__label"><?php echo I18n::t('admin.users_label'); ?></div>
    <div class="stat-card__value" data-count-up data-value="<?php echo (int)$stats['users']; ?>"><?php echo (int)$stats['users']; ?></div>
    <div class="stat-card__sub"><?php echo I18n::t('admin.accounts_sub'); ?></div>
  </div>
  <div class="stat-card card-postit">
    <div class="stat-card__label"><?php echo I18n::t('admin.markets_label'); ?></div>
    <div class="stat-card__value" data-count-up data-value="<?php echo (int)$stats['markets']; ?>"><?php echo (int)$stats['markets']; ?></div>
    <div class="stat-card__sub"><?php echo I18n::t('admin.markets_sub'); ?></div>
  </div>
  <div class="stat-card card-postit">
    <div class="stat-card__label"><?php echo I18n::t('admin.products_label'); ?></div>
    <div class="stat-card__value" data-count-up data-value="<?php echo (int)$stats['products']; ?>"><?php echo (int)$stats['products']; ?></div>
    <div class="stat-card__sub"><?php echo I18n::t('admin.products_sub'); ?></div>
  </div>
  <div class="stat-card card-postit">
    <div class="stat-card__label"><?php echo I18n::t('admin.pending_label'); ?></div>
    <div class="stat-card__value" data-count-up data-value="<?php echo (int)$stats['pending']; ?>"
         style="color:<?php echo $stats['pending']>0 ? 'var(--accent-warm)' : 'var(--text-muted)'; ?>;">
      <?php echo (int)$stats['pending']; ?>
    </div>
    <div class="stat-card__sub"><?php echo I18n::t('admin.pending_sub'); ?></div>
  </div>
</div>

<div class="d-flex gap-3 flex-wrap">
  <a class="btn btn-primary" href="<?php echo $app['base_url']; ?>/admin/pending">
    <i class="bi bi-clock-history me-1"></i><?php echo I18n::t('admin.pending'); ?>
    <?php if ($stats['pending'] > 0): ?>
      <span class="badge badge-gold ms-2"><?php echo (int)$stats['pending']; ?></span>
    <?php endif; ?>
  </a>
  <a class="btn btn-outline-secondary" href="<?php echo $app['base_url']; ?>/admin/products">
    <i class="bi bi-basket2 me-1"></i><?php echo I18n::t('admin.manage_products'); ?>
  </a>
</div>
