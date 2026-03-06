<h1 class="h4 mb-3"><?php echo I18n::t('price.submit'); ?></h1>

<?php if (!empty($errors)): ?>
  <div class="alert alert-danger"><ul class="mb-0"><?php foreach ($errors as $e): ?><li><?php echo htmlspecialchars($e); ?></li><?php endforeach; ?></ul></div>
<?php endif; ?>

<form method="post" class="card p-3" style="max-width:720px">
  <input type="hidden" name="csrf" value="<?php echo htmlspecialchars(Auth::csrfToken()); ?>">
  <div class="row g-2">
    <div class="col-md-6">
      <label class="form-label"><?php echo I18n::t('price.market'); ?></label>
      <select name="market_id" class="form-select" required>
        <option value="">--</option>
        <?php foreach ($markets as $m): ?><option value="<?php echo (int)$m['id']; ?>"><?php echo htmlspecialchars($m['name']); ?> (<?php echo htmlspecialchars($m['region']); ?>)</option><?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-6">
      <label class="form-label"><?php echo I18n::t('price.product'); ?></label>
      <select name="product_id" class="form-select" required>
        <option value="">--</option>
        <?php foreach ($products as $p): ?><option value="<?php echo (int)$p['id']; ?>"><?php echo htmlspecialchars($p['name']); ?> (<?php echo htmlspecialchars($p['unit']); ?>)</option><?php endforeach; ?>
      </select>
    </div>
  </div>

  <div class="row g-2 mt-1">
    <div class="col-md-4">
      <label class="form-label"><?php echo I18n::t('price.price_rs'); ?></label>
      <input type="number" name="price_rs" class="form-control" required min="0.01" step="0.01">
    </div>
    <div class="col-md-4">
      <label class="form-label"><?php echo I18n::t('price.date'); ?></label>
      <input type="date" name="price_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
    </div>
    <div class="col-md-4">
      <label class="form-label"><?php echo I18n::t('price.source'); ?></label>
      <input type="text" name="source" class="form-control">
    </div>
  </div>

  <div class="mt-2">
    <label class="form-label"><?php echo I18n::t('price.note'); ?></label>
    <textarea name="note" class="form-control" rows="3"></textarea>
  </div>

  <button class="btn btn-primary mt-3">Envoyer</button>
</form>
