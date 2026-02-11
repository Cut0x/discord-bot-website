<?php
return [
  'site' => [
    'description' => 'Description de votre bot.',
    'locale' => 'fr'
  ],
  'discord' => [
    'bot_id' => 'ID_DE_VOTRE_BOT_ICI',
    'bot_token' => 'TOKEN_DE_VOTRE_BOT_ICI'
  ],
  'links' => [
    'invite_permissions' => '8', // 8 = Admin, ajustez selon les permissions nécessaires
    'support_url' => 'https://discord.gg/exemple'
  ],
  'hero' => [
    'title' => 'Exemple de titre', // Utilisez {bot} pour insérer dynamiquement le nom du bot
    'subtitle' => 'Sous-titre d\'exemple.',
    'cta_invite' => 'Inviter le bot',
    'cta_support' => 'Support'
  ],
  'stats' => [
    ['label' => 'Serveurs', 'value' => '1 250+'],
    ['label' => 'Utilisateurs', 'value' => '480k'],
    ['label' => 'Commandes / jour', 'value' => '92k']
  ],
  'highlights' => [
    ['icon' => 'bi-shield-check', 'title' => 'Exemple', 'text' => 'Exemple de point fort.'],
  ],
  'features' => [
    ['icon' => 'bi-sliders', 'title' => 'Exemple', 'text' => 'Feature d\'exemple.'],
  ],
  'commands' => [
    ['name' => '/exemple', 'description' => 'Commande exemple'],
  ],
  'testimonials' => [
    ['name' => 'Cut0x', 'role' => 'Dev', 'quote' => 'Ceci est un exemple.'],
  ],
  'faq' => [
    ['question' => 'C\'est une question d\'exemple ?', 'answer' => 'Oui, en effet.'],
  ],
  'footer' => [
    'copyright' => '© 2026.',
    'links' => [
      ['label' => 'Conditions', 'url' => '#'],
    ],
    'socials' => [
      ['icon' => 'bi-github', 'url' => '#'],
    ]
  ]
];
