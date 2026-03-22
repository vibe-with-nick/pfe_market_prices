<div class="page-header">
  <span class="section-num">Administration</span>
  <h1 class="page-title"><?php echo I18n::t('admin.products_title'); ?></h1>
</div>

<?php if ($error): ?>
  <div class="alert alert-danger mb-4"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<div class="card mb-5" style="border-left:none;">
  <div class="card-header"><?php echo I18n::t('admin.add_product'); ?></div>
  <div class="card-body">
    <form method="POST" action="<?php echo $app['base_url']; ?>/admin/products">
      <input type="hidden" name="csrf_token" value="<?php echo Auth::csrfToken(); ?>">
      <div class="row g-3 align-items-end">
        <div class="col-md-4">
          <label class="form-label"><?php echo I18n::t('admin.product_name'); ?></label>
          <input type="text" name="name" class="form-control" placeholder="<?php echo I18n::t('admin.product_name_ph'); ?>" required>
        </div>
        <div class="col-md-3">
          <label class="form-label"><?php echo I18n::t('admin.category'); ?></label>
          <select name="category" class="form-select" required>
            <option value=""><?php echo I18n::t('admin.choose'); ?></option>
            <option value="fruit"><?php echo I18n::t('admin.fruit_option'); ?></option>
            <option value="legume"><?php echo I18n::t('admin.vegetable_option'); ?></option>
          </select>
        </div>
        <div class="col-md-3">
          <label class="form-label"><?php echo I18n::t('admin.unit_label'); ?></label>
          <select name="unit" class="form-select">
            <option value="kg">kg</option>
            <option value="piece">pièce</option>
            <option value="botte">botte</option>
            <option value="litre">litre</option>
          </select>
        </div>
        <div class="col-md-2">
          <button type="submit" id="submitBtn" class="btn btn-primary w-100">
            <i class="bi bi-plus-lg me-1"></i><?php echo I18n::t('admin.add_btn'); ?>
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

<?php
$fruits  = array_filter($products, fn($p) => $p['category'] === 'fruit');
$legumes = array_filter($products, fn($p) => $p['category'] === 'legume');
?>

<?php foreach (['fruit' => [I18n::t('admin.fruits_label'), $fruits], 'legume' => [I18n::t('admin.vegs_label'), $legumes]] as $key => [$label, $list]): ?>
<div class="mb-5">
  <div class="section-heading mb-3">
    <span class="section-num mb-0"><?php echo $label; ?></span>
    <span class="chip chip-neutral"><?php echo count($list); ?> <?php echo I18n::t('admin.products_count_label'); ?></span>
  </div>
  <div class="card" style="border-left:none;">
    <div class="card-body" style="padding:0;">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead>
            <tr>
              <th><?php echo I18n::t('col.name'); ?></th>
              <th><?php echo I18n::t('col.unit'); ?></th>
              <th><?php echo I18n::t('col.status'); ?></th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($list)): ?>
              <tr><td colspan="4" class="text-muted text-center" style="padding:2rem;"><?php echo I18n::t('admin.no_products'); ?></td></tr>
            <?php endif; ?>
            <?php foreach ($list as $p): ?>
              <tr>
                <td><?php echo htmlspecialchars($p['name']); ?></td>
                <td><span class="chip chip-neutral"><?php echo htmlspecialchars($p['unit']); ?></span></td>
                <td>
                  <?php if ($p['is_active']): ?>
                    <span class="chip chip-green"><?php echo I18n::t('admin.active'); ?></span>
                  <?php else: ?>
                    <span class="chip chip-neutral"><?php echo I18n::t('admin.inactive'); ?></span>
                  <?php endif; ?>
                </td>
                <td class="text-end">
                  <form method="POST" action="<?php echo $app['base_url']; ?>/admin/products/toggle" style="display:inline;">
                    <input type="hidden" name="csrf_token" value="<?php echo Auth::csrfToken(); ?>">
                    <input type="hidden" name="id" value="<?php echo (int)$p['id']; ?>">
                    <button type="submit" class="btn btn-sm <?php echo $p['is_active'] ? 'btn-outline-danger' : 'btn-outline-secondary'; ?>">
                      <?php echo $p['is_active'] ? I18n::t('admin.deactivate') : I18n::t('admin.reactivate'); ?>
                    </button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php endforeach; ?>
