const config = window.SITE_CONFIG || {};

const applyText = (id, text) => {
  const el = document.getElementById(id);
  if (el && text !== undefined && text !== null) el.textContent = text;
};

const applyLink = (id, label, url) => {
  const el = document.getElementById(id);
  if (!el) return;
  if (label) el.textContent = label;
  if (url) el.href = url;
};

const setTheme = () => {
  const root = document.documentElement;
  if (config.brand?.primary) root.style.setProperty('--primary', config.brand.primary);
  if (config.brand?.accent) root.style.setProperty('--accent', config.brand.accent);
};

const buildInviteUrl = () => {
  const botId = config.discord?.bot_id;
  if (!botId) return '#';
  const params = new URLSearchParams({
    client_id: botId,
    scope: 'bot applications.commands',
    permissions: config.links?.invite_permissions || '8'
  });
  return `https://discord.com/oauth2/authorize?${params.toString()}`;
};

const botAvatarUrl = (user) => {
  if (!user || !user.id) return '';
  if (user.avatar) {
    return `https://cdn.discordapp.com/avatars/${user.id}/${user.avatar}.png?size=256`;
  }
  return 'https://cdn.discordapp.com/embed/avatars/0.png';
};

const fetchBotProfile = async () => {
  try {
    const res = await fetch('api/bot.php');
    if (!res.ok) return null;
    return await res.json();
  } catch {
    return null;
  }
};

const toggleBotError = (show) => {
  const errorEl = document.getElementById('botError');
  if (errorEl) errorEl.hidden = !show;
};

const fillStats = () => {
  const statsEl = document.getElementById('stats');
  if (!statsEl || !Array.isArray(config.stats)) return;
  statsEl.innerHTML = config.stats
    .map(
      (stat) => `
        <div class="stat-card">
          <div class="value">${stat.value}</div>
          <div class="label">${stat.label}</div>
        </div>
      `
    )
    .join('');
};

const fillHighlights = () => {
  const container = document.getElementById('highlights');
  if (!container || !Array.isArray(config.highlights)) return;
  container.innerHTML = config.highlights
    .map(
      (item) => `
        <div class="highlight-card">
          <i class="bi ${item.icon}"></i>
          <div>
            <div class="title">${item.title}</div>
            <div class="muted">${item.text}</div>
          </div>
        </div>
      `
    )
    .join('');
};

const fillFeatures = () => {
  const container = document.getElementById('featuresGrid');
  if (!container || !Array.isArray(config.features)) return;
  container.innerHTML = config.features
    .map(
      (item) => `
        <div class="feature-card">
          <i class="bi ${item.icon}"></i>
          <h3>${item.title}</h3>
          <p>${item.text}</p>
        </div>
      `
    )
    .join('');
};

const fillCommands = () => {
  const container = document.getElementById('commandsList');
  if (!container || !Array.isArray(config.commands)) return;
  container.innerHTML = config.commands
    .map(
      (cmd) => `
        <div class="command">
          <div class="command-icon"><i class="bi bi-terminal"></i></div>
          <div>
            <div class="command-title">${cmd.name}</div>
            <div class="muted">${cmd.description}</div>
          </div>
        </div>
      `
    )
    .join('');
};

const fillTestimonials = () => {
  const container = document.getElementById('testimonials');
  if (!container || !Array.isArray(config.testimonials)) return;
  container.innerHTML = config.testimonials
    .map(
      (item) => `
        <div class="review">
          <div class="review-quote">“${item.quote}”</div>
          <div class="review-meta">
            <div class="review-name">${item.name}</div>
            <div class="muted">${item.role}</div>
          </div>
        </div>
      `
    )
    .join('');
};

const fillFaq = () => {
  const container = document.getElementById('faqList');
  if (!container || !Array.isArray(config.faq)) return;
  container.innerHTML = config.faq
    .map(
      (item) => `
        <details class="faq-item">
          <summary>${item.question}</summary>
          <p>${item.answer}</p>
        </details>
      `
    )
    .join('');
};

const fillFooter = () => {
  const footerLinks = document.getElementById('footerLinks');
  if (footerLinks && Array.isArray(config.footer?.links)) {
    footerLinks.innerHTML = config.footer.links
      .map((link) => `<a href="${link.url}">${link.label}</a>`)
      .join('');
  }

  const socials = document.getElementById('socialLinks');
  if (socials && Array.isArray(config.footer?.socials)) {
    socials.innerHTML = config.footer.socials
      .map((link) => `<a href="${link.url}" aria-label="${link.icon}"><i class="bi ${link.icon}"></i></a>`)
      .join('');
  }
};

const setBrandFromBot = (botName, avatarUrl) => {
  applyText('brandName', botName);
  applyText('botName', botName);
  applyText('footerBrand', botName);

  const logoEl = document.getElementById('brandLogo');
  if (logoEl && avatarUrl) {
    logoEl.innerHTML = `<img src="${avatarUrl}" alt="${botName}">`;
  }

  const avatarEl = document.getElementById('botAvatar');
  if (avatarEl && avatarUrl) avatarEl.src = avatarUrl;

  if (botName) document.title = botName;

  const faviconEl = document.getElementById('siteFavicon');
  if (faviconEl && avatarUrl) faviconEl.href = avatarUrl;

  const heroTitle = document.getElementById('heroTitle');
  if (heroTitle) {
    const template = heroTitle.textContent || '';
    heroTitle.textContent = template.replace('{bot}', botName || '');
  }

  const ctaTitle = document.getElementById('ctaTitle');
  if (ctaTitle) {
    const template = ctaTitle.textContent || '';
    ctaTitle.textContent = template.replace('{bot}', botName || '');
  }
};

const applyBotProfile = (profile) => {
  if (!profile || profile.error) {
    toggleBotError(true);
    return;
  }
  toggleBotError(false);
  const botName = profile.global_name || profile.username || '';
  const avatar = botAvatarUrl(profile);
  setBrandFromBot(botName, avatar);
};

const init = async () => {
  setTheme();

  const inviteUrl = buildInviteUrl();
  applyLink('ctaInvite', config.hero?.cta_invite, inviteUrl);
  applyLink('ctaInviteBottom', config.hero?.cta_invite, inviteUrl);
  applyLink('navInvite', config.hero?.cta_invite, inviteUrl);
  applyLink('navSupport', config.hero?.cta_support, config.links?.support_url);
  applyLink('ctaSupport', config.hero?.cta_support, config.links?.support_url);

  fillStats();
  fillHighlights();
  fillFeatures();
  fillCommands();
  fillTestimonials();
  fillFaq();
  fillFooter();
  const profile = await fetchBotProfile();
  applyBotProfile(profile);
};

init();
