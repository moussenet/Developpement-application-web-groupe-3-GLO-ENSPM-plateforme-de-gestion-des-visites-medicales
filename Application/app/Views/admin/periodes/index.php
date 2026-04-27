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
    .navbar .user a:hover { color: #fff; }
    .layout { display: flex; min-height: calc(100vh - 54px); }
    .sidebar { width: 220px; background: #fff; border-right: 1px solid #e8e8e8;
               padding: 20px 0; flex-shrink: 0; }
    .sidebar a { display: flex; align-items: center; gap: 10px; padding: 10px 20px;
                 font-size: 13px; color: #555; text-decoration: none;
                 transition: background .15s; }
    .sidebar a:hover { background: #f0f2f5; color: #0F6E56; }
    .sidebar a.active { background: #E1F5EE; color: #0F6E56; font-weight: 600;
                        border-right: 3px solid #0F6E56; }
    .sidebar .section { font-size: 10px; font-weight: 700; color: #bbb;
                        text-transform: uppercase; letter-spacing: .5px;
                        padding: 14px 20px 6px; }
    .content { flex: 1; padding: 28px 24px; }
    .page-header { display: flex; align-items: center;
                   justify-content: space-between; margin-bottom: 24px; }
    .page-title { font-size: 20px; font-weight: 700; color: #1a1917; }
    .page-sub { font-size: 13px; color: #888; margin-top: 2px; }
    .btn { padding: 9px 16px; border-radius: 8px; border: none; cursor: pointer;
           font-size: 13px; font-weight: 500; text-decoration: none;
           display: inline-flex; align-items: center; gap: 6px;
           transition: background .15s; }
    .btn-primary { background: #0F6E56; color: #fff; }
    .btn-primary:hover { background: #1D9E75; }
    .btn-secondary { background: #f0f2f5; color: #555; border: 1px solid #e0e0e0; }
    .btn-secondary:hover { background: #e0e0e0; }
    .btn-danger { background: #FCEBEB; color: #A32D2D; border: 1px solid #f5c6c6; }
    .btn-sm { padding: 5px 10px; font-size: 12px; }
    .alert { padding: 11px 14px; border-radius: 8px; font-size: 13px; margin-bottom: 20px; }
    .alert-success { background: #E1F5EE; color: #085041; border-left: 3px solid #0F6E56; }
    .alert-error   { background: #FCEBEB; color: #A32D2D; border-left: 3px solid #A32D2D; }
    .card { background: #fff; border-radius: 10px;
            box-shadow: 0 1px 4px rgba(0,0,0,.07); overflow: hidden; }
    table { width: 100%; border-collapse: collapse; }
    thead th { background: #f8f9fa; padding: 11px 14px; text-align: left;
               font-size: 12px; font-weight: 600; color: #888;
               text-transform: uppercase; letter-spacing: .4px;
               border-bottom: 1px solid #eee; }
    tbody td { padding: 12px 14px; font-size: 13px; color: #333;
               border-bottom: 1px solid #f5f5f5; vertical-align: middle; }
    tbody tr:last-child td { border-bottom: none; }
    tbody tr:hover td { background: #fafafa; }
    .badge { display: inline-block; padding: 3px 9px; border-radius: 4px;
             font-size: 11px; font-weight: 600; }
    .badge-active   { background: #E1F5EE; color: #085041; }
    .badge-terminee { background: #f0f0f0; color: #888; }
    .badge-annulee  { background: #FCEBEB; color: #A32D2D; }
    .empty { text-align: center; padding: 48px; color: #aaa; font-size: 14px; }
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
    <a href="<?= base_url('admin/dashboard') ?>"> Tableau de bord</a>
    <a href="<?= base_url('admin/periodes') ?>" class="active"> Périodes de visite</a>
    <a href="<?= base_url('admin/users') ?>">Utilisateurs</a>
  </div>

  <div class="content">
    <div class="page-header">
      <div>
        <div class="page-title">Périodes de visite médicale</div>
        <div class="page-sub"><?= count($periodes) ?> période(s) au total</div>
      </div>
      <a href="<?= base_url('admin/periodes/create') ?>" class="btn btn-primary">
        + Nouvelle période
      </a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-error"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <div class="card">
      <?php if (empty($periodes)): ?>
        <div class="empty">
          Aucune période créée.
          <br><br>
          <a href="<?= base_url('admin/periodes/create') ?>" class="btn btn-primary btn-sm">
            Créer la première période
          </a>
        </div>
      <?php else: ?>
        <table>
          <thead>
            <tr>
              <th>Titre</th>
              <th>Département</th>
              <th>Période</th>
              <th>Médecin</th>
              <th>Statut</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($periodes as $p): ?>
              <tr>
                <td><strong><?= esc($p['titre']) ?></strong></td>
                <td><?= esc($p['departement']) ?></td>
                <td>
                  <?= date('d/m/Y', strtotime($p['date_debut'])) ?>
                  → <?= date('d/m/Y', strtotime($p['date_fin'])) ?>
                </td>
                <td><?= esc($p['medecin_nom']) ?></td>
                <td>
                  <span class="badge badge-<?= $p['statut'] ?>">
                    <?= $p['statut'] === 'active' ? 'Active' :
                       ($p['statut'] === 'terminee' ? 'Terminée' : 'Annulée') ?>
                  </span>
                </td>
                <td style="display:flex;gap:6px">
                  <a href="<?= base_url('admin/periodes/' . $p['id']) ?>"
                     class="btn btn-secondary btn-sm">Créneaux</a>
                  <form action="<?= base_url('admin/periodes/statut/' . $p['id']) ?>"
                        method="post">
                    <?= csrf_field() ?>
                    <?php if ($p['statut'] === 'active'): ?>
                      <button type="submit" name="statut" value="annulee"
                              class="btn btn-danger btn-sm"
                              onclick="return confirm('Annuler cette période ?')">
                        Annuler
                      </button>
                    <?php else: ?>
                      <button type="submit" name="statut" value="active"
                              class="btn btn-secondary btn-sm">
                        Réactiver
                      </button>
                    <?php endif; ?>
                  </form>
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