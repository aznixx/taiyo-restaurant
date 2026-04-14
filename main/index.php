<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Taiyo</title>
  <link rel="icon" type="image/x-icon" href="./assets/favicon.ico">

  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link rel="preload" as="style"
    href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,100..700;1,100..700&display=swap" />
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,100..700;1,100..700&display=swap"
    media="print" onload="this.media='all'" />
  <noscript>
    <link rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,100..700;1,100..700&display=swap" />
  </noscript>
  <link href="https://fonts.googleapis.com/css2?family=Special+Gothic+Expanded+One&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="styles.css" />
</head>

<body>
  <div class="scroll-container">

    <nav class="navbar">
      <div class="nav-inner">
        <a href="#hero-home" class="nav-logo">
          <img src="assets/colorkit.png" alt="Taiyo dragon" class="nav-logo-img" />
          <span class="nav-logo-text">TAIYO</span>
        </a>
        <button class="nav-hamburger" id="navHamburger" aria-label="Toggle menu">
          <span></span><span></span><span></span>
        </button>
        <ul class="nav-links" id="navLinks">
          <li><button type="button" id="toHome" class="nav-link">Home</button></li>
          <li><button type="button" id="toAbout" class="nav-link">About</button></li>
          <li><button type="button" id="toMenu" class="nav-link">Menu</button></li>
          <li><button type="button" id="toContact" class="nav-link">Contact</button></li>
        </ul>
      </div>
    </nav>

    <section id="hero-home">
      <div class="hero-content">
        <span class="homeTit">TAIYO</span>
        <div class="hero-divider"></div>
        <span class="loadingSub">A Journey of Taste and Culture</span>
        <button type="button" id="startJourney">EXPLORE THE MENU</button>
      </div>
    </section>

    <section id="hero-about" class="aboutSection">
      <div class="section-header">
        <h2 class="section-title">ABOUT</h2>
        <div class="section-line"></div>
      </div>
      <div class="aboutWrap">
        <div class="aboutHeader">
          <h3 class="aboutTitle">Real Broth. Bright Heat.</h3>
          <p class="aboutSubtitle">Seasonal bowls and small plates, cooked low and slow, served fast.</p>
        </div>
        <div class="aboutGrid">
          <article class="aboutCard">
            <h4 class="cardTitle">Craft</h4>
            <p class="cardText">12-hour stocks, tare built in layers, noodles with bite, and toppings finished to order.
            </p>
          </article>
          <article class="aboutCard">
            <h4 class="cardTitle">Sourcing</h4>
            <p class="cardText">Local greens in season, responsibly raised proteins, pantry staples like miso and shoyu.
            </p>
          </article>
          <article class="aboutCard">
            <h4 class="cardTitle">Atmosphere</h4>
            <p class="cardText">Warm welcome, quick service, music low enough to talk, seats designed to linger.</p>
          </article>
        </div>
        <div class="aboutStrip">
          <div class="stat">
            <div class="statValue">12h</div>
            <div class="statLabel">Broth simmer</div>
          </div>
          <div class="stat">
            <div class="statValue">5</div>
            <div class="statLabel">Signature bowls</div>
          </div>
          <div class="stat">
            <div class="statValue">3</div>
            <div class="statLabel">Heat levels</div>
          </div>
        </div>
        <div class="aboutChef">
          <div class="chefNote">
            <p>"Good ramen is balance — depth, aroma, texture. Everything else is garnish."</p>
            <span class="chefName">— Chef Aya</span>
          </div>
          <button type="button" class="btn-outline" id="toCTA">View Menu</button>
        </div>
      </div>
    </section>

    <section id="hero-menu">
      <div class="section-header">
        <h2 class="section-title">MENU</h2>
        <div class="section-line"></div>
      </div>
      <div class="menuSearchWrap">
        <input id="menuSearch" type="search" placeholder="Search dishes..." aria-label="Search dishes" />
        <ul id="menuSuggest" role="listbox" class="suggestList"></ul>
      </div>
      <div class="menuCon">

      </div>
    </section>

    <section id="hero-contact" class="contactSection">
      <div class="section-header">
        <h2 class="section-title">CONTACT</h2>
        <div class="section-line"></div>
      </div>
      <div class="contactWrap">
        <div class="contactHeader">
          <h3 class="contactTitle">Get In Touch</h3>
          <p class="contactSubtitle">Questions, bookings, or large parties — send a note and a team member will reply
            soon.</p>
        </div>

        <form class="contactForm" action="contact/submit.php" method="POST">
          <div class="formRow">
            <div class="formField">
              <label for="fullName">Full name</label>
              <input id="fullName" name="fullName" type="text" autocomplete="name" required />
              <span class="fieldHint">Enter first and last name.</span>
            </div>
            <div class="formField">
              <label for="email">Email</label>
              <input id="email" name="email" type="email" inputmode="email" autocomplete="email" required />
              <span class="fieldHint">We'll only use this to reply.</span>
            </div>
          </div>
          <div class="formRow">
            <div class="formField">
              <label for="phone">Phone (optional)</label>
              <input id="phone" name="phone" type="tel" inputmode="tel" autocomplete="tel" />
              <span class="fieldHint">Prefer a call? Add a number.</span>
            </div>
            <div class="formField">
              <label for="partySize">Party size</label>
              <select id="partySize" name="partySize" required>
                <option value="" selected disabled>Choose</option>
                <option>1–2</option>
                <option>3–4</option>
                <option>5–6</option>
                <option>7–8</option>
                <option>9+</option>
              </select>
              <span class="fieldHint">For bookings and events.</span>
            </div>
          </div>
          <div class="formRow">
            <div class="formField formFieldFull">
              <label for="message">Message</label>
              <textarea id="message" name="message" rows="5" required></textarea>
              <span class="fieldHint">Share any details or requests.</span>
            </div>
          </div>
          <div class="formActions">
            <div id="formMsg"></div>
            <button type="submit" class="btn-outline">Send Message</button>
            <p class="formNote">By sending, consent is given to be contacted about this request.</p>
          </div>
        </form>
      </div>
    </section>

    <footer id="siteFooter" class="footerSection">
      <div class="footerWrap">
        <div class="footerGrid">
          <div class="footerBrand">
            <h3 class="footerTitle">Taiyo</h3>
            <p class="footerText">Ramen and small plates — cooked low and slow, served fast.</p>
          </div>
          <div class="footerBlock">
            <h4 class="blockTitle">Visit</h4>
            <ul class="linkList">
              <li><span class="muted">Mon–Thu</span> 12:00–22:00</li>
              <li><span class="muted">Fri–Sat</span> 12:00–23:00</li>
              <li><span class="muted">Sun</span> 12:00–21:00</li>
              <li><a href="https://maps.google.com/?q=Your+Address" rel="noopener">123 Kana St, Amsterdam</a></li>
            </ul>
          </div>
          <div class="footerBlock">
            <h4 class="blockTitle">Contact</h4>
            <ul class="linkList">
              <li><a href="tel:+31123456789">+31 12 345 6789</a></li>
              <li><a href="mailto:hello@taiyo.nl">hello@taiyo.nl</a></li>
              <li><a href="./privacy.php">Privacy</a></li>
            </ul>
          </div>
          <div class="footerBlock">
            <h4 class="blockTitle">Follow</h4>
            <ul class="linkList">
              <li><a href="https://www.instagram.com" aria-label="Instagram">Instagram</a></li>
              <li><a href="https://www.tiktok.com" aria-label="TikTok">TikTok</a></li>
              <li><a href="https://www.facebook.com" aria-label="Facebook">Facebook</a></li>
            </ul>
          </div>
        </div>
        <div class="footerBottom">
          <p class="copyright">&copy; <span id="yearNow"></span> Taiyo. All rights reserved.</p>
        </div>
      </div>
    </footer>

    <div id="toastHost" aria-live="polite" aria-atomic="true"></div>
    <script>document.getElementById('yearNow').textContent = new Date().getFullYear();</script>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/fontfaceobserver/2.1.0/fontfaceobserver.standalone.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.13.0/gsap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
  <script src="script.js" defer></script>

  <script>
    document.querySelector('.contactForm').addEventListener('submit', async function (e) {
      e.preventDefault();

      const res = await fetch('contact/submit.php', {
        method: 'POST',
        body: new FormData(this)
      });

      const data = await res.json();
      const msg = document.getElementById('formMsg');

      if (data.ok) {
        msg.innerHTML = '<p style="color: green;">Message sent! We will be in touch soon.</p>';
        this.reset();
      } else {
        msg.innerHTML = '<p style="color: red;">Something went wrong, please try again.</p>';
      }
    });
  </script>

</body>

</html>