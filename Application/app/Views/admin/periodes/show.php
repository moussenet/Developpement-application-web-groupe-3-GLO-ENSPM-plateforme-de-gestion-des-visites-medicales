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
    .navbar .brand { font-size: 17px; font-weight: 700; color: #fff; }
    .navbar .brand span { color: #a8f0d8; }
    .navbar .user { font-size: 13px; color: rgba(255,255,255,0.85);
                    display: flex; align-items: center; gap: 16px; }
    .navbar .user a { color: rgba(255,255,255,0.7); text-decoration: none; font-size: 12px; }
    .layout { display: flex; min-height: calc(100vh - 54px); }
    .sidebar { width: 220px; background: #fff; border-right: 1px solid #e8e8e8;
               padding: 20px 0; flex-shrink: 0; }
    .sidebar a { display: flex; align-items: center; gap: 10px; padding: 10px 20px;
                 font-size: 13px; color: #555; text-decoration: none; transition: background .15s; }
    .sidebar a:hover { background: #f0f2f5; color: #0F6E56; }
    .sidebar a.active { background: #E1F5EE; color: #0F6E56; font-weight: 600;
                        border-right: 3px solid #0F6E56; }
    .sidebar .section { font-size: 10px; font-weight: 700; color: #bbb;
                        text-transform: uppercase; letter-spacing: .5px;
                        padding: 14px 20px 6px; }
    .content { flex: 1; padding: 28px 24px; }
    .back { font-size: 13px; color: #0F6E56; text-decoration: none;
            display: inline-flex; align-items: center; gap: 4px; margin-bottom: 16px; }
    .back:hover { text-decoration: underline; }
    .page-title { font-size: 20px; font-weight: 700; color: #1a1917; }
    .page-sub { font-size: 13px; color: #888; margin-top: 2px; margin-bottom: 24px; }
    .info-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 12px;
                 margin-bottom: 24px; }
    .info-card { background: #fff; border-radius: 10px; padding: 14px 16px;
                 box-shadow: 0 1px 4px rgba(0,0,0,.07); }
    .info-label { font-size: 11px; color: #aaa; font-weight: 600;
                  text-transform: uppercase; letter-spacing: .4px; margin-bottom: 4px; }
    .info-val { font-size: 16px; font-weight: 600; color: #1a1917; }
    .day-block { background: #fff; border-radius: 10px; padding: 18px 20px;
                 margin-bottom: 14px; box-shadow: 0 1px 4px rgba(0,0,0,.07); }
    .day-title { font-size: 14px; font-weight: 700; color: #1a1917; margin-bottom: 12px;
                 padding-bottom: 10px; border-bottom: 1px solid #f0f0f0; }
    .slots { display: grid; grid-template-columns: repeat(auto-fill, minmax(140px,1fr)); gap: 8px; }
    .slot { border: 1.5px solid #e0e0e0; border-radius: 8px; padding: 10px 12px;
            text-align: center; }
    .slot.full { background: #f8f8f8; opacity: .6; }
    .slot.available { border-color: #0F6E56; background: #E1F5EE; }
    .slot-time { font-size: 13px; font-weight: 600; color: #1a1917; }
    .slot-places { font-size: 11px; margin-top: 3px; }
    .slot.available .slot-places { color: #0F6E56; }
    .slot.full .slot-places { color: #aaa; }
    .empty { text-align: center; padding: 40px; color: #aaa; font-size: 14px; }
  </style>
</head>
<body>

<div class="navbar">
  <div class="brand">CMS<span>ENSPM</span>
    <span style="font-size:12px;font-weight:400;opacity:.7"> — Administration</span>
  </div>
  <div class="user">
    <span><?= esc(session()->get('user_nom')) ?></span>
    <a href="<?= base_url('logout') ?>">Déconnexion</a>
  </div>
</div>

<div class="layout">
  <div class="sidebar">
    <div class="section">Navigation</div>
    <a href="<?= base_url('admin/dashboard') ?>">Tableau de bord</a>
    <a href="<?= base_url('admin/periodes') ?>" class="active">Périodes de visite</a>
    <a href="<?= base_url('admin/users') ?>">Utilisateurs</a>
  </div>

  <div class="content">
    <a href="<?= base_url('admin/periodes') ?>" class="back">← Retour à la liste</a>
    <div class="page-title"><?= esc($periode['titre']) ?></div>
    <div class="page-sub">
      <?= esc($periode['departement']) ?> ·
      <?= date('d/m/Y', strtotime($periode['date_debut'])) ?>
      → <?= date('d/m/Y', strtotime($periode['date_fin'])) ?>
    </div>

    <!-- Résumé -->
    <?php
      $totalCreneaux  = 0;
      $totalPlaces    = 0;
      $totalPrises    = 0;
      foreach ($creneauxParDate as $creneaux) {
          foreach ($creneaux as $c) {
              $totalCreneaux++;
              $totalPlaces += $c['places_total'];
              $totalPrises += $c['places_prises'];
          }
      }
    ?>
    <div class="info-grid">
      <div class="info-card">
        <div class="info-label">Créneaux générés</div>
        <div class="info-val"><?= $totalCreneaux ?></div>
      </div>
      <div class="info-card">
        <div class="info-label">Places totales</div>
        <div class="info-val"><?= $totalPlaces ?></div>
      </div>
      <div class="info-card">
        <div class="info-label">Places réservées</div>
        <div class="info-val" style="color:#0F6E56"><?= $totalPrises ?></div>
      </div>
      <div class="info-card">
        <div class="info-label">Places disponibles</div>
        <div class="info-val" style="color:#BA7517"><?= $totalPlaces - $totalPrises ?></div>
      </div>
    </div>

    <!-- Créneaux par jour -->
    <?php if (empty($creneauxParDate)): ?>
      <div class="empty">Aucun créneau généré pour cette période.</div>
    <?php else: ?>
      <?php foreach ($creneauxParDate as $date => $creneaux): ?>
        <div class="day-block">
          <div class="day-title">
            <?php
              $jours = ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'];
              $ts    = strtotime($date);
              echo $jours[date('w', $ts)] . ' ' . date('d/m/Y', $ts);
              echo ' <span style="font-size:12px;font-weight:400;color:#aaa">('
                   . count($creneaux) . ' créneaux)</span>';
            ?>
          </div>
          <div class="slots">
            <?php foreach ($creneaux as $c):
              $dispo = $c['places_total'] - $c['places_prises'];
              $classe = $dispo > 0 ? 'available' : 'full';
            ?>
              <div class="slot <?= $classe ?>">
                <div class="slot-time">
                  <?= substr($c['heure_debut'], 0, 5) ?> –
                  <?= substr($c['heure_fin'], 0, 5) ?>
                </div>
                <div class="slot-places">
                  <?= $c['places_prises'] ?>/<?= $c['places_total'] ?> places
                  <?= $dispo === 0 ? '· Complet' : '' ?>
                </div>
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