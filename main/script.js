
const hamburger = document.getElementById('navHamburger');
const navLinks = document.getElementById('navLinks');

if (hamburger && navLinks) {
  hamburger.addEventListener('click', () => {
    hamburger.classList.toggle('active');
    navLinks.classList.toggle('open');
  });

  
  navLinks.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', () => {
      hamburger.classList.remove('active');
      navLinks.classList.remove('open');
    });
  });
}


function scrollTo(id) {
  const element = document.getElementById(id);
  if (element) element.scrollIntoView({ behavior: 'smooth' });
}


const buttons = {
  'startJourney': 'hero-menu',
  'toHome': 'hero-home',
  'toAbout': 'hero-about',
  'toMenu': 'hero-menu',
  'toContact': 'hero-contact',
  'toCTA': 'hero-menu'
};

for (const [btnId, targetId] of Object.entries(buttons)) {
  const btn = document.getElementById(btnId);
  if (btn) btn.addEventListener('click', () => scrollTo(targetId));
}


const navbar = document.querySelector('.navbar');
if (navbar) {
  window.addEventListener('scroll', () => {
    navbar.style.background = window.scrollY > 50 ? 'rgba(14, 14, 16, 0.95)' : '';
  }, { passive: true });
}


async function loadMenu(zoekterm = '') {
  const container = document.querySelector('.menuCon');
  if (!container) return;

  try {
    
    const url = 'api/menu.php' + (zoekterm ? '?q=' + encodeURIComponent(zoekterm) : '');

    const response = await fetch(url);
    const data = await response.json();

    
    let html = '';
    data.categories.forEach(cat => {
      html += `
        <section class="menuBlock">
          <h4 class="menuBlockTitle">${cat.name}</h4>
          <ul class="menuList">
            ${cat.items.map(item => `
              <li class="item">
                <div class="menuItemHead">
                  <span class="menuItemName">${item.name}</span>
                  <span class="menuItemPrice">€${Number(item.price).toFixed(2)}</span>
                </div>
                ${item.description ? `<p class="menuItemDesc">${item.description}</p>` : ''}
              </li>
            `).join('')}
          </ul>
        </section>`;
    });

    container.innerHTML = html || '<div class="no-results">Geen gerechten gevonden.</div>';
  } catch (err) {
    container.innerHTML = '<div class="error">Menu tijdelijk niet beschikbaar.</div>';
  }
}


document.addEventListener('DOMContentLoaded', () => loadMenu());


const searchInput = document.getElementById('menuSearch');
if (searchInput) {
  let timer;
  searchInput.addEventListener('input', () => {
    clearTimeout(timer);
    timer = setTimeout(() => {
      loadMenu(searchInput.value.trim());
    }, 300);
  });
}
