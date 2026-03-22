<!doctype html>
<html lang="<?php echo htmlspecialchars(I18n::lang()); ?>">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo htmlspecialchars($app['app_name']); ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400;600&family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;0,9..144,700;1,9..144,400&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
  <link href="<?php echo $app['base_url']; ?>/assets/css/app.css" rel="stylesheet">
</head>
<body>

<?php
$currentPage = $_GET['page'] ?? 'home';
$isHome      = ($currentPage === 'home' || $currentPage === '');
?>

<nav class="navbar navbar-expand-lg<?php echo $isHome ? ' navbar-transparent' : ''; ?>" id="mainNav">
  <div class="container" style="position:relative;">

    <a class="navbar-brand" href="<?php echo $app['base_url']; ?>/home">
      <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" style="flex-shrink:0;">
        <rect width="32" height="32" rx="9" fill="#1A5632"/>
        <path d="M16 7 C20.5 9.5 22 13 21 17.5 C20 21 18 23 16 23.5 C14 23 12 21 11 17.5 C10 13 11.5 9.5 16 7Z" fill="white" opacity="0.95"/>
        <line x1="16" y1="23" x2="16" y2="26" stroke="white" stroke-width="1.5" stroke-linecap="round" opacity="0.55"/>
        <line x1="16" y1="9" x2="16" y2="22" stroke="#1A5632" stroke-width="1.2" stroke-linecap="round" opacity="0.35"/>
      </svg>
      <span style="display:flex; flex-direction:column; line-height:1.15;">
        <span style="font-family:var(--f-handwritten); font-size:1.45rem; font-weight:600; line-height:1.1;"><?php echo htmlspecialchars($app['app_name']); ?></span>
        <span class="navbar-brand-tagline">Prix du marché · Maurice</span>
      </span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav" aria-label="Menu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav me-auto gap-1">
        <li class="nav-item">
          <a class="nav-link<?php echo ($currentPage==='home'||$currentPage==='')?'  active':''; ?>"
             href="<?php echo $app['base_url']; ?>/home"
             <?php echo ($currentPage==='home')?'aria-current="page"':''; ?>>
            <i class="bi bi-house"></i><?php echo I18n::t('nav.home'); ?>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link<?php echo $currentPage==='prices'?' active':''; ?>"
             href="<?php echo $app['base_url']; ?>/prices"
             <?php echo $currentPage==='prices'?'aria-current="page"':''; ?>>
            <i class="bi bi-bar-chart-line"></i><?php echo I18n::t('nav.prices'); ?>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link<?php echo $currentPage==='predict'?' active':''; ?>"
             href="<?php echo $app['base_url']; ?>/prices/predict"
             <?php echo $currentPage==='predict'?'aria-current="page"':''; ?>>
            <i class="bi bi-graph-up-arrow"></i><?php echo I18n::t('predict.title'); ?>
          </a>
        </li>
        <?php if (Auth::isAdmin()): ?>
        <li class="nav-item">
          <a class="nav-link<?php echo $currentPage==='admin'?' active':''; ?>"
             href="<?php echo $app['base_url']; ?>/admin"
             <?php echo $currentPage==='admin'?'aria-current="page"':''; ?>>
            <i class="bi bi-shield-check"></i><?php echo I18n::t('admin.panel'); ?>
          </a>
        </li>
        <?php endif; ?>
      </ul>

      <div class="d-flex gap-1 align-items-center">
        <button id="themeToggle" class="btn-icon" title="Basculer le thème" onclick="toggleTheme()" type="button">
          <i class="bi bi-moon"></i>
        </button>

        <div class="dropdown">
          <button class="btn-icon dropdown-toggle" style="border:none; background:transparent;" data-bs-toggle="dropdown" type="button" aria-label="Langue">
            <i class="bi bi-translate"></i>
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="?lang=fr">Français</a></li>
            <li><a class="dropdown-item" href="?lang=en">English</a></li>
            <li><a class="dropdown-item" href="?lang=mfe">Kreol</a></li>
          </ul>
        </div>

        <?php if (Auth::check()): ?>
          <div class="dropdown ms-1">
            <button class="btn btn-outline-light btn-sm dropdown-toggle" data-bs-toggle="dropdown" type="button">
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
          <a class="btn btn-outline-light btn-sm ms-1" href="<?php echo $app['base_url']; ?>/login">
            <?php echo I18n::t('nav.login'); ?>
          </a>
          <a class="btn btn-primary btn-sm" href="<?php echo $app['base_url']; ?>/register">
            <?php echo I18n::t('nav.register'); ?>
          </a>
        <?php endif; ?>
      </div>
    </div>

    <div class="navbar-progress" id="navProgress"></div>
  </div>
</nav>

<main class="container">
