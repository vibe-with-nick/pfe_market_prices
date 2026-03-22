<div class="page-header">
  <span class="section-num">03 — Analyse prédictive</span>
  <h1 class="page-title"><?php echo I18n::t('predict.title'); ?></h1>
  <p class="page-subtitle">Modèle Ridge Regression — prévision à 7 jours</p>
</div>

<div class="predict-form-card">
  <form class="d-flex gap-2 align-items-end flex-wrap" method="get">
    <div style="min-width:240px; flex:1;">
      <label class="form-label"><?php echo I18n::t('price.market'); ?></label>
      <select name="market_id" class="form-select" required>
        <option value="">🏪 Sélectionner un marché</option>
        <?php foreach ($markets as $m): ?>
          <option value="<?php echo (int)$m['id']; ?>" <?php echo ($marketId==$m['id'])?'selected':''; ?>>
            <?php echo htmlspecialchars($m['name']); ?> — <?php echo htmlspecialchars($m['region']); ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
    <div style="min-width:240px; flex:1;">
      <label class="form-label"><?php echo I18n::t('price.product'); ?></label>
      <select name="product_id" class="form-select" required>
        <option value="">🥦 Sélectionner un produit</option>
        <?php foreach ($products as $p): ?>
          <option value="<?php echo (int)$p['id']; ?>" <?php echo ($productId==$p['id'])?'selected':''; ?>>
            <?php echo htmlspecialchars($p['name']); ?> (<?php echo htmlspecialchars($p['unit']); ?>)
          </option>
        <?php endforeach; ?>
      </select>
    </div>
    <div>
      <label class="form-label" style="visibility:hidden; display:block;">Go</label>
      <button class="btn btn-primary" id="submitBtn">
        <i class="bi bi-graph-up-arrow me-1"></i>Analyser
      </button>
    </div>
  </form>
</div>

<?php if ($marketId && $productId): ?>
<div class="row g-3">
  <div class="col-lg-7">
    <div class="card h-100" style="border-left:none;">
      <div class="card-header">Historique des prix</div>
      <div class="card-body">
        <canvas id="historyChart" height="180"></canvas>
      </div>
    </div>
  </div>

  <div class="col-lg-5">
    <div class="card-dark h-100" style="border-top:3px solid var(--teal); border-radius:14px;">
      <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.25rem;">
        <span style="font-family:var(--f-sans);font-size:0.6rem;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:var(--text-muted-light);">Prédiction J+7</span>
        <span class="chip chip-teal"
              data-bs-toggle="tooltip" data-bs-placement="top"
              title="Ridge Regression (λ=0.01) : régression linéaire régularisée avec tendance temporelle et encodage saisonnier mensuel. Requiert min. 6 points.">
          <i class="bi bi-cpu-fill"></i> Ridge ML
        </span>
      </div>

      <?php if (!$prediction): ?>
        <p class="text-muted mb-0">Aucun résultat disponible.</p>
      <?php elseif (!($prediction['ok'] ?? false)): ?>
        <div class="alert alert-warning mb-0"><?php echo htmlspecialchars($prediction['message'] ?? 'Erreur'); ?></div>
      <?php else: ?>
        <div style="font-family:var(--f-handwritten);font-size:1rem;color:var(--text-muted-light);margin-bottom:0.3rem;">Prix estimé</div>
        <div style="font-family:var(--f-serif);font-size:3rem;font-weight:700;color:var(--accent-yellow);line-height:1.05;letter-spacing:-0.01em;font-feature-settings:'ss01';"
             data-count-up data-value="<?php echo number_format((float)$prediction['predicted_price'],2,'.',  ''); ?>">
          Rs <?php echo number_format((float)$prediction['predicted_price'],2); ?>
        </div>
        <div style="font-size:0.8rem;color:var(--text-muted-light);margin-top:0.4rem;margin-bottom:1.5rem;">
          <?php echo htmlspecialchars($prediction['target_date']); ?>
        </div>

        <?php if (isset($prediction['confidence'])): ?>
        <?php $pct = min(100, round($prediction['confidence'] * 100)); $r = 36; $circ = round(2 * 3.14159 * $r, 2); ?>
        <div style="display:flex;align-items:center;gap:1.5rem;margin-bottom:1.5rem;">
          <svg class="confidence-ring" width="88" height="88" viewBox="0 0 88 88">
            <circle class="confidence-ring-bg" cx="44" cy="44" r="<?php echo $r; ?>" stroke-width="7"/>
            <circle class="confidence-ring-bar"
                    cx="44" cy="44" r="<?php echo $r; ?>"
                    stroke-width="7"
                    data-pct="<?php echo $pct; ?>"
                    style="stroke-dasharray:<?php echo $circ; ?>;stroke-dashoffset:<?php echo $circ; ?>;"/>
            <text class="confidence-ring-text" x="44" y="44"><?php echo $pct; ?>%</text>
          </svg>
          <div>
            <div style="font-family:var(--f-sans);font-size:0.62rem;font-weight:700;text-transform:uppercase;letter-spacing:0.10em;color:var(--text-muted-light);margin-bottom:0.3rem;">Confiance</div>
            <div style="font-family:var(--f-serif);font-size:1.5rem;font-weight:700;color:var(--teal);font-feature-settings:'ss01';"><?php echo $pct; ?>%</div>
          </div>
        </div>
        <?php endif; ?>

        <hr style="border-color:rgba(255,255,255,0.08);margin:1rem 0;">
        <div style="font-size:0.75rem;color:var(--text-muted-light);">
          <?php echo (int)$prediction['points']; ?> points historiques utilisés
        </div>

        <p class="predict-disclaimer">
          Prédiction basée sur les données historiques. Les prix réels peuvent varier selon l'offre et la demande du marché.
        </p>
      <?php endif; ?>
    </div>
  </div>
</div>
<script>window.__HISTORY__ = <?php echo json_encode($history); ?>;</script>
<?php endif; ?>
