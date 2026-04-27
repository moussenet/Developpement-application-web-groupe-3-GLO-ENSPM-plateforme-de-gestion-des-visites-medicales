<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title><?= esc($title) ?></title>
  <style>
    body { font-family: system-ui, sans-serif; background: #f0f2f5;
           display: flex; align-items: center; justify-content: center; min-height: 100vh; }
    .card { background: #fff; border-radius: 12px; padding: 40px; text-align: center;
            box-shadow: 0 2px 12px rgba(0,0,0,.08); }
    .logo { font-size: 22px; font-weight: 700; color: #0F6E56; margin-bottom: 12px; }
    .role { display: inline-block; background: #E1F5EE; color: #085041;
            padding: 4px 12px; border-radius: 4px; font-size: 13px; margin-bottom: 20px; }
    a { color: #0F6E56; font-size: 13px; }
  </style>
</head>
<body>
  <div class="card">
    <div class="logo">Centre Medico-Sanitaire - ENSPM</div>
    <div class="role">Médécin</div>
    <p>Bienvenue, <strong><?= esc($user_nom) ?></strong></p>
    <br>
    <a href="<?= base_url('/logout') ?>">Se déconnecter</a>
  </div>
</body>
</html>