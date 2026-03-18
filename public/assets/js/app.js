(function () {
  const data = window.__HISTORY__ || [];
  const el   = document.getElementById('historyChart');
  if (!el || data.length === 0) return;

  const isDark    = document.body.classList.contains('dark');
  const ink       = isDark ? '#ECF0E8' : '#171F14';
  const inkMuted  = isDark ? '#89A08B' : '#6B7A6C';
  const gridColor = isDark ? 'rgba(46,74,56,0.55)' : 'rgba(224,217,206,0.70)';
  const gold      = '#1A8A7C';
  const goldFill  = isDark ? 'rgba(26,138,124,0.10)' : 'rgba(26,138,124,0.07)';
  const sansFont  = "'Plus Jakarta Sans', system-ui, sans-serif";

  new Chart(el, {
    type: 'line',
    data: {
      labels: data.map(x => x.date),
      datasets: [{
        label: 'Prix (Rs)',
        data:   data.map(x => x.price),
        borderColor:          gold,
        backgroundColor:      goldFill,
        borderWidth:          1.5,
        pointRadius:          3,
        pointHoverRadius:     5,
        pointBackgroundColor: gold,
        pointBorderColor:     isDark ? '#1F3329' : '#FFFFFF',
        pointBorderWidth:     1.5,
        tension:              0.3,
        fill:                 true,
      }]
    },
    options: {
      responsive: true,
      animation: { duration: 500, easing: 'easeInOutQuart' },
      plugins: {
        legend: {
          labels: {
            color: inkMuted,
            font: { family: sansFont, size: 10, weight: '500' },
            boxWidth: 12,
            boxHeight: 2,
          }
        },
        tooltip: {
          backgroundColor: isDark ? '#1F3329' : '#FFFFFF',
          borderColor:     isDark ? '#2E4A38' : '#E0D9CE',
          borderWidth:     1,
          titleColor:      ink,
          bodyColor:       inkMuted,
          titleFont:       { family: sansFont, weight: '500', size: 12 },
          bodyFont:        { family: sansFont, size: 12 },
          padding:         14,
          cornerRadius:    3,
          callbacks: {
            label: ctx => '  Rs ' + ctx.parsed.y.toFixed(2),
          }
        }
      },
      scales: {
        x: {
          ticks: {
            color:       inkMuted,
            font:        { family: sansFont, size: 10 },
            maxRotation: 30,
          },
          grid: { color: gridColor }
        },
        y: {
          ticks: {
            color:    inkMuted,
            font:     { family: sansFont, size: 10 },
            callback: v => 'Rs ' + v
          },
          grid: { color: gridColor }
        }
      }
    }
  });
})();

/* ── Mot de passe : afficher / masquer ─────────────────── */
function togglePassword(id) {
  const input  = document.getElementById(id);
  const icon   = input.nextElementSibling;
  const hidden = input.type === 'password';
  input.type = hidden ? 'text' : 'password';
  icon.classList.toggle('bi-eye',       !hidden);
  icon.classList.toggle('bi-eye-slash',  hidden);
}

/* ── Thème clair / sombre ──────────────────────────────── */
function toggleTheme() {
  const body        = document.body;
  const themeToggle = document.getElementById('themeToggle');
  body.classList.toggle('dark');
  const isDark = body.classList.contains('dark');
  themeToggle.innerHTML = isDark
    ? '<i class="bi bi-sun"></i>'
    : '<i class="bi bi-moon"></i>';
  localStorage.setItem('theme', isDark ? 'dark' : 'light');
}

/* ── Active nav link ───────────────────────────────────── */
function markActiveNavLink() {
  const path = window.location.pathname;
  document.querySelectorAll('.navbar .nav-link, .mobile-nav-item').forEach(link => {
    const href = (link.getAttribute('href') || '').split('?')[0];
    if (href && path.endsWith(href)) link.classList.add('active');
  });
}

document.addEventListener('DOMContentLoaded', function () {
  /* Tooltips Bootstrap */
  document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
    new bootstrap.Tooltip(el, { trigger: 'hover' });
  });

  /* Désactiver le bouton submit au clic pour éviter le double envoi */
  document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function () {
      const btn = form.querySelector('#submitBtn');
      if (btn) {
        btn.disabled = true;
        btn.innerHTML =
          '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Chargement…';
      }
    });
  });

  /* Restaurer le thème depuis localStorage */
  const themeToggle = document.getElementById('themeToggle');
  const savedTheme  = localStorage.getItem('theme');
  if (savedTheme === 'dark') {
    document.body.classList.add('dark');
    if (themeToggle) themeToggle.innerHTML = '<i class="bi bi-sun"></i>';
  } else {
    if (themeToggle) themeToggle.innerHTML = '<i class="bi bi-moon"></i>';
  }

  markActiveNavLink();

  /* ── Navbar scroll : ajoute .navbar-scrolled au défilement ── */
  const nav = document.querySelector('.navbar');
  if (nav) {
    const onScroll = () => nav.classList.toggle('navbar-scrolled', window.scrollY > 50);
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }

  /* ── IntersectionObserver — .animate-on-scroll et .fade-in ── */
  if ('IntersectionObserver' in window) {
    const io = new IntersectionObserver((entries) => {
      entries.forEach(e => {
        if (e.isIntersecting) {
          e.target.classList.add('visible');
          io.unobserve(e.target);
        }
      });
    }, { threshold: 0.10, rootMargin: '0px 0px -40px 0px' });

    document.querySelectorAll('.animate-on-scroll, .fade-in').forEach(el => io.observe(el));
  } else {
    /* Fallback navigateurs sans IO */
    document.querySelectorAll('.animate-on-scroll, .fade-in').forEach(el => el.classList.add('visible'));
  }
});
