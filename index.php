<?php
function render_error($details) {
  $safe = htmlspecialchars($details, ENT_QUOTES);
  echo '<!doctype html><html lang="fr"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Erreur</title></head><body style="margin:0;font-family:Arial,sans-serif;background:#0d111a;color:#f2f4ff;display:grid;place-items:center;min-height:100vh;padding:24px;">' .
    '<div style="max-width:520px;width:100%;padding:24px;border-radius:16px;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);box-shadow:0 20px 50px rgba(5,8,18,0.4);text-align:left;">' .
    '<div style="display:flex;align-items:center;gap:12px;margin-bottom:10px;">' .
    '<div style="width:38px;height:38px;border-radius:12px;background:rgba(248,113,113,0.15);display:grid;place-items:center;color:#f87171;font-weight:700;">!</div>' .
    '<div style="font-weight:600;font-size:18px;">Une erreur est survenue</div>' .
    '</div>' .
    '<div style="color:#b4bdd9;font-size:14px;line-height:1.5;">' . $safe . '</div>' .
    '</div></body></html>';
  exit;
}

set_error_handler(function ($errno, $errstr, $errfile, $errline) {
  render_error($errstr . ' (' . $errfile . ':' . $errline . ')');
});

set_exception_handler(function ($e) {
  render_error($e->getMessage());
});

register_shutdown_function(function () {
  $err = error_get_last();
  if ($err && in_array($err['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR], true)) {
    render_error($err['message'] . ' (' . $err['file'] . ':' . $err['line'] . ')');
  }
});

$config = require __DIR__ . '/config.php';

function config_get($config, $path, $default = null) {
  $parts = explode('.', $path);
  $value = $config;
  foreach ($parts as $part) {
    if (!is_array($value) || !array_key_exists($part, $value)) {
      return $default;
    }
    $value = $value[$part];
  }
  return $value;
}

$botId = config_get($config, 'discord.bot_id', '');
$botToken = config_get($config, 'discord.bot_token', '');

if ($botId === '' || $botToken === '') {
  render_error('Configuration invalide : discord.bot_id ou discord.bot_token manquant.');
}

$description = config_get($config, 'site.description', 'Site pour votre bot Discord.');
$locale = config_get($config, 'site.locale', 'fr');

$heroTitle = config_get($config, 'hero.title', 'Gérez votre serveur avec {bot}');
$heroSubtitle = config_get($config, 'hero.subtitle', 'Des outils simples et efficaces pour votre communauté.');
$ctaInviteLabel = config_get($config, 'hero.cta_invite', 'Inviter le bot');
$ctaSupportLabel = config_get($config, 'hero.cta_support', 'Support');
$supportUrl = config_get($config, 'links.support_url', '#');

$footerCopy = config_get($config, 'footer.copyright', '© 2026');

$jsConfig = json_encode($config, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
<!doctype html>
<html lang="<?php echo htmlspecialchars($locale, ENT_QUOTES); ?>">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>
  <meta name="description" content="<?php echo htmlspecialchars($description, ENT_QUOTES); ?>">
  <link id="siteFavicon" rel="icon" href="">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
  <div class="bg-gradient"></div>
  <div class="bg-grid"></div>

  <header class="site-header">
    <nav class="navbar navbar-expand-lg">
      <div class="container">
        <a class="navbar-brand brand" href="#top">
          <div class="logo" id="brandLogo"></div>
          <div class="brand-name" id="brandName" style="color: white;"></div>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Menu">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
          <ul class="navbar-nav mx-auto">
            <li class="nav-item"><a class="nav-link" href="#features">Fonctionnalités</a></li>
            <li class="nav-item"><a class="nav-link" href="#commands">Commandes</a></li>
            <li class="nav-item"><a class="nav-link" href="#reviews">Avis</a></li>
            <li class="nav-item"><a class="nav-link" href="#faq">FAQ</a></li>
          </ul>
          <div class="d-flex gap-2">
            <a class="btn ghost small" id="navSupport" href="<?php echo htmlspecialchars($supportUrl, ENT_QUOTES); ?>"><?php echo htmlspecialchars($ctaSupportLabel, ENT_QUOTES); ?></a>
            <a class="btn primary small" id="navInvite" href="#"><?php echo htmlspecialchars($ctaInviteLabel, ENT_QUOTES); ?></a>
          </div>
        </div>
      </div>
    </nav>
  </header>

  <main id="top">
    <section class="hero">
      <div class="container hero-grid">
        <div class="hero-copy">
          <h1 id="heroTitle"><?php echo htmlspecialchars($heroTitle, ENT_QUOTES); ?></h1>
          <p id="heroSubtitle"><?php echo htmlspecialchars($heroSubtitle, ENT_QUOTES); ?></p>
          <div class="hero-actions">
            <a class="btn primary" id="ctaInvite" href="#"><?php echo htmlspecialchars($ctaInviteLabel, ENT_QUOTES); ?></a>
            <a class="btn ghost" id="ctaSupport" href="<?php echo htmlspecialchars($supportUrl, ENT_QUOTES); ?>"><?php echo htmlspecialchars($ctaSupportLabel, ENT_QUOTES); ?></a>
          </div>
          <div class="stat-row" id="stats"></div>
        </div>

        <div class="hero-card">
          <div class="bot-profile">
            <img id="botAvatar" src="" alt="Avatar du bot">
            <div>
              <div class="bot-name" id="botName"></div>
            </div>
          </div>
          <div class="bot-error" id="botError" hidden>
            Impossible de récupérer le bot. Vérifiez l’ID et le token dans `config.php`.
          </div>
          <div class="bot-highlights" id="highlights"></div>
        </div>
      </div>
    </section>

    <section class="section" id="features">
      <div class="container">
        <div class="section-head">
          <h2>Tout ce qu’il faut pour grandir</h2>
          <p>Des modules clairs et une expérience fluide sur mobile et desktop.</p>
        </div>
        <div class="grid features-grid" id="featuresGrid"></div>
      </div>
    </section>

    <section class="section alt" id="commands">
      <div class="container">
        <div class="section-head">
          <h2>Commandes utiles</h2>
          <p>Un aperçu clair pour expliquer ce que le bot sait faire.</p>
        </div>
        <div class="commands" id="commandsList"></div>
      </div>
    </section>

    <section class="section" id="reviews">
      <div class="container">
        <div class="section-head">
          <h2>Ils ont adopté le bot</h2>
          <p>Des retours courts et concrets, parfaits pour convertir.</p>
        </div>
        <div class="grid reviews-grid" id="testimonials"></div>
      </div>
    </section>

    <section class="section alt" id="faq">
      <div class="container">
        <div class="section-head">
          <h2>FAQ</h2>
          <p>Les questions les plus courantes.</p>
        </div>
        <div class="faq" id="faqList"></div>
      </div>
    </section>

    <section class="cta">
      <div class="container cta-inner">
        <div>
          <h2 id="ctaTitle">Prêt à ajouter {bot} ?</h2>
          <p>Ajoutez le dès maintenant sur votre serveur !</p>
        </div>
        <a class="btn primary" id="ctaInviteBottom" href="#"><?php echo htmlspecialchars($ctaInviteLabel, ENT_QUOTES); ?></a>
      </div>
    </section>
  </main>

  <footer class="site-footer">
    <div class="container footer-grid">
      <div>
        <div class="brand-name" id="footerBrand"></div>
        <p class="muted" id="footerCopy"><?php echo htmlspecialchars($footerCopy, ENT_QUOTES); ?></p>
      </div>
      <div class="footer-links" id="footerLinks"></div>
      <div class="footer-social" id="socialLinks"></div>
    </div>
  </footer>

  <script>
    window.SITE_CONFIG = <?php echo $jsConfig; ?>;
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/main.js"></script>
</body>
</html>
