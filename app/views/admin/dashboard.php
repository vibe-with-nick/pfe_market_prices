<h1 class="h4 mb-3"><?php echo I18n::t('admin.panel'); ?></h1>
<div class="row g-3">
  <div class="col-md-3"><div class="card p-3"><div class="text-muted small">Users</div><div class="h3 mb-0"><?php echo (int)$stats['users']; ?></div></div></div>
  <div class="col-md-3"><div class="card p-3"><div class="text-muted small">Markets</div><div class="h3 mb-0"><?php echo (int)$stats['markets']; ?></div></div></div>
  <div class="col-md-3"><div class="card p-3"><div class="text-muted small">Products</div><div class="h3 mb-0"><?php echo (int)$stats['products']; ?></div></div></div>
  <div class="col-md-3"><div class="card p-3"><div class="text-muted small">Pending</div><div class="h3 mb-0"><?php echo (int)$stats['pending']; ?></div></div></div>
</div>
<div class="mt-3">
  <a class="btn btn-primary" href="<?php echo $app['base_url']; ?>/admin/pending"><?php echo I18n::t('admin.pending'); ?></a>
</div>
