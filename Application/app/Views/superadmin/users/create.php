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
                         object-fit: contain; background: #fff; padding: 2px; }
    .navbar .brand span { font-size: 15px; font-weight: 700; color: #fff; }
    .navbar .brand span em { color: #a8f0d8; font-style: normal; }
    .navbar .user { font-size: 13px; color: rgba(255,255,255,0.7);
                    display: flex; align-items: center; gap: 16px; }
    .navbar .user a { color: rgba(255,255,255,0.5); text-decoration: none; font-size: 12px; }
    .layout { display: flex; min-height: calc(100vh - 54px); }
    .sidebar { width: 230px; background: #fff; border-right: 1px solid #e8e8e8;
               padding: 20px 0; flex-shrink: 0; }
    .sidebar .section { font-size: 10px; font-weight: 700; color: #bbb;
                        text-transform: uppercase; letter-spacing: .5px;
                        padding: 14px 20px 6px; }
    .sidebar a { display: flex; align-items: center; gap: 10px; padding: 10px 20px;
                 font-size: 13px; color: #555; text-decoration: none; transition: background .15s; }
    .sidebar a:hover { background: #f0f2f5; color: #1a1917; }
    .sidebar a.active { background: #f0f0ee; color: #1a1917; font-weight: 600;
                        border-right: 3px solid #1a1917; }
    .content { flex: 1; padding: 28px 24px; }
    .back { font-size: 13px; color: #0F6E56; text-decoration: none;
            display: inline-flex; align-items: center; gap: 4px; margin-bottom: 16px; }
    .page-title { font-size: 20px; font-weight: 700; color: #1a1917; margin-bottom: 20px; }
    .card { background: #fff; border-radius: 10px; padding: 28px;
            box-shadow: 0 1px 4px rgba(0,0,0,.07); max-width: 560px; }
    .section-label { font-size: 11px; font-weight: 700; color: #aaa;
                     text-transform: uppercase; letter-spacing: .5px;
                     margin-bottom: 12px; }
    .divider { height: 1px; background: #f0f0f0; margin: 20px 0; }
    .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
    .group { margin-bottom: 14px; }
    label { display: block; font-size: 12px; font-weight: 500;
            color: #555; margin-bottom: 4px; }
    input, select { width: 100%; padding: 10px 12px; border: 1.5px solid #e0e0e0;
                    border-radius: 8px; font-size: 13px; outline: none;
                    background: #fff; transition: border-color .15s; }
    input:focus, select:focus { border-color: #1a1917;
                                box-shadow: 0 0 0 3px rgba(26,25,23,0.06); }
    .hint { font-size: 11px; color: #aaa; margin-top: 3px; }
    .required { color: #A32D2D; }
    .btn { padding: 10px 20px; border-radius: 8px; border: none; cursor: pointer;
           font-size: 13px; font-weight: 600; text-decoration: none;
           display: inline-flex; align-items: center; gap: 6px; transition: background .15s; }
    .btn-primary { background: #1a1917; color: #fff; }
    .btn-primary:hover { background: #333; }
    .btn-secondary { background: #f0f2f5; color: #555; border: 1px solid #e0e0e0; }
    .alert-error { background: #FCEBEB; color: #A32D2D; border-left: 3px solid #A32D2D;
                   padding: 10px 14px; border-radius: 8px; font-size: 13px; margin-bottom: 18px; }
    .alert-error ul { padding-left: 16px; margin-top: 4px; }
    .field-admin, .field-medecin { display: none; }
    .role-info { padding: 12px 14px; border-radius: 8px; font-size: 13px;
                 margin-top: 8px; display: none; }
    .role-info-admin   { background: #EEEDFE; color: #3C3489; border-left: 3px solid #534AB7; }
    .role-info-medecin { background: #E1F5EE; color: #085041; border-left: 3px solid #0F6E56; }
    .actions { display: flex; gap: 10px; margin-top: 8px; }
  </style>
</head>
<body>

<div class="navbar">
  <div class="brand">
    <img src="<?= base_url('img/logo.jpg') ?>" alt="ENSPM">
    <span>Centre Médico-Sanitaire <em>ENSPM</em></span>
  </div>
  <div class="user">
    <span><?= esc(session()->get('user_nom')) ?></span>
    <a href="<?= base_url('logout') ?>">Déconnexion</a>
  </div>
</div>

<div class="layout">
  <div class="sidebar">
    <div class="section">Super Administration</div>
    <a href="<?= base_url('superadmin/dashboard') ?>"> Tableau de bord</a>
    <a href="<?= base_url('superadmin/users') ?>" class="active"> Comptes admin & médecins</a>
    <div class="section">Compte</div>
    <a href="<?= base_url('logout') ?>"> Déconnexion</a>
  </div>

  <div class="content">
    <a href="<?= base_url('superadmin/users') ?>" class="back">← Retour à la liste</a>
    <div class="page-title">Créer un compte</div>

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
      <form action="<?= base_url('superadmin/users/store') ?>" method="post">
        <?= csrf_field() ?>

        <!-- TYPE DE COMPTE -->
        <div class="section-label">Type de compte</div>
        <div class="group">
          <label>Rôle <span class="required">*</span></label>
          <select name="role_id" id="sel-role" required>
            <option value="" disabled <?= set_value('role_id') ? '' : 'selected' ?>>
              Choisir...
            </option>
            <option value="2" <?= set_select('role_id', '2') ?>>
               Administrateur
            </option>
            <option value="3" <?= set_select('role_id', '3') ?>>
               Personnel médical
            </option>
          </select>
        </div>

        <!-- Info admin -->
        <div class="role-info role-info-admin" id="info-admin">
           L'ID direction est délivré par la direction de l'établissement
          et doit être fourni par le responsable hiérarchique.
        </div>

        <!-- Info médecin -->
        <div class="role-info role-info-medecin" id="info-medecin">
           Le numéro d'ordre médical est obligatoire pour valider
          la qualité de personnel soignant.
        </div>

        <div class="divider"></div>

        <!-- IDENTITÉ -->
        <div class="section-label">Identité</div>
        <div class="grid">
          <div class="group">
            <label>Nom <span class="required">*</span></label>
            <input type="text" name="nom"
                   value="<?= set_value('nom') ?>" required>
          </div>
           <div class="group">
        <label>Prénom <span class="optional">(optionnel)</span></label>
        <input 
            type="text" 
            name="prenom"
            value="<?= set_value('prenom') ?>">
    </div>
        </div>

        <div class="divider"></div>

        <!-- CHAMP SPÉCIFIQUE ADMIN -->
        <div class="field-admin" id="field-admin">
          <div class="section-label">Vérification direction</div>
          <div class="group">
            <label>ID direction <span class="required">*</span></label>
            <input type="text" name="id_direction"
                   value="<?= set_value('id_direction') ?>">
            <div class="hint">
              Identifiant délivré par le chef de département / direction
            </div>
          </div>
          <div class="divider"></div>
        </div>

        <!-- CHAMP SPÉCIFIQUE MÉDECIN -->
        <div class="field-medecin" id="field-medecin">
          <div class="section-label">Attestation médicale</div>
          <div class="grid">
            <div class="group">
              <label>Numéro d'ordre médical <span class="required">*</span></label>
              <input type="text" name="numero_ordre_medical"
                     value="<?= set_value('numero_ordre_medical') ?>">
            </div>
            <div class="group">
              <label>Spécialité</label>
              <input type="text" name="specialite"
                     value="<?= set_value('specialite') ?>"
                     placeholder="ex: Médecine générale">
            </div>
          </div>
          <div class="divider"></div>
        </div>

        <!-- ACCÈS -->
        <div class="section-label">Accès au compte</div>
        <div class="group">
          <label>Adresse email <span class="required">*</span></label>
          <input type="email" name="email"
                 value="<?= set_value('email') ?>"
                 placeholder="exemple@enspm.cm" required>
        </div>
        <div class="group">
          <label>Mot de passe <span class="required">*</span></label>
          <input type="password" name="password" required minlength="8">
          <div class="hint">Minimum 8 caractères</div>
        </div>

        <div class="actions">
          <button type="submit" class="btn btn-primary">Créer le compte</button>
          <a href="<?= base_url('superadmin/users') ?>" class="btn btn-secondary">
            Annuler
          </a>
        </div>

      </form>
    </div>
  </div>
</div>

<script>
const selRole      = document.getElementById('sel-role');
const fieldAdmin   = document.getElementById('field-admin');
const fieldMedecin = document.getElementById('field-medecin');
const infoAdmin    = document.getElementById('info-admin');
const infoMedecin  = document.getElementById('info-medecin');
const inputDir     = fieldAdmin.querySelector('input[name="id_direction"]');
const inputOrdre   = fieldMedecin.querySelector('input[name="numero_ordre_medical"]');

function updateFields() {
    const val = selRole.value;
    fieldAdmin.style.display   = val === '2' ? 'block' : 'none';
    fieldMedecin.style.display = val === '3' ? 'block' : 'none';
    infoAdmin.style.display    = val === '2' ? 'block' : 'none';
    infoMedecin.style.display  = val === '3' ? 'block' : 'none';
    inputDir.required   = val === '2';
    inputOrdre.required = val === '3';
}

selRole.addEventListener('change', updateFields);
updateFields();
</script>
</body>
</html>