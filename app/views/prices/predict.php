<div class="page-header">
  <span class="section-num">03 &mdash; Analyse prédictive</span>
  <h1 class="page-title"><?php echo I18n::t('predict.title'); ?></h1>
  <p class="page-subtitle">Modèle de régression Ridge &mdash; prévision à 7 jours</p>
</div>

<form class="d-flex gap-2 align-items-end flex-wrap mb-4" method="get">
  <div style="min-width:240px; flex:1;">
    <label class="form-label"><?php echo I18n::t('price.market'); ?></label>
    <select name="market_id" class="form-select" required>
      <option value="">Sélectionner un marché</option>
      <?php foreach ($markets as $m): ?>
        <option value="<?php echo (int)$m['id']; ?>" <?php echo ($marketId==$m['id'])?'selected':''; ?>>
          <?php echo htmlspecialchars($m['name']); ?> &mdash; <?php echo htmlspecialchars($m['region']); ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>
  <div style="min-width:240px; flex:1;">
    <label class="form-label"><?php echo I18n::t('price.product'); ?></label>
    <select name="product_id" class="form-select" required>
      <option value="">Sélectionner un produit</option>
      <?php foreach ($products as $p): ?>
        <option value="<?php echo (int)$p['id']; ?>" <?php echo ($productId==$p['id'])?'selected':''; ?>>
          <?php echo htmlspecialchars($p['name']); ?> (<?php echo htmlspecialchars($p['unit']); ?>)
        </option>
      <?php endforeach; ?>
    </select>
  </div>
  <div>
    <label class="form-label" style="visibility:hidden; display:block;">Analyser</label>
    <button class="btn btn-primary" id="submitBtn">Analyser</button>
  </div>
</form>

<?php if ($marketId && $productId): ?>
<div class="row g-3">
  <div class="col-lg-7">
    <div class="card h-100">
      <div class="card-header">Historique des prix</div>
      <div class="card-body">
        <canvas id="historyChart" height="180"></canvas>
      </div>
    </div>
  </div>

  <div class="col-lg-5">
    <div class="card h-100" style="background: var(--bg-dark); border-color: var(--border-dark);">
      <div class="card-header" style="border-color: var(--border-dark); color: var(--text-muted-light);">
        Prédiction J+7
      </div>
      <div class="card-body d-flex flex-column justify-content-center" style="padding: 2.5rem 2rem;">
        <?php if (!$prediction): ?>
          <p class="text-muted mb-0">Aucun résultat disponible.</p>
        <?php elseif (!($prediction['ok'] ?? false)): ?>
          <div class="alert alert-warning mb-0">
            <?php echo htmlspecialchars($prediction['message'] ?? 'Erreur'); ?>
          </div>
        <?php else: ?>
          <span class="section-num" style="color: var(--text-muted-light);">Prix estimé</span>
          <div style="font-family: var(--f-serif); font-size: 3.2rem; font-weight: 300; color: var(--gold); line-height: 1.05; letter-spacing: -0.01em;">
            Rs <?php echo number_format((float)$prediction['predicted_price'], 2); ?>
          </div>
          <div style="font-size:0.8rem; color: var(--text-muted-light); margin-top: 0.75rem; margin-bottom: 1.5rem;">
            <?php echo htmlspecialchars($prediction['target_date']); ?>
          </div>
          <hr style="border-color: var(--border-dark);">
          <div style="font-size:0.75rem; color: var(--text-muted-light);">
            <span class="prediction-chip">
              <?php echo htmlspecialchars($prediction['model']); ?>
            </span>
            <span class="ms-2"><?php echo (int)$prediction['points']; ?> points</span>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<script>window.__HISTORY__ = <?php echo json_encode($history); ?>;</script>
<?php endif; ?>
