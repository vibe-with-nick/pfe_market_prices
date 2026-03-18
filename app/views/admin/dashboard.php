<div class="page-header">
  <span class="section-num">Administration</span>
  <h1 class="page-title"><?php echo I18n::t('admin.panel'); ?></h1>
</div>

<span class="section-num mb-3 d-block">Vue d'ensemble</span>

<div class="row g-3 mb-5" style="background: var(--bg-dark); padding: 2rem; border-radius: 4px; border: 1px solid var(--border-dark); margin-left:0; margin-right:0;">
  <div class="col-6 col-md-3">
    <div style="padding: 1.5rem 0;">
      <div style="font-family:var(--f-sans); font-size:0.65rem; font-weight:500; letter-spacing:0.14em; text-transform:uppercase; color:var(--text-muted-light); margin-bottom:0.65rem;">
        Utilisateurs
      </div>
      <div class="data-num"><?php echo (int)$stats['users']; ?></div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div style="padding: 1.5rem 0; border-left: 1px solid var(--border-dark); padding-left: 2rem;">
      <div style="font-family:var(--f-sans); font-size:0.65rem; font-weight:500; letter-spacing:0.14em; text-transform:uppercase; color:var(--text-muted-light); margin-bottom:0.65rem;">
        Marchés
      </div>
      <div class="data-num"><?php echo (int)$stats['markets']; ?></div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div style="padding: 1.5rem 0; border-left: 1px solid var(--border-dark); padding-left: 2rem;">
      <div style="font-family:var(--f-sans); font-size:0.65rem; font-weight:500; letter-spacing:0.14em; text-transform:uppercase; color:var(--text-muted-light); margin-bottom:0.65rem;">
        Produits
      </div>
      <div class="data-num"><?php echo (int)$stats['products']; ?></div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div style="padding: 1.5rem 0; border-left: 1px solid var(--border-dark); padding-left: 2rem;">
      <div style="font-family:var(--f-sans); font-size:0.65rem; font-weight:500; letter-spacing:0.14em; text-transform:uppercase; color:var(--text-muted-light); margin-bottom:0.65rem;">
        En attente
      </div>
      <div style="font-family:var(--f-serif); font-size:3rem; font-weight:300; color:<?php echo ($stats['pending']>0) ? 'var(--gold)' : 'var(--text-muted-light)'; ?>; line-height:1;">
        <?php echo (int)$stats['pending']; ?>
      </div>
    </div>
  </div>
</div>

<div class="d-flex gap-3 flex-wrap">
  <a class="btn btn-primary" href="<?php echo $app['base_url']; ?>/admin/pending">
    <?php echo I18n::t('admin.pending'); ?>
    <?php if ($stats['pending'] > 0): ?>
      <span class="badge badge-gold ms-2"><?php echo (int)$stats['pending']; ?></span>
    <?php endif; ?>
  </a>
  <a class="btn btn-outline-secondary" href="<?php echo $app['base_url']; ?>/admin/products">
    Gérer les produits
  </a>
</div>
