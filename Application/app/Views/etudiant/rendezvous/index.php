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
    .page-header { display: flex; align-items: center;
                   justify-content: space-between; margin-bottom: 24px; }
    .page-title { font-size: 20px; font-weight: 700; color: #1a1917; }
    .page-sub   { font-size: 13px; color: #888; margin-top: 3px; }
    .btn { padding: 9px 16px; border-radius: 8px; border: none; cursor: pointer;
           font-size: 13px; font-weight: 500; text-decoration: none;
           display: inline-flex; align-items: center; gap: 6px; transition: background .15s; }
    .btn-primary  { background: #0F6E56; color: #fff; }
    .btn-primary:hover { background: #1D9E75; }
    .btn-danger   { background: #FCEBEB; color: #A32D2D; border: 1px solid #f5c6c6; }
    .btn-sm       { padding: 5px 10px; font-size: 12px; }
    .alert { padding: 11px 14px; border-radius: 8px; font-size: 13px; margin-bottom: 20px; }
    .alert-success { background: #E1F5EE; color: #085041; border-left: 3px solid #0F6E56; }
    .alert-error   { background: #FCEBEB; color: #A32D2D; border-left: 3px solid #A32D2D; }
    .card { background: #fff; border-radius: 10px;
            box-shadow: 0 1px 4px rgba(0,0,0,.07); overflow: hidden; }
    table { width: 100%; border-collapse: collapse; }
    thead th { background: #f8f9fa; padding: 11px 16px; text-align: left;
               font-size: 11px; font-weight: 600; color: #888;
               text-transform: uppercase; letter-spacing: .4px;
               border-bottom: 1px solid #eee; }
    tbody td { padding: 13px 16px; font-size: 13px; color: #333;
               border-bottom: 1px solid #f5f5f5; vertical-align: middle; }
    tbody tr:last-child td { border-bottom: none; }
    tbody tr:hover td { background: #fafafa; }
    .badge { display: inline-block; padding: 3px 9px; border-radius: 4px;
             font-size: 11px; font-weight: 600; }
    .badge-confirme { background: #E1F5EE; color: #085041; }
    .badge-present  { background: #E6F1FB; color: #0C447C; }
    .badge-annule   { background: #f0f0f0; color: #888; }
    .badge-absent   { background: #FCEBEB; color: #A32D2D; }
    .empty { text-align: center; padding: 56px; color: #aaa; }
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
    <span> <?= esc(session()->get('user_nom')) ?></span>
    <a href="<?= base_url('logout') ?>">Déconnexion</a>
  </div>
</div>

<div class="layout">
  <div class="sidebar">
    <div class="section">Mon espace</div>
    <a href="<?= base_url('etudiant/dashboard') ?>"> Tableau de bord</a>
    <a href="<?= base_url('etudiant/periodes') ?>"> Périodes de visite</a>
    <a href="<?= base_url('etudiant/rendezvous') ?>" class="active"> Mes rendez-vous</a>
    <a href="<?= base_url('etudiant/notifications') ?>"> Notifications</a>
    <a href="<?= base_url('etudiant/resultats') ?>"> Mes résultats</a>
    <div class="section">Compte</div>
    <a href="<?= base_url('logout') ?>"> Déconnexion</a>
  </div>

  <div class="content">
    <div class="page-header">
      <div>
        <div class="page-title">Mes rendez-vous</div>
        <div class="page-sub"><?= count($rendezvous) ?> rendez-vous au total</div>
      </div>
      <a href="<?= base_url('etudiant/periodes') ?>" class="btn btn-primary">
        + Prendre un rendez-vous
      </a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-error"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <div class="card">
      <?php if (empty($rendezvous)): ?>
        <div class="empty">
          <p>Vous n'avez aucun rendez-vous pour le moment.</p>
          <br>
          <a href="<?= base_url('etudiant/periodes') ?>" class="btn btn-primary btn-sm">
            Consulter les périodes disponibles
          </a>
        </div>
      <?php else: ?>
        <table>
          <thead>
            <tr>
              <th>Période</th>
              <th>Date</th>
              <th>Horaire</th>
              <th>Médecin</th>
              <th>Statut</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($rendezvous as $rdv): ?>
              <tr>
                <td><strong><?= esc($rdv['periode_titre']) ?></strong></td>
                <td><?= date('d/m/Y', strtotime($rdv['date_creneau'])) ?></td>
                <td>
                  <?= substr($rdv['heure_debut'],0,5) ?> –
                  <?= substr($rdv['heure_fin'],0,5) ?>
                </td>
                <td>Dr. <?= esc($rdv['medecin_nom']) ?></td>
                <td>
                  <span class="badge badge-<?= $rdv['statut'] ?>">
                    <?= match($rdv['statut']) {
                      'confirme' => 'Confirmé',
                      'present'  => 'Présent',
                      'annule'   => 'Annulé',
                      'absent'   => 'Absent',
                      default    => ucfirst($rdv['statut'])
                    } ?>
                  </span>
                </td>
                <td>
                  <?php if ($rdv['statut'] === 'confirme'
                         && $rdv['date_creneau'] >= date('Y-m-d')): ?>
                    <form action="<?= base_url('etudiant/rendezvous/annuler/' . $rdv['id']) ?>"
                          method="post">
                      <?= csrf_field() ?>
                      <button type="submit" class="btn btn-danger btn-sm"
                              onclick="return confirm('Annuler ce rendez-vous ?')">
                        Annuler
                      </button>
                    </form>
                  <?php else: ?>
                    <span style="font-size:12px;color:#aaa">—</span>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>
  </div>
</div>

</body>
</html>