/* ─── Chart historique ──────────────────────────────────── */
(function () {
  var data = window.__HISTORY__ || [];
  var el   = document.getElementById('historyChart');
  if (!el || data.length === 0) return;

  var isDark    = document.body.classList.contains('dark');
  var ink       = isDark ? '#E5EBE2' : '#1C2218';
  var inkMuted  = isDark ? '#88A08B' : '#6B7A6D';
  var gridColor = isDark ? 'rgba(42,61,49,0.60)' : 'rgba(217,208,193,0.70)';
  var lineColor = '#3B8EA5';
  var fillColor = isDark ? 'rgba(59,142,165,0.09)' : 'rgba(59,142,165,0.07)';
  var sansFont  = "'Plus Jakarta Sans', system-ui, sans-serif";

  new Chart(el, {
    type: 'line',
    data: {
      labels: data.map(function(x){ return x.date; }),
      datasets: [{
        label: 'Prix (Rs)',
        data:   data.map(function(x){ return x.price; }),
        borderColor:          lineColor,
        backgroundColor:      fillColor,
        borderWidth:          2,
        pointRadius:          3.5,
        pointHoverRadius:     6,
        pointBackgroundColor: lineColor,
        pointBorderColor:     isDark ? '#1C2B22' : '#FDFAF3',
        pointBorderWidth:     2,
        tension:              0.38,
        fill:                 true,
      }]
    },
    options: {
      responsive:  true,
      animation:   { duration: 700, easing: 'easeInOutQuart' },
      plugins: {
        legend: { labels: { color: inkMuted, font: { family: sansFont, size: 10, weight: '600' }, boxWidth: 12, boxHeight: 2 } },
        tooltip: {
          backgroundColor: isDark ? '#1C2B22' : '#FDFAF3',
          borderColor:     isDark ? '#2A3D31' : '#D9D0C1',
          borderWidth:     1,
          titleColor:      ink, bodyColor: inkMuted,
          titleFont:       { family: sansFont, weight: '700', size: 12 },
          bodyFont:        { family: sansFont, size: 12 },
          padding:         14, cornerRadius: 10,
          callbacks: { label: function(ctx){ return '  Rs ' + ctx.parsed.y.toFixed(2); } }
        }
      },
      scales: {
        x: { ticks: { color: inkMuted, font: { family: sansFont, size: 10 }, maxRotation: 30 }, grid: { color: gridColor } },
        y: { ticks: { color: inkMuted, font: { family: sansFont, size: 10 }, callback: function(v){ return 'Rs ' + v; } }, grid: { color: gridColor } }
      }
    }
  });
})();

/* ─── Toggle mot de passe ───────────────────────────────── */
function togglePassword(id) {
  var input  = document.getElementById(id);
  var icon   = input.nextElementSibling;
  var hidden = input.type === 'password';
  input.type = hidden ? 'text' : 'password';
  icon.classList.toggle('bi-eye',      !hidden);
  icon.classList.toggle('bi-eye-slash', hidden);
}

/* ─── Thème ─────────────────────────────────────────────── */
function toggleTheme() {
  var body   = document.body;
  var toggle = document.getElementById('themeToggle');
  body.classList.toggle('dark');
  var isDark = body.classList.contains('dark');
  if (toggle) toggle.innerHTML = isDark ? '<i class="bi bi-sun"></i>' : '<i class="bi bi-moon"></i>';
  localStorage.setItem('theme', isDark ? 'dark' : 'light');
}

/* ─── Count-up ──────────────────────────────────────────── */
function countUp(el, target, duration) {
  duration    = duration || 900;
  var start   = performance.now();
  var isFloat = String(target).includes('.');
  function step(now) {
    var p    = Math.min((now - start) / duration, 1);
    var ease = 1 - Math.pow(1 - p, 3);
    el.textContent = isFloat ? (ease * target).toFixed(2) : Math.round(ease * target);
    if (p < 1) requestAnimationFrame(step);
  }
  requestAnimationFrame(step);
}

/* ─── Toast ─────────────────────────────────────────────── */
var toastStack = [];

function showToast(message, type, duration) {
  type     = type || 'default';
  duration = duration || 5000;

  var toast = document.createElement('div');
  toast.className = 'toast-market' + (type === 'success' ? ' toast-market-success' : '');
  toast.style.setProperty('--toast-duration', (duration / 1000) + 's');

  var icon = type === 'success' ? '✓' : '🛒';
  toast.innerHTML =
    '<div class="toast-header"><span>' + icon + '</span> Market Prices MU</div>' +
    '<div class="toast-body">' + message + '</div>' +
    '<div class="toast-progress"></div>';

  /* Stack offset */
  var offset = toastStack.length * 90;
  toast.style.bottom = (24 + offset) + 'px';
  toastStack.push(toast);

  document.body.appendChild(toast);
  requestAnimationFrame(function() { toast.classList.add('toast-show'); });

  setTimeout(function() {
    toast.classList.remove('toast-show');
    setTimeout(function() {
      toast.remove();
      toastStack = toastStack.filter(function(t){ return t !== toast; });
    }, 400);
  }, duration);
}

/* ─── DOMContentLoaded ──────────────────────────────────── */
document.addEventListener('DOMContentLoaded', function() {

  /* Bootstrap tooltips */
  document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function(el) {
    new bootstrap.Tooltip(el, { trigger: 'hover' });
  });

  /* Disable submit on click */
  document.querySelectorAll('form').forEach(function(form) {
    form.addEventListener('submit', function() {
      var btn = form.querySelector('#submitBtn');
      if (btn) {
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Chargement…';
      }
    });
  });

  /* Restore theme */
  var toggle     = document.getElementById('themeToggle');
  var savedTheme = localStorage.getItem('theme');
  if (savedTheme === 'dark') {
    document.body.classList.add('dark');
    if (toggle) toggle.innerHTML = '<i class="bi bi-sun"></i>';
  } else {
    if (toggle) toggle.innerHTML = '<i class="bi bi-moon"></i>';
  }

  /* ── Navbar: transparent home → glassmorphism scroll ── */
  var nav      = document.getElementById('mainNav');
  var progress = document.getElementById('navProgress');
  var isHome   = nav && nav.classList.contains('navbar-transparent');

  function handleScroll() {
    if (!nav) return;
    var scrolled = window.scrollY > 60;
    if (isHome) {
      if (scrolled) {
        nav.classList.remove('navbar-transparent');
        nav.classList.add('navbar-scrolled');
      } else {
        nav.classList.add('navbar-transparent');
        nav.classList.remove('navbar-scrolled');
      }
    } else {
      nav.classList.toggle('navbar-scrolled', window.scrollY > 10);
    }

    if (progress) {
      var scrollable = document.body.scrollHeight - window.innerHeight;
      var pct = scrollable > 0 ? (window.scrollY / scrollable) * 100 : 0;
      progress.style.width = pct + '%';
    }
  }

  window.addEventListener('scroll', handleScroll, { passive: true });
  handleScroll();

  /* ── Cursor follow on hero ── */
  var hero = document.querySelector('.hero');
  if (hero) {
    hero.addEventListener('mousemove', function(e) {
      var rect = hero.getBoundingClientRect();
      var x    = ((e.clientX - rect.left) / rect.width)  * 100;
      var y    = ((e.clientY - rect.top)  / rect.height) * 100;
      hero.style.setProperty('--cursor-x', x + '%');
      hero.style.setProperty('--cursor-y', y + '%');
    });
  }

  /* ── Active nav ── */
  (function() {
    var path = window.location.pathname;
    document.querySelectorAll('.navbar .nav-link').forEach(function(link) {
      var href = (link.getAttribute('href') || '').split('?')[0];
      if (href && path.endsWith(href)) {
        link.classList.add('active');
        link.setAttribute('aria-current', 'page');
      }
    });
    document.querySelectorAll('.mobile-nav-item').forEach(function(item) {
      var href = (item.getAttribute('href') || '').split('?')[0];
      if (href && path.endsWith(href)) item.classList.add('active');
    });
  })();

  /* ── IntersectionObserver ── */
  if ('IntersectionObserver' in window) {
    /* Scroll animations */
    var io = new IntersectionObserver(function(entries) {
      entries.forEach(function(e) {
        if (e.isIntersecting) {
          e.target.classList.add('visible');
          io.unobserve(e.target);
        }
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -30px 0px' });

    document.querySelectorAll('.animate-on-scroll, .fade-in').forEach(function(el) { io.observe(el); });

    /* Count-up */
    var cuObs = new IntersectionObserver(function(entries) {
      entries.forEach(function(e) {
        if (e.isIntersecting) {
          var val = parseFloat(e.target.dataset.value);
          if (!isNaN(val)) countUp(e.target, val);
          cuObs.unobserve(e.target);
        }
      });
    }, { threshold: 0.3 });

    document.querySelectorAll('[data-count-up]').forEach(function(el) { cuObs.observe(el); });

    /* Confidence ring */
    document.querySelectorAll('.confidence-ring-bar[data-pct]').forEach(function(bar) {
      var ringObs = new IntersectionObserver(function(entries) {
        entries.forEach(function(e) {
          if (e.isIntersecting) {
            var pct   = parseFloat(bar.dataset.pct) / 100;
            var r     = parseFloat(bar.getAttribute('r'));
            var circ  = 2 * Math.PI * r;
            bar.style.strokeDasharray  = circ;
            bar.style.strokeDashoffset = circ * (1 - pct);
            ringObs.unobserve(bar);
          }
        });
      }, { threshold: 0.5 });
      ringObs.observe(bar);
    });

  } else {
    document.querySelectorAll('.animate-on-scroll, .fade-in').forEach(function(el) { el.classList.add('visible'); });
    document.querySelectorAll('.confidence-ring-bar[data-pct]').forEach(function(bar) {
      var pct  = parseFloat(bar.dataset.pct) / 100;
      var r    = parseFloat(bar.getAttribute('r'));
      var circ = 2 * Math.PI * r;
      bar.style.strokeDasharray  = circ;
      bar.style.strokeDashoffset = circ * (1 - pct);
    });
  }

  /* ── Stagger cards ── */
  document.querySelectorAll('.card-grid .card, .row-stagger .card').forEach(function(card, i) {
    card.style.transitionDelay = (i * 0.15) + 's';
    card.classList.add('animate-on-scroll');
  });

  /* ── First-visit modal ── */
  if (!localStorage.getItem('mv_visited')) {
    setTimeout(function() {
      var backdrop = document.createElement('div');
      backdrop.className = 'first-visit-backdrop';
      backdrop.innerHTML =
        '<div class="first-visit-card">' +
          '<button class="first-visit-close" id="fvClose" aria-label="Fermer">✕</button>' +
          '<div class="first-visit-title">Bienvenue ! 🥬</div>' +
          '<p style="font-family:var(--f-sans);font-size:0.9rem;color:var(--text-muted);line-height:1.65;margin-bottom:1.25rem;">' +
            'Market Prices MU vous permet de consulter et contribuer aux prix des fruits et légumes dans les marchés de Maurice.<br><br>' +
            '<strong>Consultez</strong> les prix en temps réel, <strong>comparez</strong> entre marchés, et <strong>prédisez</strong> l\'évolution des prix grâce à notre modèle IA.' +
          '</p>' +
          '<button class="btn btn-primary w-100" id="fvStart">Commencer à explorer</button>' +
        '</div>';
      document.body.appendChild(backdrop);
      localStorage.setItem('mv_visited', '1');

      function closeModal() { backdrop.style.opacity='0'; backdrop.style.transition='opacity 0.25s'; setTimeout(function(){ backdrop.remove(); }, 260); }
      document.getElementById('fvClose').addEventListener('click', closeModal);
      document.getElementById('fvStart').addEventListener('click', closeModal);
      backdrop.addEventListener('click', function(e){ if (e.target === backdrop) closeModal(); });
    }, 1800);
  }

  /* ── Welcome toast ── */
  if (!sessionStorage.getItem('mv_toast_shown')) {
    sessionStorage.setItem('mv_toast_shown', '1');
    setTimeout(function() {
      showToast('Bienvenue sur Market Prices MU — consultez les prix du marché local en temps réel.', 'default', 5000);
    }, 3000);
  }

  /* ── Flash alerts → toast ── */
  document.querySelectorAll('.alert[data-autotoast]').forEach(function(el) {
    var type = el.classList.contains('alert-success') ? 'success' : 'default';
    showToast(el.textContent.trim(), type);
    el.remove();
  });

});
