(function () {
  const data = window.__HISTORY__ || [];
  const el = document.getElementById('historyChart');
  if (!el || data.length === 0) return;

  const isDark    = document.body.classList.contains('dark');
  const ink       = isDark ? '#EFEDE7' : '#202520';
  const inkMuted  = isDark ? '#B7B4AA' : '#5F665F';
  const downColor = '#C4512D';
  const gridColor = isDark ? 'rgba(239,237,231,0.10)' : 'rgba(32,37,32,0.12)';
  const monoFont  = "'Space Mono', 'IBM Plex Mono', monospace";

  new Chart(el, {
    type: 'line',
    data: {
      labels: data.map(x => x.date),
      datasets: [{
        label: 'Prix (Rs)',
        data:   data.map(x => x.price),
        borderColor: downColor,
        backgroundColor: 'transparent',
        borderWidth: 2,
        pointRadius: 2,
        pointHoverRadius: 2,
        pointBackgroundColor: downColor,
        pointBorderColor: 'transparent',
        tension: 0,
        fill: false,
      }]
    },
    options: {
      responsive: true,
      animation: false,
      plugins: {
        legend: {
          labels: {
            color: inkMuted,
            font: { family: monoFont, size: 10 }
          }
        },
        tooltip: {
          backgroundColor: isDark ? '#1A1711' : '#FDFAF4',
          borderColor: isDark ? 'rgba(234,228,216,0.20)' : 'rgba(26,24,20,0.18)',
          borderWidth: 1,
          titleColor: ink,
          bodyColor: inkMuted,
          bodyFont:  { family: monoFont },
          titleFont: { family: monoFont, weight: '500' },
          padding: 10,
          cornerRadius: 0,
        }
      },
      scales: {
        x: {
          ticks: { color: inkMuted, font: { family: monoFont, size: 10 } },
          grid:  { color: gridColor }
        },
        y: {
          ticks: {
            color: inkMuted,
            font: { family: monoFont, size: 10 },
            callback: v => 'Rs ' + v
          },
          grid: { color: gridColor }
        }
      }
    }
  });
})();

function togglePassword(id) {
  const input = document.getElementById(id);
  const icon  = input.nextElementSibling;
  const isHidden = input.type === 'password';
  input.type = isHidden ? 'text' : 'password';
  icon.classList.toggle('bi-eye',       !isHidden);
  icon.classList.toggle('bi-eye-slash',  isHidden);
}

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

document.addEventListener('DOMContentLoaded', function () {
  /* Tooltips Bootstrap */
  document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
    new bootstrap.Tooltip(el);
  });

  /* Désactiver le bouton submit au clic */
  document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function () {
      const btn = form.querySelector('#submitBtn');
      if (btn) {
        btn.disabled = true;
        btn.innerHTML =
          '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Chargement…';
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
});
