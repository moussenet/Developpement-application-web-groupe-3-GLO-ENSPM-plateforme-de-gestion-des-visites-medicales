<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= esc($title) ?></title>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: system-ui, sans-serif; background: #f0f2f5; min-height: 100vh; }
    .navbar { background: #0F6E56; padding: 0 24px; height: 54px;
              display: flex; align-items: center; justify-content: space-between; }
    .navbar .brand { display: flex; align-items: center; gap: 10px; }
    .navbar .brand img { width: 32px; height: 32px; border-radius: 50%;
                         object-fit: contain; background: #fff; padding: 2px; }
    .navbar .brand span { font-size: 15px; font-weight: 700; color: #fff; }
    .navbar .brand span em { color: #a8f0d8; font-style: normal; }
    .navbar .user { font-size: 13px; color: rgba(255,255,255,0.85);
                    display: flex; align-items: center; gap: 16px; }
    .navbar .user a { color: rgba(255,255,255,0.7); text-decoration: none; font-size: 12px; }
    .layout { display: flex; min-height: calc(100vh - 54px); }
    .sidebar { width: 220px; background: #fff; border-right: 1px solid #e8e8e8;
               padding: 20px 0; flex-shrink: 0; }
    .sidebar .section { font-size: 10px; font-weight: 700; color: #bbb;
                        text-transform: uppercase; letter-spacing: .5px;
                        padding: 14px 20px 6px; }
    .sidebar a { display: flex; align-items: center; gap: 10px; padding: 10px 20px;
                 font-size: 13px; color: #555; text-decoration: none; transition: background .15s; }
    .sidebar a:hover { background: #f0f2f5; color: #0F6E56; }
    .sidebar a.active { background: #E1F5EE; color: #0F6E56;
                        font-weight: 600; border-right: 3px solid #0F6E56; }
    .content { flex: 1; padding: 28px 24px; }
    .page-header { margin-bottom: 24px; }
    .page-title { font-size: 20px; font-weight: 700; color: #1a1917; }
    .page-sub { font-size: 13px; color: #888; margin-top: 3px; }
    .alert { padding: 11px 14px; border-radius: 8px; font-size: 13px; margin-bottom: 20px; }
    .alert-success { background: #E1F5EE; color: #085041; border-left: 3px solid #0F6E56; }
    .alert-error   { background: #FCEBEB; color: #A32D2D; border-left: 3px solid #A32D2D; }
    .alert-info    { background: #E6F1FB; color: #0C447C; border-left: 3px solid #185FA5; }
    .periodes-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
                     gap: 16px; }
    .periode-card { background: #fff; border-radius: 12px; padding: 20px;
                    box-shadow: 0 1px 4px rgba(0,0,0,.07);
                    border: 1.5px solid transparent; transition: all .15s; }
    .periode-card:hover { border-color: #0F6E56;
                          box-shadow: 0 4px 14px rgba(15,110,86,.1); }
    .periode-top { display: flex; align-items: flex-start;
                   justify-content: space-between; margin-bottom: 12px; }
    .periode-titre { font-size: 15px; font-weight: 700; color: #1a1917; }
    .badge { display: inline-block; padding: 3px 9px; border-radius: 4px;
             font-size: 11px; font-weight: 600; }
    .badge-active { background: #E1F5EE; color: #085041; }
    .periode-info { display: flex; flex-direction: column; gap: 6px; margin-bottom: 14px; }
    .periode-info-item { display: flex; align-items: center; gap: 8px;
                         font-size: 13px; color: #555; }
    .periode-info-item span { color: #aaa; font-size: 14px; }
    .periode-places { display: flex; align-items: center; gap: 8px;
                      margin-bottom: 14px; }
    .places-bar { flex: 1; height: 6px; background: #f0f0f0;
                  border-radius: 4px; overflow: hidden; }
    .places-fill { height: 100%; border-radius: 4px; background: #0F6E56; }
    .places-fill.medium { background: #BA7517; }
    .places-fill.full   { background: #A32D2D; }
    .places-text { font-size: 12px; color: #888; min-width: 80px; text-align: right; }
    .btn { padding: 9px 16px; border-radius: 8px; border: none; cursor: pointer;
           font-size: 13px; font-weight: 500; text-decoration: none;
           display: inline-flex; align-items: center; gap: 6px;
           transition: background .15s; }
    .btn-primary { background: #0F6E56; color: #fff; width: 100%;
                   justify-content: center; }
    .btn-primary:hover { background: #1D9E75; }
    .btn-disabled { background: #f0f0f0; color: #aaa; width: 100%;
                    justify-content: center; cursor: not-allowed; }
    .empty { text-align: center; padding: 60px; color: #aaa; }
    .empty p { margin-top: 8px; font-size: 13px; }
  </style>
</head>
<body>

<div class="navbar">
  <div class="brand">
    <img src="<?= base_url('img/logo.jpg') ?>" alt="ENSPM">
    <span>Centre Médico-Sanitaire <em>ENSPM</em></span>
  </div>
  <div class="user">
    <span>👤 <?= esc(session()->get('user_nom')) ?></span>
    <a href="<?= base_url('logout') ?>">Déconnexion</a>
  </div>
</div>

<div class="layout">
  <div class="sidebar">
    <div class="section">Mon espace</div>
    <a href="<?= base_url('etudiant/dashboard') ?>"> Tableau de bord</a>
    <a href="<?= base_url('etudiant/periodes') ?>" class="active"> Périodes de visite</a>
    <a href="<?= base_url('etudiant/rendezvous') ?>"> Mes rendez-vous</a>
    <a href="<?= base_url('etudiant/notifications') ?>"> Notifications</a>
    <a href="<?= base_url('etudiant/resultats') ?>"> Mes résultats</a>
    <div class="section">Compte</div>
    <a href="<?= base_url('logout') ?>"> Déconnexion</a>
  </div>

  <div class="content">
    <div class="page-header">
      <div class="page-title">Périodes de visite médicale</div>
      <div class="page-sub">
        <?php if ($departement): ?>
          Résultats pour votre département :
          <strong><?= esc($departement) ?></strong>
        <?php else: ?>
          Toutes les périodes disponibles
        <?php endif; ?>
      </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-error"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <?php if (empty($periodes)): ?>
      <div class="empty">
        <p>Aucune période de visite disponible pour votre département.</p>
        <p style="margin-top:6px">Revenez plus tard ou contactez l'administration.</p>
      </div>
    <?php else: ?>
      <div class="periodes-grid">
        <?php foreach ($periodes as $p):
          $totalPlaces = 0;
          $prises      = 0;
        ?>
          <div class="periode-card">
            <div class="periode-top">
              <div class="periode-titre"><?= esc($p['titre']) ?></div>
              <span class="badge badge-active">Active</span>
            </div>

            <div class="periode-info">
              <div class="periode-info-item">
                <?= esc($p['departement']) ?>
              </div>
              <div class="periode-info-item">
                Du <?= date('d/m/Y', strtotime($p['date_debut'])) ?>
                au <?= date('d/m/Y', strtotime($p['date_fin'])) ?>
              </div>
              <div class="periode-info-item">
                <span>🩺</span>
                Dr. <?= esc($p['medecin_nom']) ?>
              </div>
              <div class="periode-info-item">
                <?= $p['duree_consultation'] ?> min par consultation
              </div>
            </div>

            <a href="<?= base_url('etudiant/periodes/' . $p['id']) ?>"
               class="btn btn-primary">
              Voir les créneaux disponibles →
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</div>

</body>
</html>