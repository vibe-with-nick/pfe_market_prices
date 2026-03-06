(function(){
  const data = window.__HISTORY__ || [];
  const el = document.getElementById('historyChart');
  if (!el || data.length === 0) return;

  const labels = data.map(x => x.date);
  const values = data.map(x => x.price);

  new Chart(el, {
    type: 'line',
    data: { labels, datasets: [{ label: 'Prix', data: values }]},
    options: { responsive:true }
  });
})();

function togglePassword(id) {
  const input = document.getElementById(id);
  const icon = input.nextElementSibling;
  if (input.type === 'password') {
    input.type = 'text';
    icon.classList.remove('bi-eye');
    icon.classList.add('bi-eye-slash');
  } else {
    input.type = 'password';
    icon.classList.remove('bi-eye-slash');
    icon.classList.add('bi-eye');
  }
}

function toggleTheme() {
  const body = document.body;
  const themeToggle = document.getElementById('themeToggle');
  body.classList.toggle('dark');
  const isDark = body.classList.contains('dark');
  if (isDark) {
    themeToggle.innerHTML = '<i class="bi bi-sun"></i>';
  } else {
    themeToggle.innerHTML = '<i class="bi bi-moon"></i>';
  }
  localStorage.setItem('theme', isDark ? 'dark' : 'light');
}

document.addEventListener('DOMContentLoaded', function() {
  // Initialize tooltips
  const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });

  const forms = document.querySelectorAll('form');
  forms.forEach(form => {
    form.addEventListener('submit', function() {
      const btn = form.querySelector('#submitBtn');
      if (btn) {
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Chargement...';
      }
    });
  });

  // Theme toggle init
  const themeToggle = document.getElementById('themeToggle');
  const body = document.body;
  const savedTheme = localStorage.getItem('theme');
  if (savedTheme === 'dark') {
    body.classList.add('dark');
    themeToggle.innerHTML = '<i class="bi bi-sun"></i>';
  } else {
    themeToggle.innerHTML = '<i class="bi bi-moon"></i>';
  }
});
