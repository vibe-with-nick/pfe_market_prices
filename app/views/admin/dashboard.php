<div class="page-header">
  <span class="section-num">Administration</span>
  <h1 class="page-title"><?php echo I18n::t('admin.panel'); ?></h1>
</div>

<span class="section-num mb-3 d-block" style="font-size:1.1rem;">Vue d'ensemble</span>

<div class="stat-row">
  <div class="stat-card card-postit">
    <div class="stat-card__label">Utilisateurs</div>
    <div class="stat-card__value" data-count-up data-value="<?php echo (int)$stats['users']; ?>"><?php echo (int)$stats['users']; ?></div>
    <div class="stat-card__sub">comptes enregistrés</div>
  </div>
  <div class="stat-card card-postit">
    <div class="stat-card__label">Marchés</div>
    <div class="stat-card__value" data-count-up data-value="<?php echo (int)$stats['markets']; ?>"><?php echo (int)$stats['markets']; ?></div>
    <div class="stat-card__sub">sur l'île Maurice</div>
  </div>
  <div class="stat-card card-postit">
    <div class="stat-card__label">Produits</div>
    <div class="stat-card__value" data-count-up data-value="<?php echo (int)$stats['products']; ?>"><?php echo (int)$stats['products']; ?></div>
    <div class="stat-card__sub">fruits et légumes</div>
  </div>
  <div class="stat-card card-postit">
    <div class="stat-card__label">En attente</div>
    <div class="stat-card__value" data-count-up data-value="<?php echo (int)$stats['pending']; ?>"
         style="color:<?php echo $stats['pending']>0 ? 'var(--accent-warm)' : 'var(--text-muted)'; ?>;">
      <?php echo (int)$stats['pending']; ?>
    </div>
    <div class="stat-card__sub">soumissions à valider</div>
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
    <i class="bi bi-basket2 me-1"></i>Gérer les produits
  </a>
</div>
