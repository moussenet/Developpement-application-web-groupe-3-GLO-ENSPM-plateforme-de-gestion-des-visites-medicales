<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= esc($title) ?></title>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: system-ui, sans-serif; background: #f0f2f5; min-height: 100vh; }

    /* NAVBAR */
    .navbar { background: #0F6E56; padding: 0 24px; height: 54px;
              display: flex; align-items: center; justify-content: space-between; }
    .navbar .brand { display: flex; align-items: center; gap: 10px; }
    .navbar .brand img { width: 32px; height: 32px; border-radius: 50%;
                         border: 2px solid rgba(255,255,255,0.3); object-fit: contain;
                         background: #fff; padding: 2px; }
    .navbar .brand span { font-size: 16px; font-weight: 700; color: #fff; }
    .navbar .brand span em { color: #a8f0d8; font-style: normal; }
    .navbar .user { font-size: 13px; color: rgba(255,255,255,0.85);
                    display: flex; align-items: center; gap: 16px; }
    .navbar .user a { color: rgba(255,255,255,0.7); text-decoration: none; font-size: 12px; }
    .navbar .user a:hover { color: #fff; }

    /* LAYOUT */
    .layout { display: flex; min-height: calc(100vh - 54px); }

    /* SIDEBAR */
    .sidebar { width: 220px; background: #fff; border-right: 1px solid #e8e8e8;
               padding: 20px 0; flex-shrink: 0; }
    .sidebar .section { font-size: 10px; font-weight: 700; color: #bbb;
                        text-transform: uppercase; letter-spacing: .5px;
                        padding: 14px 20px 6px; }
    .sidebar a { display: flex; align-items: center; gap: 10px; padding: 10px 20px;
                 font-size: 13px; color: #555; text-decoration: none;
                 transition: background .15s; }
    .sidebar a:hover { background: #f0f2f5; color: #0F6E56; }
    .sidebar a.active { background: #E1F5EE; color: #0F6E56; font-weight: 600;
                        border-right: 3px solid #0F6E56; }

    /* CONTENU */
    .content { flex: 1; padding: 28px 24px; }

    .welcome { margin-bottom: 24px; }
    .welcome h1 { font-size: 20px; font-weight: 700; color: #1a1917; }
    .welcome p { font-size: 13px; color: #888; margin-top: 3px; }

    /* STATS */
    .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px;
                  margin-bottom: 24px; }
    .stat-card { background: #fff; border-radius: 10px; padding: 18px 16px;
                 box-shadow: 0 1px 4px rgba(0,0,0,.07); }
    .stat-icon { width: 38px; height: 38px; border-radius: 9px;
                 display: flex; align-items: center; justify-content: center;
                 font-size: 18px; margin-bottom: 10px; }
    .stat-num { font-size: 26px; font-weight: 700; color: #1a1917; }
    .stat-label { font-size: 12px; color: #888; margin-top: 2px; }

    /* ACTIONS RAPIDES */
    .section-title { font-size: 15px; font-weight: 700; color: #1a1917;
                     margin-bottom: 14px; }
    .actions-grid { display: grid; grid-template-columns: repeat(3, 1fr);
                    gap: 12px; margin-bottom: 24px; }
    .action-card { background: #fff; border-radius: 10px; padding: 18px;
                   box-shadow: 0 1px 4px rgba(0,0,0,.07); text-decoration: none;
                   display: flex; align-items: center; gap: 14px;
                   transition: box-shadow .15s, transform .15s; }
    .action-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,.1); transform: translateY(-1px); }
    .action-icon { width: 44px; height: 44px; border-radius: 10px;
                   display: flex; align-items: center; justify-content: center;
                   font-size: 20px; flex-shrink: 0; }
    .action-text strong { display: block; font-size: 13px; font-weight: 600;
                          color: #1a1917; margin-bottom: 2px; }
    .action-text span { font-size: 12px; color: #888; }

    /* DERNIÈRES PÉRIODES */
    .grid2 { display: grid; grid-template-columns: 2fr 1fr; gap: 14px; }
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
    .badge-active   { background: #E1F5EE; color: #085041; }
    .badge-terminee { background: #f0f0f0; color: #888; }
    .badge-annulee  { background: #FCEBEB; color: #A32D2D; }
    .empty-row td { text-align: center; padding: 28px; color: #aaa; font-size: 13px; }

    /* ACTIVITÉ RÉCENTE */
    .activity { padding: 14px 18px; }
    .activity-item { display: flex; align-items: flex-start; gap: 10px;
                     padding: 10px 0; border-bottom: 1px solid #f5f5f5; }
    .activity-item:last-child { border-bottom: none; }
    .activity-dot { width: 8px; height: 8px; border-radius: 50%;
                    margin-top: 4px; flex-shrink: 0; }
    .activity-text { font-size: 13px; color: #555; line-height: 1.4; }
    .activity-time { font-size: 11px; color: #aaa; margin-top: 2px; }
  </style>
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
  <div class="brand">
    <img src="<?= base_url('img/logo.jpg') ?>" alt="ENSPM">
    <span>Centre Médico-Sanitaire <em>ENSPM</em></span>
  </div>
  <div class="user">
    <span>👤 <?= esc(session()->get('user_nom')) ?></span>
    <span style="background:rgba(255,255,255,0.15);padding:3px 9px;border-radius:4px;font-size:11px">
      Administrateur
    </span>
    <a href="<?= base_url('logout') ?>">Déconnexion</a>
  </div>
</div>

<div class="layout">

  <!-- SIDEBAR -->
  <div class="sidebar">
    <div class="section">Menu principal</div>
    <a href="<?= base_url('admin/dashboard') ?>" class="active"> Tableau de bord</a>
    <a href="<?= base_url('admin/periodes') ?>"> Périodes de visite</a>
    <a href="<?= base_url('admin/users') ?>"> Utilisateurs</a>
    <div class="section">Compte</div>
    <a href="<?= base_url('logout') ?>"> Déconnexion</a>
  </div>

  <!-- CONTENU -->
  <div class="content">

    <div class="welcome">
      <h1>Bonjour, <?= esc(session()->get('user_nom')) ?> </h1>
      <p>Tableau de bord — <?= date('l d F Y') ?></p>
    </div>

    <!-- STATISTIQUES -->
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-num"><?= $nb_periodes ?></div>
        <div class="stat-label">Périodes de visite</div>
      </div>
      <div class="stat-card">
        <div class="stat-num"><?= $nb_etudiants ?></div>
        <div class="stat-label">Étudiants inscrits</div>
      </div>
      <div class="stat-card">
        <div class="stat-num"><?= $nb_medecins ?></div>
        <div class="stat-label">Personnel médical</div>
      </div>
      <div class="stat-card">
        <div class="stat-num"><?= $nb_rendezvous ?></div>
        <div class="stat-label">Rendez-vous confirmés</div>
      </div>
    </div>

    <!-- ACTIONS RAPIDES -->
    <div class="section-title">Actions rapides</div>
    <div class="actions-grid">
      <a href="<?= base_url('admin/periodes/create') ?>" class="action-card">
        <div class="action-text">
          <strong>Nouvelle période</strong>
          <span>Programmer une campagne de visites</span>
        </div>
      </a>
      <a href="<?= base_url('admin/users/create') ?>" class="action-card">
        <div class="action-text">
          <strong>Créer un compte</strong>
          <span>Ajouter médecin ou administrateur</span>
        </div>
      </a>
      <a href="<?= base_url('admin/periodes') ?>" class="action-card">
        <div class="action-text">
          <strong>Voir les périodes</strong>
          <span>Gérer les campagnes en cours</span>
        </div>
      </a>
    </div>

    <!-- TABLEAU + ACTIVITÉ -->
    <div class="grid2">

      <!-- Dernières périodes -->
      <div class="card">
        <div class="card-header">
          <span>Dernières périodes de visite</span>
          <a href="<?= base_url('admin/periodes') ?>">Voir tout →</a>
        </div>
        <table>
          <thead>
            <tr>
              <th>Titre</th>
              <th>Département</th>
              <th>Dates</th>
              <th>Statut</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($dernieres_periodes)): ?>
              <tr class="empty-row">
                <td colspan="4">Aucune période créée pour le moment</td>
              </tr>
            <?php else: ?>
              <?php foreach ($dernieres_periodes as $p): ?>
                <tr>
                  <td><strong><?= esc($p['titre']) ?></strong></td>
                  <td><?= esc(explode('(', $p['departement'])[0]) ?></td>
                  <td style="font-size:12px">
                    <?= date('d/m/Y', strtotime($p['date_debut'])) ?>
                    → <?= date('d/m/Y', strtotime($p['date_fin'])) ?>
                  </td>
                  <td>
                    <span class="badge badge-<?= $p['statut'] ?>">
                      <?= $p['statut'] === 'active' ? 'Active' :
                         ($p['statut'] === 'terminee' ? 'Terminée' : 'Annulée') ?>
                    </span>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <!-- Résumé rapide -->
      <div class="card">
        <div class="card-header">
          <span>Résumé</span>
        </div>
        <div class="activity">
          <div class="activity-item">
            <div class="activity-dot" style="background:#0F6E56"></div>
            <div>
              <div class="activity-text">
                <strong><?= $nb_periodes_actives ?></strong> période(s) active(s) en cours
              </div>
            </div>
          </div>
          <div class="activity-item">
            <div class="activity-dot" style="background:#185FA5"></div>
            <div>
              <div class="activity-text">
                <strong><?= $nb_etudiants ?></strong> étudiant(s) inscrit(s)
              </div>
            </div>
          </div>
          <div class="activity-item">
            <div class="activity-dot" style="background:#534AB7"></div>
            <div>
              <div class="activity-text">
                <strong><?= $nb_medecins ?></strong> médecin(s) disponible(s)
              </div>
            </div>
          </div>
          <div class="activity-item">
            <div class="activity-dot" style="background:#BA7517"></div>
            <div>
              <div class="activity-text">
                <strong><?= $nb_rendezvous ?></strong> rendez-vous au total
              </div>
            </div>
          </div>
          <div class="activity-item">
            <div class="activity-dot" style="background:#A32D2D"></div>
            <div>
              <div class="activity-text">
                <strong><?= $nb_urgents ?></strong> cas urgent(s) signalé(s)
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

</body>
</html>