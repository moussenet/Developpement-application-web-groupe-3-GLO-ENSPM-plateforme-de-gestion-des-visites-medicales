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
                         border: 2px solid rgba(255,255,255,0.3);
                         object-fit: contain; background: #fff; padding: 2px; }
    .navbar .brand span { font-size: 15px; font-weight: 700; color: #fff; }
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
    .sidebar a.active { background: #E1F5EE; color: #0F6E56;
                        font-weight: 600; border-right: 3px solid #0F6E56; }

    /* CONTENU */
    .content { flex: 1; padding: 28px 24px; }
    .welcome { margin-bottom: 24px; }
    .welcome h1 { font-size: 20px; font-weight: 700; color: #1a1917; }
    .welcome p  { font-size: 13px; color: #888; margin-top: 3px; }

    /* PROCHAIN RDV */
    .rdv-banner { background: linear-gradient(135deg, #0F6E56, #1D9E75);
                  border-radius: 12px; padding: 20px 24px; margin-bottom: 24px;
                  display: flex; align-items: center; justify-content: space-between;
                  color: #fff; }
    .rdv-banner .rdv-info strong { font-size: 16px; display: block; margin-bottom: 4px; }
    .rdv-banner .rdv-info span { font-size: 13px; opacity: .85; }
    .rdv-banner .rdv-badge { background: rgba(255,255,255,0.2);
                              padding: 8px 16px; border-radius: 8px;
                              font-size: 13px; font-weight: 600; }
    .rdv-banner-empty { background: #fff; border: 2px dashed #e0e0e0;
                        border-radius: 12px; padding: 20px 24px;
                        margin-bottom: 24px; text-align: center; color: #aaa;
                        font-size: 13px; }
    .rdv-banner-empty a { color: #0F6E56; font-weight: 600; text-decoration: none; }

    /* STATS */
    .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr);
                  gap: 12px; margin-bottom: 24px; }
    .stat-card { background: #fff; border-radius: 10px; padding: 16px;
                 box-shadow: 0 1px 4px rgba(0,0,0,.07); }
    .stat-icon { width: 36px; height: 36px; border-radius: 8px;
                 display: flex; align-items: center; justify-content: center;
                 font-size: 17px; margin-bottom: 8px; }
    .stat-num   { font-size: 24px; font-weight: 700; color: #1a1917; }
    .stat-label { font-size: 12px; color: #888; margin-top: 2px; }

    /* FONCTIONNALITÉS */
    .section-title { font-size: 15px; font-weight: 700; color: #1a1917; margin-bottom: 14px; }
    .features-grid { display: grid; grid-template-columns: repeat(2, 1fr);
                     gap: 14px; margin-bottom: 24px; }
    .feature-card { background: #fff; border-radius: 12px; padding: 22px;
                    box-shadow: 0 1px 4px rgba(0,0,0,.07); text-decoration: none;
                    display: flex; flex-direction: column; gap: 10px;
                    transition: box-shadow .15s, transform .15s;
                    border: 1.5px solid transparent; }
    .feature-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,.1);
                           transform: translateY(-2px); }
    .feature-card.teal  { border-color: #0F6E56; }
    .feature-card.blue  { border-color: #185FA5; }
    .feature-card.amber { border-color: #BA7517; }
    .feature-card.green { border-color: #3B6D11; }
    .feature-top { display: flex; align-items: center; gap: 12px; }
    .feature-icon { width: 46px; height: 46px; border-radius: 11px;
                    display: flex; align-items: center; justify-content: center;
                    font-size: 22px; flex-shrink: 0; }
    .feature-title { font-size: 14px; font-weight: 700; color: #1a1917; }
    .feature-desc  { font-size: 12px; color: #888; line-height: 1.5; }
    .feature-cta   { font-size: 12px; font-weight: 600; display: inline-flex;
                     align-items: center; gap: 4px; }
    .cta-teal  { color: #0F6E56; }
    .cta-blue  { color: #185FA5; }
    .cta-amber { color: #BA7517; }
    .cta-green { color: #3B6D11; }

    /* MES RDV */
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
    .badge { display: inline-block; padding: 3px 8px; border-radius: 4px;
             font-size: 11px; font-weight: 600; }
    .badge-confirme { background: #E1F5EE; color: #085041; }
    .badge-present  { background: #E6F1FB; color: #0C447C; }
    .badge-annule   { background: #FCEBEB; color: #A32D2D; }
    .badge-absent   { background: #f0f0f0; color: #888; }
    .empty-row td   { text-align: center; padding: 28px; color: #aaa; font-size: 13px; }
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
    <span style="background:rgba(255,255,255,0.15);padding:3px 9px;
                 border-radius:4px;font-size:11px">Étudiant</span>
    <a href="<?= base_url('logout') ?>">Déconnexion</a>
  </div>
</div>

<div class="layout">

  <!-- SIDEBAR -->
  <div class="sidebar">
    <div class="section">Mon espace</div>
    <a href="<?= base_url('etudiant/dashboard') ?>" class="active"> Tableau de bord</a>
    <a href="<?= base_url('etudiant/periodes') ?>"> Périodes de visite</a>
    <a href="<?= base_url('etudiant/rendezvous') ?>"> Mes rendez-vous</a>
    <a href="<?= base_url('etudiant/notifications') ?>"> Notifications</a>
    <a href="<?= base_url('etudiant/resultats') ?>"> Mes résultats</a>
    <div class="section">Compte</div>
    <a href="<?= base_url('logout') ?>"> Déconnexion</a>
  </div>

  <!-- CONTENU -->
  <div class="content">

    <div class="welcome">
      <h1>Bonjour, <?= esc(session()->get('user_nom')) ?> </h1>
      <p>Bienvenue sur votre espace médical — <?= date('d F Y') ?></p>
    </div>

    <!-- PROCHAIN RDV -->
    <?php if ($prochainRdv): ?>
      <div class="rdv-banner">
        <div class="rdv-info">
          <strong> Prochain rendez-vous</strong>
          <span>
            <?= date('d/m/Y', strtotime($prochainRdv['date_creneau'])) ?>
            à <?= substr($prochainRdv['heure_debut'], 0, 5) ?>
            — <?= esc($prochainRdv['periode_titre']) ?>
          </span>
        </div>
        <div class="rdv-badge">Confirmé ✓</div>
      </div>
    <?php else: ?>
      <div class="rdv-banner-empty">
        Aucun rendez-vous à venir —
        <a href="<?= base_url('etudiant/periodes') ?>">Prendre un rendez-vous →</a>
      </div>
    <?php endif; ?>

    <!-- STATISTIQUES -->
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-icon" style="background:#E1F5EE"></div>
        <div class="stat-num"><?= $nb_periodes ?></div>
        <div class="stat-label">Périodes disponibles</div>
      </div>
      <div class="stat-card">
        <div class="stat-icon" style="background:#E6F1FB"></div>
        <div class="stat-num"><?= $nb_rdv ?></div>
        <div class="stat-label">Mes rendez-vous</div>
      </div>
      <div class="stat-card">
        <div class="stat-icon" style="background:#EAF3DE"></div>
        <div class="stat-num">0</div>
        <div class="stat-label">Résultats disponibles</div>
      </div>
      <div class="stat-card">
        <div class="stat-icon" style="background:#FAEEDA"></div>
        <div class="stat-num">0</div>
        <div class="stat-label">Notifications</div>
      </div>
    </div>

    <!-- 4 FONCTIONNALITÉS -->
    <div class="section-title">Que souhaitez-vous faire ?</div>
    <div class="features-grid">

      <!-- 1. Consulter les périodes -->
      <a href="<?= base_url('etudiant/periodes') ?>" class="feature-card teal">
        <div class="feature-top">
          <div>
            <div class="feature-title">Consulter les périodes de visite</div>
          </div>
        </div>
        <div class="feature-desc">
          Consultez les campagnes de visites médicales programmées pour votre
          département et vérifiez les créneaux disponibles.
        </div>
        <span class="feature-cta cta-teal">Voir les périodes →</span>
      </a>

      <!-- 2. Prendre rendez-vous -->
      <a href="<?= base_url('etudiant/periodes') ?>" class="feature-card blue">
        <div class="feature-top">
          <div>
            <div class="feature-title">Prendre un rendez-vous en ligne</div>
          </div>
        </div>
        <div class="feature-desc">
          Réservez un créneau horaire pour votre visite médicale sans file d'attente.
          Choisissez la date et l'heure qui vous conviennent.
        </div>
        <span class="feature-cta cta-blue">Réserver un créneau →</span>
      </a>

      <!-- 3. Notifications -->
      <a href="<?= base_url('etudiant/notifications') ?>" class="feature-card amber">
        <div class="feature-top">
          <div>
            <div class="feature-title">Recevoir des notifications de rappel</div>
          </div>
        </div>
        <div class="feature-desc">
          Recevez des rappels automatiques 48h avant votre rendez-vous.
          Ne manquez plus jamais votre visite médicale.
        </div>
        <span class="feature-cta cta-amber">Voir les notifications →</span>
      </a>

      <!-- 4. Résultats -->
      <a href="<?= base_url('etudiant/resultats') ?>" class="feature-card green">
        <div class="feature-top">
          <div>
            <div class="feature-title">Consulter et télécharger les résultats</div>
          </div>
        </div>
        <div class="feature-desc">
          Accédez à vos résultats médicaux en ligne et téléchargez vos
          certificats et rapports au format PDF.
        </div>
        <span class="feature-cta cta-green">Voir mes résultats →</span>
      </a>

    </div>

    <!-- MES DERNIERS RDV -->
    <div class="card">
      <div class="card-header">
        <span>Mes rendez-vous</span>
        <a href="<?= base_url('etudiant/rendezvous') ?>">Voir tout →</a>
      </div>
      <table>
        <thead>
          <tr>
            <th>Période</th>
            <th>Date</th>
            <th>Horaire</th>
            <th>Médecin</th>
            <th>Statut</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($rendezvous)): ?>
            <tr class="empty-row">
              <td colspan="5">
                Aucun rendez-vous pour le moment —
                <a href="<?= base_url('etudiant/periodes') ?>"
                   style="color:#0F6E56;text-decoration:none;font-weight:600">
                  Prendre un rendez-vous
                </a>
              </td>
            </tr>
          <?php else: ?>
            <?php foreach (array_slice($rendezvous, 0, 5) as $rdv): ?>
              <tr>
                <td><?= esc($rdv['periode_titre']) ?></td>
                <td><?= date('d/m/Y', strtotime($rdv['date_creneau'])) ?></td>
                <td><?= substr($rdv['heure_debut'], 0, 5) ?>
                    – <?= substr($rdv['heure_fin'], 0, 5) ?></td>
                <td>Dr. <?= esc($rdv['medecin_nom']) ?></td>
                <td>
                  <span class="badge badge-<?= $rdv['statut'] ?>">
                    <?= ucfirst($rdv['statut']) ?>
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