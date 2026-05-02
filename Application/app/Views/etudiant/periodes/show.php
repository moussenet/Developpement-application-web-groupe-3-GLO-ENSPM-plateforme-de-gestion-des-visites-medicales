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
    .back { font-size: 13px; color: #0F6E56; text-decoration: none;
            display: inline-flex; align-items: center; gap: 4px; margin-bottom: 16px; }
    .back:hover { text-decoration: underline; }
    .page-title { font-size: 20px; font-weight: 700; color: #1a1917; }
    .page-sub   { font-size: 13px; color: #888; margin-top: 3px; margin-bottom: 20px; }
    .alert { padding: 11px 14px; border-radius: 8px; font-size: 13px; margin-bottom: 20px; }
    .alert-success { background: #E1F5EE; color: #085041; border-left: 3px solid #0F6E56; }
    .alert-error   { background: #FCEBEB; color: #A32D2D; border-left: 3px solid #A32D2D; }
    .alert-warning { background: #FAEEDA; color: #633806; border-left: 3px solid #BA7517; }
    .info-grid { display: grid; grid-template-columns: repeat(4,1fr);
                 gap: 12px; margin-bottom: 24px; }
    .info-card { background: #fff; border-radius: 10px; padding: 14px;
                 box-shadow: 0 1px 4px rgba(0,0,0,.07); }
    .info-label { font-size:11px; color:#aaa; font-weight:600;
                  text-transform:uppercase; letter-spacing:.4px; margin-bottom:4px; }
    .info-val   { font-size:15px; font-weight:600; color:#1a1917; }
    .day-block  { background: #fff; border-radius: 10px; padding: 18px 20px;
                  margin-bottom: 14px; box-shadow: 0 1px 4px rgba(0,0,0,.07); }
    .day-title  { font-size:14px; font-weight:700; color:#1a1917; margin-bottom:14px;
                  padding-bottom:10px; border-bottom:1px solid #f0f0f0; }
    .slots-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px,1fr));
                  gap: 10px; }
    .slot { border: 1.5px solid #e0e0e0; border-radius: 10px; padding: 12px;
            text-align: center; transition: all .15s; }
    .slot.available { border-color: #0F6E56; cursor: pointer; }
    .slot.available:hover { background: #E1F5EE;
                             box-shadow: 0 2px 8px rgba(15,110,86,.15); }
    .slot.full { background: #f8f8f8; opacity: .6; }
    .slot-time  { font-size:14px; font-weight:600; color:#1a1917; margin-bottom:4px; }
    .slot-places { font-size:12px; }
    .slot.available .slot-places { color:#0F6E56; }
    .slot.full    .slot-places   { color:#aaa; }
    .slot-btn   { margin-top:8px; padding:6px 12px; background:#0F6E56; color:#fff;
                  border:none; border-radius:6px; font-size:12px; font-weight:500;
                  cursor:pointer; width:100%; transition:background .15s; }
    .slot-btn:hover { background:#1D9E75; }
    .empty { text-align:center; padding:40px; color:#aaa; font-size:13px; }
    .deja-rdv-banner { background:#E1F5EE; border:1.5px solid #0F6E56;
                       border-radius:10px; padding:16px 20px; margin-bottom:20px;
                       display:flex; align-items:center; gap:12px; }
    .deja-rdv-banner .icon { font-size:24px; }
    .deja-rdv-banner strong { display:block; color:#085041; font-size:14px; }
    .deja-rdv-banner span   { font-size:13px; color:#555; }
    .deja-rdv-banner a { color:#0F6E56; font-weight:600; }
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
    <a href="<?= base_url('etudiant/dashboard') ?>">🏠 Tableau de bord</a>
    <a href="<?= base_url('etudiant/periodes') ?>" class="active">📅 Périodes de visite</a>
    <a href="<?= base_url('etudiant/rendezvous') ?>">📋 Mes rendez-vous</a>
    <a href="<?= base_url('etudiant/notifications') ?>">🔔 Notifications</a>
    <a href="<?= base_url('etudiant/resultats') ?>">📄 Mes résultats</a>
    <div class="section">Compte</div>
    <a href="<?= base_url('logout') ?>">🚪 Déconnexion</a>
  </div>

  <div class="content">
    <a href="<?= base_url('etudiant/periodes') ?>" class="back">← Retour aux périodes</a>

    <div class="page-title"><?= esc($periode['titre']) ?></div>
    <div class="page-sub">
      <?= esc($periode['departement']) ?> ·
      Du <?= date('d/m/Y', strtotime($periode['date_debut'])) ?>
      au <?= date('d/m/Y', strtotime($periode['date_fin'])) ?> ·
      Dr. <?= esc($periode['medecin_nom']) ?>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-error"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <!-- Déjà un RDV pour cette période -->
    <?php if ($dejaRdv): ?>
      <div class="deja-rdv-banner">
        <div class="icon">✅</div>
        <div>
          <strong>Vous avez déjà un rendez-vous pour cette période</strong>
          <span>
            Consultez vos rendez-vous pour voir les détails.
            <a href="<?= base_url('etudiant/rendezvous') ?>">Voir mes rendez-vous →</a>
          </span>
        </div>
      </div>
    <?php endif; ?>

    <!-- Infos rapides -->
    <div class="info-grid">
      <div class="info-card">
        <div class="info-label">Durée</div>
        <div class="info-val"><?= $periode['duree_consultation'] ?> min</div>
      </div>
      <div class="info-card">
        <div class="info-label">Max / créneau</div>
        <div class="info-val"><?= $periode['max_par_creneau'] ?> étudiants</div>
      </div>
      <div class="info-card">
        <div class="info-label">Jours disponibles</div>
        <div class="info-val"><?= count($creneauxParDate) ?> jours</div>
      </div>
      <div class="info-card">
        <div class="info-label">Médecin</div>
        <div class="info-val" style="font-size:13px">Dr. <?= esc($periode['medecin_nom']) ?></div>
      </div>
    </div>

    <!-- Créneaux groupés par date -->
    <?php if (empty($creneauxParDate)): ?>
      <div class="empty">
        Aucun créneau disponible pour cette période.<br>
        Tous les créneaux sont complets ou la période est terminée.
      </div>
    <?php else: ?>
      <?php
        $jours = ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'];
        foreach ($creneauxParDate as $date => $creneaux):
          $ts = strtotime($date);
      ?>
        <div class="day-block">
          <div class="day-title">
            <?= $jours[date('w', $ts)] ?> <?= date('d', $ts) ?>
            <?= ['','Janvier','Février','Mars','Avril','Mai','Juin',
                 'Juillet','Août','Septembre','Octobre','Novembre','Décembre'][date('n',$ts)] ?>
            <?= date('Y', $ts) ?>
            <span style="font-size:12px;font-weight:400;color:#aaa">
              — <?= count($creneaux) ?> créneau(x) disponible(s)
            </span>
          </div>
          <div class="slots-grid">
            <?php foreach ($creneaux as $c):
              $dispo  = $c['places_total'] - $c['places_prises'];
              $classe = $dispo > 0 ? 'available' : 'full';
            ?>
              <div class="slot <?= $classe ?>">
                <div class="slot-time">
                  <?= substr($c['heure_debut'],0,5) ?> –
                  <?= substr($c['heure_fin'],0,5) ?>
                </div>
                <div class="slot-places">
                  <?php if ($dispo > 0): ?>
                    <?= $dispo ?> place<?= $dispo > 1 ? 's' : '' ?> restante<?= $dispo > 1 ? 's' : '' ?>
                  <?php else: ?>
                    Complet
                  <?php endif; ?>
                </div>
                <?php if ($dispo > 0 && ! $dejaRdv): ?>
                  <form action="<?= base_url('etudiant/rendezvous/store') ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="creneau_id" value="<?= $c['id'] ?>">
                    <input type="hidden" name="periode_id" value="<?= $periode['id'] ?>">
                    <button type="submit" class="slot-btn">Réserver</button>
                  </form>
                <?php endif; ?>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>

  </div>
</div>

</body>
</html>