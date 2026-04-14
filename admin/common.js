
const sidebarToggle = document.getElementById('sidebarToggle');
const sidebar = document.getElementById('sidebar');

if (sidebarToggle && sidebar) {
  sidebarToggle.addEventListener('click', () => {
    sidebar.classList.toggle('open');
  });
}


const currentPage = window.location.pathname.split('/').pop();
document.querySelectorAll('.sidebar-link').forEach(link => {
  if (link.getAttribute('href') === currentPage) {
    link.classList.add('active');
  }
});


const toastHost = document.getElementById('toastHost');

function toast({ title = 'Notice', msg = '', type = 'success', timeout = 3200 }) {
  if (!toastHost) return;
  const el = document.createElement('div');
  el.className = 'toast ' + (type === 'error' ? 'error' : 'success');
  el.innerHTML = `
    <div>
      <div class="toast-title">${title}</div>
      <div class="toast-msg">${msg}</div>
    </div>
    <button class="toast-close" aria-label="Close">OK</button>
  `;
  toastHost.appendChild(el);
  const kill = () => { el.style.opacity = '0'; setTimeout(() => el.remove(), 200); };
  el.querySelector('.toast-close').addEventListener('click', kill);
  if (timeout > 0) setTimeout(kill, timeout);
}


document.querySelectorAll('.btn-delete').forEach(btn => {
  btn.addEventListener('click', (e) => {
    if (!confirm('Are you sure you want to delete this item?')) {
      e.preventDefault();
    }
  });
});
