<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title><?= esc($title) ?></title>
  <style>
    body { font-family: system-ui, sans-serif; background: #f0f2f5;
           display: flex; align-items: center; justify-content: center; min-height: 100vh; }
    .card { background: #fff; border-radius: 12px; padding: 40px; text-align: center;
            box-shadow: 0 2px 12px rgba(0,0,0,.08); max-width: 400px; }
    a { color: #0F6E56; font-size: 13px; }
  </style>
</head>
<body>
  <div class="card">
    <div style="font-size:40px;margin-bottom:16px"></div>
    <h2 style="margin-bottom:8px">Notifications</h2>
    <p style="color:#888;font-size:13px;margin-bottom:20px">
      Fonctionnalité en cours de développement.
    </p>
    <a href="<?= base_url('etudiant/dashboard') ?>">← Retour au tableau de bord</a>
  </div>
</body>
</html>