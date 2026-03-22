<div class="page-header">
  <span class="section-num">Administration</span>
  <h1 class="page-title"><?php echo I18n::t('admin.pending'); ?></h1>
  <p class="page-subtitle"><?php echo I18n::t('admin.pending_subtitle'); ?></p>
</div>

<div class="d-flex justify-content-between align-items-center mb-4">
  <span class="section-num mb-0" style="font-size:1rem;">
    <?php echo count($rows); ?> <?php echo I18n::t('admin.submissions_label'); ?>
  </span>
  <a class="btn btn-ghost btn-sm" href="<?php echo $app['base_url']; ?>/admin">
    <i class="bi bi-arrow-left me-1"></i><?php echo I18n::t('admin.back_dashboard'); ?>
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
            <th><?php echo I18n::t('col.actions'); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $i => $r): ?>
            <tr class="animate-on-scroll" style="transition-delay:<?php echo $i*0.05; ?>s;">
              <td><?php echo htmlspecialchars($r['product']); ?></td>
              <td style="color:var(--text-muted);font-size:0.85rem;"><?php echo htmlspecialchars($r['market']); ?></td>
              <td>
                <span class="price-pill">Rs&nbsp;<?php echo number_format((float)$r['price_rs'],2); ?></span>
              </td>
              <td style="color:var(--text-muted);font-size:0.82rem;"><?php echo htmlspecialchars($r['price_date']); ?></td>
              <td style="color:var(--text-muted);font-size:0.82rem;"><?php echo htmlspecialchars($r['contributor']); ?></td>
              <td>
                <div class="d-flex gap-2">
                  <form method="post" action="<?php echo $app['base_url']; ?>/admin/approve">
                    <input type="hidden" name="csrf" value="<?php echo htmlspecialchars(Auth::csrfToken()); ?>">
                    <input type="hidden" name="id"   value="<?php echo (int)$r['id']; ?>">
                    <button class="btn btn-success btn-sm" style="font-size:0.72rem;padding:0.38rem 0.85rem;">
                      <i class="bi bi-check-lg me-1"></i><?php echo I18n::t('admin.approve'); ?>
                    </button>
                  </form>
                  <form method="post" action="<?php echo $app['base_url']; ?>/admin/reject">
                    <input type="hidden" name="csrf" value="<?php echo htmlspecialchars(Auth::csrfToken()); ?>">
                    <input type="hidden" name="id"   value="<?php echo (int)$r['id']; ?>">
                    <button class="btn btn-outline-danger btn-sm" style="font-size:0.72rem;padding:0.38rem 0.85rem;">
                      <i class="bi bi-x-lg me-1"></i><?php echo I18n::t('admin.reject'); ?>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
          <?php if (!$rows): ?>
            <tr>
              <td colspan="6" class="text-center" style="padding:3.5rem; color:var(--text-muted);">
                <i class="bi bi-check-circle" style="font-size:2rem; display:block; margin-bottom:0.75rem; opacity:0.4;"></i>
                <?php echo I18n::t('admin.no_pending'); ?>
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
