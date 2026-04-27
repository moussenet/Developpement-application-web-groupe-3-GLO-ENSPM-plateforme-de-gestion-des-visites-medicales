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
    .page-title { font-size: 20px; font-weight: 700; color: #1a1917; margin-bottom: 20px; }
    .card { background: #fff; border-radius: 10px; padding: 28px;
            box-shadow: 0 1px 4px rgba(0,0,0,.07); max-width: 680px; }
    .section-label { font-size: 11px; font-weight: 700; color: #aaa;
                     text-transform: uppercase; letter-spacing: .5px;
                     margin-bottom: 12px; margin-top: 4px; }
    .divider { height: 1px; background: #f0f0f0; margin: 20px 0; }
    .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
    .group { margin-bottom: 14px; }
    label { display: block; font-size: 12px; font-weight: 500;
            color: #555; margin-bottom: 4px; }
    input, select { width: 100%; padding: 10px 12px; border: 1.5px solid #e0e0e0;
                    border-radius: 8px; font-size: 13px; outline: none;
                    background: #fff; color: #1a1917; transition: border-color .15s; }
    input:focus, select:focus { border-color: #0F6E56;
                                box-shadow: 0 0 0 3px rgba(15,110,86,0.08); }
    .hint { font-size: 11px; color: #aaa; margin-top: 3px; }
    .required { color: #A32D2D; }
    .btn { padding: 10px 20px; border-radius: 8px; border: none; cursor: pointer;
           font-size: 13px; font-weight: 600; text-decoration: none;
           display: inline-flex; align-items: center; gap: 6px; transition: background .15s; }
    .btn-primary { background: #0F6E56; color: #fff; }
    .btn-primary:hover { background: #1D9E75; }
    .btn-secondary { background: #f0f2f5; color: #555; border: 1px solid #e0e0e0; }
    .alert-error { background: #FCEBEB; color: #A32D2D; border-left: 3px solid #A32D2D;
                   padding: 10px 14px; border-radius: 8px; font-size: 13px;
                   margin-bottom: 18px; }
    .alert-error ul { padding-left: 16px; margin-top: 4px; }
    .actions { display: flex; gap: 10px; margin-top: 8px; }
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
    <div class="page-title">Créer une période de visite</div>

    <?php if (session()->getFlashdata('errors')): ?>
      <div class="alert-error">
        <ul>
          <?php foreach (session()->getFlashdata('errors') as $e): ?>
            <li><?= esc($e) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <div class="card">
      <form action="<?= base_url('admin/periodes/store') ?>" method="post">
        <?= csrf_field() ?>

        <!-- INFORMATIONS GÉNÉRALES -->
        <div class="section-label">Informations générales</div>

        <div class="group">
          <label>Titre de la campagne <span class="required">*</span></label>
          <input type="text" name="titre"
                 value="<?= set_value('titre') ?>"
                 required>
        </div>

        <div class="grid">
          <div class="group">
            <label>Département <span class="required">*</span></label>
            <select name="departement" required>
              <option value="" disabled <?= set_value('departement') ? '' : 'selected' ?>>
                Choisir...
              </option>
              <?php foreach ($departements as $d): ?>
                <option value="<?= esc($d) ?>" <?= set_select('departement', $d) ?>>
                  <?= esc($d) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="group">
            <label>Filière <span style="color:#aaa;font-weight:400">(optionnel — vide = tous)</span></label>
            <input type="text" name="filiere"
                   value="<?= set_value('filiere') ?>">
          </div>
        </div>

        <div class="group">
          <label>Médecin assigné <span class="required">*</span></label>
          <select name="medecin_id" required>
            <option value="" disabled <?= set_value('medecin_id') ? '' : 'selected' ?>>
              Choisir un médecin...
            </option>
            <?php foreach ($medecins as $m): ?>
              <option value="<?= $m['id'] ?>" <?= set_select('medecin_id', $m['id']) ?>>
                Dr. <?= esc($m['nom']) ?> <?= esc($m['prenom']) ?>
              </option>
            <?php endforeach; ?>
          </select>
          <?php if (empty($medecins)): ?>
            <div class="hint" style="color:#A32D2D">
              ⚠ Aucun médecin disponible.
              <a href="<?= base_url('admin/users/create') ?>">Créer un compte médecin</a>
            </div>
          <?php endif; ?>
        </div>

        <div class="divider"></div>

        <!-- DATES -->
        <div class="section-label">Dates de la campagne</div>
        <div class="grid">
          <div class="group">
            <label>Date de début <span class="required">*</span></label>
            <input type="date" name="date_debut"
                   value="<?= set_value('date_debut') ?>"
                   min="<?= date('Y-m-d') ?>" required>
          </div>
          <div class="group">
            <label>Date de fin <span class="required">*</span></label>
            <input type="date" name="date_fin"
                   value="<?= set_value('date_fin') ?>"
                   min="<?= date('Y-m-d') ?>" required>
          </div>
        </div>

        <div class="divider"></div>

        <!-- CRÉNEAUX -->
        <div class="section-label">Configuration des créneaux</div>
        <div class="grid">
          <div class="group">
            <label>Heure de début des consultations <span class="required">*</span></label>
            <input type="time" name="heure_debut_journee"
                   value="<?= set_value('heure_debut_journee', '08:00') ?>" required>
          </div>
          <div class="group">
            <label>Heure de fin des consultations <span class="required">*</span></label>
            <input type="time" name="heure_fin_journee"
                   value="<?= set_value('heure_fin_journee', '16:00') ?>" required>
          </div>
        </div>
        <div class="grid">
          <div class="group">
            <label>Durée par consultation (minutes) <span class="required">*</span></label>
            <select name="duree_consultation" required>
              <?php foreach ([10, 15, 20, 30] as $d): ?>
                <option value="<?= $d ?>" <?= set_select('duree_consultation', $d, $d == 15) ?>>
                  <?= $d ?> minutes
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="group">
            <label>Étudiants max par créneau <span class="required">*</span></label>
            <input type="number" name="max_par_creneau"
                   value="<?= set_value('max_par_creneau', 5) ?>"
                   min="1" max="20" required>
            <div class="hint">Nombre de places disponibles par créneau horaire</div>
          </div>
        </div>

        <div class="divider"></div>

        <div class="actions">
          <button type="submit" class="btn btn-primary">
            Créer la période et générer les créneaux
          </button>
          <a href="<?= base_url('admin/periodes') ?>" class="btn btn-secondary">
            Annuler
          </a>
        </div>

      </form>
    </div>
  </div>
</div>

</body>
</html>