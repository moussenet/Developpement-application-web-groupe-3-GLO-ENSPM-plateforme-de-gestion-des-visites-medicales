<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= esc($title) ?></title>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: system-ui, sans-serif; background: #f0f2f5; min-height: 100vh; }
    .navbar { background: #1a1917; padding: 0 24px; height: 54px;
              display: flex; align-items: center; justify-content: space-between; }
    .navbar .brand { display: flex; align-items: center; gap: 10px; }
    .navbar .brand img { width: 32px; height: 32px; border-radius: 50%;
                         border: 2px solid rgba(255,255,255,0.2);
                         object-fit: contain; background: #fff; padding: 2px; }
    .navbar .brand span { font-size: 15px; font-weight: 700; color: #fff; }
    .navbar .brand span em { color: #a8f0d8; font-style: normal; }
    .navbar .user { font-size: 13px; color: rgba(255,255,255,0.7);
                    display: flex; align-items: center; gap: 16px; }
    .navbar .user a { color: rgba(255,255,255,0.5); text-decoration: none; font-size: 12px; }
    .navbar .user a:hover { color: #fff; }
    .layout { display: flex; min-height: calc(100vh - 54px); }
    .sidebar { width: 230px; background: #fff; border-right: 1px solid #e8e8e8;
               padding: 20px 0; flex-shrink: 0; }
    .sidebar .section { font-size: 10px; font-weight: 700; color: #bbb;
                        text-transform: uppercase; letter-spacing: .5px;
                        padding: 14px 20px 6px; }
    .sidebar a { display: flex; align-items: center; gap: 10px; padding: 10px 20px;
                 font-size: 13px; color: #555; text-decoration: none; transition: background .15s; }
    .sidebar a:hover { background: #f0f2f5; color: #1a1917; }
    .sidebar a.active { background: #f0f0ee; color: #1a1917;
                        font-weight: 600; border-right: 3px solid #1a1917; }
    .content { flex: 1; padding: 28px 24px; }
    .welcome { margin-bottom: 24px; }
    .welcome h1 { font-size: 20px; font-weight: 700; color: #1a1917; }
    .welcome p  { font-size: 13px; color: #888; margin-top: 3px; }
    .superadmin-badge { display: inline-block; background: #1a1917; color: #a8f0d8;
                        font-size: 11px; font-weight: 600; padding: 3px 10px;
                        border-radius: 4px; margin-left: 8px; vertical-align: middle; }
    .stats-grid { display: grid; grid-template-columns: repeat(5, 1fr);
                  gap: 12px; margin-bottom: 24px; }
    .stat-card { background: #fff; border-radius: 10px; padding: 16px;
                 box-shadow: 0 1px 4px rgba(0,0,0,.07); }
    .stat-icon { width: 36px; height: 36px; border-radius: 8px;
                 display: flex; align-items: center; justify-content: center;
                 font-size: 17px; margin-bottom: 8px; }
    .stat-num   { font-size: 26px; font-weight: 700; color: #1a1917; }
    .stat-label { font-size: 12px; color: #888; margin-top: 2px; }
    .section-title { font-size: 15px; font-weight: 700; color: #1a1917; margin-bottom: 14px; }
    .actions-grid { display: grid; grid-template-columns: repeat(3, 1fr);
                    gap: 12px; margin-bottom: 24px; }
    .action-card { background: #fff; border-radius: 12px; padding: 20px;
                   box-shadow: 0 1px 4px rgba(0,0,0,.07); text-decoration: none;
                   display: flex; align-items: center; gap: 14px;
                   transition: box-shadow .15s, transform .15s;
                   border: 1.5px solid #eee; }
    .action-card:hover { box-shadow: 0 4px 14px rgba(0,0,0,.1); transform: translateY(-2px); }
    .action-icon { width: 46px; height: 46px; border-radius: 10px;
                   display: flex; align-items: center; justify-content: center;
                   font-size: 22px; flex-shrink: 0; }
    .action-text strong { display: block; font-size: 13px; font-weight: 600;
                          color: #1a1917; margin-bottom: 2px; }
    .action-text span { font-size: 12px; color: #888; }
    .card { background: #fff; border-radius: 10px;
            box-shadow: 0 1px 4px rgba(0,0,0,.07); overflow: hidden; }
    .card-header { padding: 14px 18px; border-bottom: 1px solid #f0f0f0;
                   display: flex; align-items: center; justify-content: space-between; }
    .card-header span { font-size: 14px; font-weight: 600; color: #1a1917; }
    .card-header a { font-size: 12px; color: #0F6E56; text-decoration: none; }
    table { width: 100%; border-collapse: collapse; }
    thead th { background: #f8f9fa; padding: 10px 16px; text-align: left;
               font-size: 11px; font-weight: 600; color: #888;
               text-transform: uppercase; letter-spacing: .4px;
               border-bottom: 1px solid #eee; }
    tbody td { padding: 11px 16px; font-size: 13px; color: #333;
               border-bottom: 1px solid #f5f5f5; }
    tbody tr:last-child td { border-bottom: none; }
    tbody tr:hover td { background: #fafafa; }
    .badge { display: inline-block; padding: 3px 8px; border-radius: 4px;
             font-size: 11px; font-weight: 600; }
    .badge-admin   { background: #EEEDFE; color: #3C3489; }
    .badge-medecin { background: #E1F5EE; color: #085041; }
    .badge-actif   { background: #E1F5EE; color: #085041; }
    .badge-inactif { background: #FCEBEB; color: #A32D2D; }
    .empty-row td  { text-align: center; padding: 28px; color: #aaa; font-size: 13px; }
    .alert-success { background: #E1F5EE; color: #085041; border-left: 3px solid #0F6E56;
                     padding: 11px 14px; border-radius: 8px; font-size: 13px; margin-bottom: 20px; }
  </style>
</head>
<body>

<div class="navbar">
  <div class="brand">
    <img src="<?= base_url('img/logo.jpg') ?>" alt="ENSPM">
    <span>Centre Médico-Sanitaire <em>ENSPM</em></span>
  </div>
  <div class="user">
    <span style="background:rgba(255,255,255,0.1);padding:3px 9px;
                 border-radius:4px;font-size:11px;color:#a8f0d8">
      Super Admin
    </span>
    <a href="<?= base_url('logout') ?>">Déconnexion</a>
  </div>
</div>

<div class="layout">
  <div class="sidebar">
    <div class="section">Super Administration</div>
    <a href="<?= base_url('superadmin/dashboard') ?>" class="active"> Tableau de bord</a>
    <a href="<?= base_url('superadmin/users') ?>"> Comptes admin & médecins</a>
    <div class="section">Compte</div>
    <a href="<?= base_url('logout') ?>"> Déconnexion</a>
  </div>

  <div class="content">

    <div class="welcome">
      <h1>
        Bonjour,
        <span class="superadmin-badge">SUPER ADMIN</span>
      </h1>
      <p>Tableau de bord principal — <?= date('d F Y') ?></p>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>

    <!-- STATS -->
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-num"><?= $nb_admins ?></div>
        <div class="stat-label">Administrateurs</div>
      </div>
      <div class="stat-card">
        <div class="stat-num"><?= $nb_medecins ?></div>
        <div class="stat-label">Personnel médical</div>
      </div>
      <div class="stat-card">
        <div class="stat-num"><?= $nb_etudiants ?></div>
        <div class="stat-label">Étudiants inscrits</div>
      </div>
      <div class="stat-card">
        <div class="stat-num"><?= $nb_periodes ?></div>
        <div class="stat-label">Périodes de visite</div>
      </div>
      <div class="stat-card">
        <div class="stat-num"><?= $nb_rdv ?></div>
        <div class="stat-label">Rendez-vous total</div>
      </div>
    </div>

    <!-- ACTIONS RAPIDES -->
    <div class="section-title">Actions rapides</div>
    <div class="actions-grid">
      <a href="<?= base_url('superadmin/users/create') ?>" class="action-card">
        <div class="action-text">
          <strong>Créer un administrateur</strong>
          <span>Compte vérifié par la direction</span>
        </div>
      </a>
      <a href="<?= base_url('superadmin/users/create') ?>" class="action-card">
        <div class="action-text">
          <strong>Créer un personnel médical</strong>
          <span>Avec numéro d'ordre médical</span>
        </div>
      </a>
      <a href="<?= base_url('superadmin/users') ?>" class="action-card">
        <div class="action-text">
          <strong>Gérer les comptes</strong>
          <span>Activer, désactiver, supprimer</span>
        </div>
      </a>
    </div>

    <!-- DERNIERS COMPTES CRÉÉS -->
    <div class="card">
      <div class="card-header">
        <span>Derniers comptes créés</span>
        <a href="<?= base_url('superadmin/users') ?>">Voir tout →</a>
      </div>
      <table>
        <thead>
          <tr>
            <th>Nom</th>
            <th>Email</th>
            <th>Rôle</th>
            <th>Identifiant</th>
            <th>Statut</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($derniers_users)): ?>
            <tr class="empty-row">
              <td colspan="5">Aucun compte créé pour le moment</td>
            </tr>
          <?php else: ?>
            <?php foreach ($derniers_users as $u): ?>
              <tr>
                <td><strong><?= esc($u['nom']) ?> <?= esc($u['prenom']) ?></strong></td>
                <td><?= esc($u['email']) ?></td>
                <td>
                  <span class="badge badge-<?= $u['role_id'] == 2 ? 'admin' : 'medecin' ?>">
                    <?= esc($u['role_label']) ?>
                  </span>
                </td>
                <td>
                  <?php if ($u['role_id'] == 2): ?>
                    <span style="font-size:12px;color:#555">
                      ID: <?= esc($u['id_direction'] ?? '—') ?>
                    </span>
                  <?php else: ?>
                    <span style="font-size:12px;color:#555">
                      N° <?= esc($u['numero_ordre_medical'] ?? '—') ?>
                    </span>
                  <?php endif; ?>
                </td>
                <td>
                  <span class="badge badge-<?= $u['actif'] ? 'actif' : 'inactif' ?>">
                    <?= $u['actif'] ? 'Actif' : 'Inactif' ?>
                  </span>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

  </div>
</div>

</body>
</html>