<div class="page-header">
  <span class="section-num">Administration</span>
  <h1 class="page-title">Gestion des produits</h1>
</div>

<?php if ($error): ?>
  <div class="alert alert-danger mb-4"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<!-- Formulaire ajout -->
<div class="card mb-5">
  <div class="card-header">Ajouter un produit</div>
  <div class="card-body">
    <form method="POST" action="<?php echo $app['base_url']; ?>/admin/products">
      <input type="hidden" name="csrf_token" value="<?php echo Auth::csrfToken(); ?>">
      <div class="row g-3 align-items-end">
        <div class="col-md-4">
          <label class="form-label">Nom</label>
          <input type="text" name="name" class="form-control" placeholder="Ex: Mangue" required>
        </div>
        <div class="col-md-3">
          <label class="form-label">Catégorie</label>
          <select name="category" class="form-select" required>
            <option value="">— choisir —</option>
            <option value="fruit">Fruit</option>
            <option value="legume">Légume</option>
          </select>
        </div>
        <div class="col-md-3">
          <label class="form-label">Unité</label>
          <select name="unit" class="form-select">
            <option value="kg">kg</option>
            <option value="piece">pièce</option>
            <option value="botte">botte</option>
            <option value="litre">litre</option>
          </select>
        </div>
        <div class="col-md-2">
          <button type="submit" id="submitBtn" class="btn btn-primary w-100">Ajouter</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Liste des produits -->
<?php
$fruits  = array_filter($products, fn($p) => $p['category'] === 'fruit');
$legumes = array_filter($products, fn($p) => $p['category'] === 'legume');
?>

<?php foreach (['fruit' => ['Fruits', $fruits], 'legume' => ['Légumes', $legumes]] as [$label, $list]): ?>
<div class="mb-5">
  <div class="section-heading mb-3">
    <span class="section-num mb-0"><?php echo $label; ?></span>
    <span class="text-muted" style="font-size:0.75rem;"><?php echo count($list); ?> produit<?php echo count($list) > 1 ? 's' : ''; ?></span>
  </div>
  <div class="card">
    <div class="card-body" style="padding:0;">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead>
            <tr>
              <th>Nom</th>
              <th>Unité</th>
              <th>Statut</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($list)): ?>
              <tr>
                <td colspan="4" class="text-muted text-center" style="padding:2rem;">Aucun produit.</td>
              </tr>
            <?php endif; ?>
            <?php foreach ($list as $p): ?>
              <tr>
                <td><?php echo htmlspecialchars($p['name']); ?></td>
                <td><?php echo htmlspecialchars($p['unit']); ?></td>
                <td>
                  <?php if ($p['is_active']): ?>
                    <span class="badge badge-gold">Actif</span>
                  <?php else: ?>
                    <span style="font-family:var(--f-sans);font-size:0.6rem;font-weight:500;letter-spacing:0.10em;text-transform:uppercase;color:var(--text-muted);">Inactif</span>
                  <?php endif; ?>
                </td>
                <td class="text-end">
                  <form method="POST" action="<?php echo $app['base_url']; ?>/admin/products/toggle" style="display:inline;">
                    <input type="hidden" name="csrf_token" value="<?php echo Auth::csrfToken(); ?>">
                    <input type="hidden" name="id" value="<?php echo (int)$p['id']; ?>">
                    <button type="submit" class="btn btn-sm <?php echo $p['is_active'] ? 'btn-outline-danger' : 'btn-outline-secondary'; ?>">
                      <?php echo $p['is_active'] ? 'Désactiver' : 'Réactiver'; ?>
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
