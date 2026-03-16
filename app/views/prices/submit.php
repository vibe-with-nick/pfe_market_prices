<div class="page-header">
  <span class="section-num">02 &mdash; Contribution</span>
  <h1 class="page-title"><?php echo I18n::t('price.submit'); ?></h1>
  <p class="page-subtitle">Votre contribution alimente les données du marché</p>
</div>

<?php if (!empty($errors)): ?>
  <div class="alert alert-danger mb-4">
    <ul class="mb-0 ps-3">
      <?php foreach ($errors as $e): ?>
        <li><?php echo htmlspecialchars($e); ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<div style="max-width: 680px;">
  <form method="post" class="card" style="padding: 2.5rem;">
    <input type="hidden" name="csrf" value="<?php echo htmlspecialchars(Auth::csrfToken()); ?>">

    <div class="row g-3 mb-3">
      <div class="col-md-6">
        <label class="form-label"><?php echo I18n::t('price.market'); ?></label>
        <select name="market_id" class="form-select" required>
          <option value="">Choisir un marché</option>
          <?php foreach ($markets as $m): ?>
            <option value="<?php echo (int)$m['id']; ?>">
              <?php echo htmlspecialchars($m['name']); ?> (<?php echo htmlspecialchars($m['region']); ?>)
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-6">
        <label class="form-label"><?php echo I18n::t('price.product'); ?></label>
        <select name="product_id" class="form-select" required>
          <option value="">Choisir un produit</option>
          <?php foreach ($products as $p): ?>
            <option value="<?php echo (int)$p['id']; ?>">
              <?php echo htmlspecialchars($p['name']); ?> (<?php echo htmlspecialchars($p['unit']); ?>)
            </option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div class="row g-3 mb-3">
      <div class="col-md-4">
        <label class="form-label"><?php echo I18n::t('price.price_rs'); ?></label>
        <input type="number" name="price_rs" class="form-control" required
               min="0.01" step="0.01" placeholder="0.00">
      </div>
      <div class="col-md-4">
        <label class="form-label"><?php echo I18n::t('price.date'); ?></label>
        <input type="date" name="price_date" class="form-control"
               value="<?php echo date('Y-m-d'); ?>" required>
      </div>
      <div class="col-md-4">
        <label class="form-label"><?php echo I18n::t('price.source'); ?></label>
        <input type="text" name="source" class="form-control" placeholder="Ex : visite marché">
      </div>
    </div>

    <div class="mb-4">
      <label class="form-label"><?php echo I18n::t('price.note'); ?></label>
      <textarea name="note" class="form-control" rows="3"
                placeholder="Remarques supplémentaires…"></textarea>
    </div>

    <button class="btn btn-primary" type="submit" id="submitBtn">
      <?php echo I18n::t('price.submit'); ?>
    </button>
  </form>
</div>
