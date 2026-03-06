<h1 class="h4 mb-3"><?php echo I18n::t('predict.title'); ?></h1>

<form class="card p-3 mb-3" method="get">
  <div class="row g-2">
    <div class="col-md-5">
      <label class="form-label"><?php echo I18n::t('price.market'); ?></label>
      <select name="market_id" class="form-select" required>
        <option value="">--</option>
        <?php foreach ($markets as $m): ?>
          <option value="<?php echo (int)$m['id']; ?>" <?php echo ($marketId==$m['id'])?'selected':''; ?>>
            <?php echo htmlspecialchars($m['name']); ?> (<?php echo htmlspecialchars($m['region']); ?>)
          </option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-5">
      <label class="form-label"><?php echo I18n::t('price.product'); ?></label>
      <select name="product_id" class="form-select" required>
        <option value="">--</option>
        <?php foreach ($products as $p): ?>
          <option value="<?php echo (int)$p['id']; ?>" <?php echo ($productId==$p['id'])?'selected':''; ?>>
            <?php echo htmlspecialchars($p['name']); ?> (<?php echo htmlspecialchars($p['unit']); ?>)
          </option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-2 d-flex align-items-end"><button class="btn btn-dark w-100">OK</button></div>
  </div>
</form>

<?php if ($marketId && $productId): ?>
  <div class="row g-3">
    <div class="col-lg-7">
      <div class="card">
        <div class="card-header fw-bold">Historique</div>
        <div class="card-body"><canvas id="historyChart" height="140"></canvas></div>
      </div>
    </div>
    <div class="col-lg-5">
      <div class="card">
        <div class="card-header fw-bold">Prédiction (J+7)</div>
        <div class="card-body">
          <?php if (!$prediction): ?>
            <div class="text-muted">Aucun résultat.</div>
          <?php elseif (!($prediction['ok'] ?? false)): ?>
            <div class="alert alert-warning mb-0"><?php echo htmlspecialchars($prediction['message'] ?? 'Erreur'); ?></div>
          <?php else: ?>
            <div class="display-6 fw-bold">Rs <?php echo number_format((float)$prediction['predicted_price'], 2); ?></div>
            <div class="text-muted">Date: <?php echo htmlspecialchars($prediction['target_date']); ?></div>
            <hr>
            <div class="small text-muted">Modèle: <?php echo htmlspecialchars($prediction['model']); ?> — points: <?php echo (int)$prediction['points']; ?></div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
  <script>window.__HISTORY__ = <?php echo json_encode($history); ?>;</script>
<?php endif; ?>
