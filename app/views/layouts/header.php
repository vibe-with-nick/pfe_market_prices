<!doctype html>
<html lang="<?php echo htmlspecialchars(I18n::lang()); ?>">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo htmlspecialchars($app['app_name']); ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;0,9..144,700;1,9..144,400&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
  <link href="<?php echo $app['base_url']; ?>/assets/css/app.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg">
  <div class="container">
    <a class="navbar-brand" href="<?php echo $app['base_url']; ?>/home">
      <?php echo htmlspecialchars($app['app_name']); ?>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav me-auto gap-1">
        <li class="nav-item">
          <a class="nav-link" href="<?php echo $app['base_url']; ?>/home">
            <?php echo I18n::t('nav.home'); ?>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo $app['base_url']; ?>/prices">
            <?php echo I18n::t('nav.prices'); ?>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo $app['base_url']; ?>/prices/predict">
            <?php echo I18n::t('predict.title'); ?>
          </a>
        </li>
        <?php if (Auth::isAdmin()): ?>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo $app['base_url']; ?>/admin">
              <?php echo I18n::t('admin.panel'); ?>
            </a>
          </li>
        <?php endif; ?>
      </ul>

      <div class="d-flex gap-2 align-items-center">
        <button id="themeToggle" class="btn btn-outline-light btn-sm"
                data-bs-toggle="tooltip" data-bs-placement="bottom"
                title="Basculer le thème" onclick="toggleTheme()">
          <i class="bi bi-moon"></i>
        </button>

        <div class="dropdown">
          <button class="btn btn-outline-light btn-sm dropdown-toggle" data-bs-toggle="dropdown">
            <i class="bi bi-translate me-1"></i>Lang
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="?lang=fr">Français</a></li>
            <li><a class="dropdown-item" href="?lang=en">English</a></li>
            <li><a class="dropdown-item" href="?lang=mfe">Kreol</a></li>
          </ul>
        </div>

        <?php if (Auth::check()): ?>
          <div class="dropdown">
            <button class="btn btn-outline-light btn-sm dropdown-toggle" data-bs-toggle="dropdown">
              <?php echo htmlspecialchars(Auth::user()['name']); ?>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
              <li>
                <a class="dropdown-item" href="<?php echo $app['base_url']; ?>/change-password">
                  <i class="bi bi-key me-2"></i><?php echo I18n::t('auth.change_password'); ?>
                </a>
              </li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <a class="dropdown-item" href="<?php echo $app['base_url']; ?>/logout">
                  <i class="bi bi-box-arrow-right me-2"></i><?php echo I18n::t('nav.logout'); ?>
                </a>
              </li>
            </ul>
          </div>
        <?php else: ?>
          <a class="btn btn-outline-light btn-sm" href="<?php echo $app['base_url']; ?>/login">
            <?php echo I18n::t('nav.login'); ?>
          </a>
          <a class="btn btn-primary btn-sm" href="<?php echo $app['base_url']; ?>/register">
            <?php echo I18n::t('nav.register'); ?>
          </a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>

<main class="container">
