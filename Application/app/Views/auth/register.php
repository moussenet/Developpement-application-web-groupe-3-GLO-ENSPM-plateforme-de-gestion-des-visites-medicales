<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= esc($title) ?></title>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: system-ui, sans-serif; background: #f0f2f5; min-height: 100vh;
           display: flex; align-items: center; justify-content: center; padding: 24px 12px; }
    .card { background: #fff; border-radius: 12px; padding: 34px 30px;
            width: 100%; max-width: 540px; box-shadow: 0 2px 12px rgba(0,0,0,.08); }
    .brand { text-align: center; margin-bottom: 6px; }
    .brand img { width: 84px; height: 84px; object-fit: contain; display: block;
                 margin: 0 auto 10px; border-radius: 50%; border: 2px solid #e0e0e0; }
    .brand .name { font-size: 15px; font-weight: 700; color: #1a1917; line-height: 1.3; }
    .subtitle { text-align: center; font-size: 13px; color: #666; margin-bottom: 22px; }
    .section-label { font-size: 11px; font-weight: 600; color: #aaa;
                     text-transform: uppercase; letter-spacing: .5px;
                     margin-bottom: 10px; margin-top: 4px; }
    .divider { height: 1px; background: #f0f0f0; margin: 16px 0; }
    label { display: block; font-size: 12px; font-weight: 500; color: #555; margin-bottom: 4px; }
    input, select { width: 100%; padding: 10px 12px; border: 1.5px solid #e0e0e0;
                    border-radius: 8px; font-size: 13px; outline: none;
                    transition: border-color .15s; background: #fff; color: #1a1917; }
    input:focus, select:focus { border-color: #0F6E56;
                                box-shadow: 0 0 0 3px rgba(15,110,86,0.08); }
    input.error, select.error { border-color: #A32D2D; }
    .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .group { margin-bottom: 13px; }
    .hint { font-size: 11px; color: #aaa; margin-top: 3px; }
    .btn { width: 100%; padding: 12px; background: #0F6E56; color: #fff; border: none;
           border-radius: 8px; font-size: 15px; font-weight: 600; cursor: pointer;
           margin-top: 6px; transition: background .15s; }
    .btn:hover { background: #1D9E75; }
    .alert { padding: 10px 13px; border-radius: 8px; font-size: 13px; margin-bottom: 16px; }
    .alert-error   { background: #FCEBEB; color: #A32D2D; border-left: 3px solid #A32D2D; }
    .alert-success { background: #E1F5EE; color: #085041; border-left: 3px solid #0F6E56; }
    .alert-error ul { padding-left: 16px; margin-top: 4px; }
    .link { text-align: center; margin-top: 18px; font-size: 13px; color: #777; }
    .link a { color: #0F6E56; text-decoration: none; font-weight: 600; }
    .link a:hover { text-decoration: underline; }
    .required { color: #A32D2D; margin-left: 2px; }
    select option[value=""] { color: #aaa; }
    @media (max-width: 520px) { .grid { grid-template-columns: 1fr; } }
  </style>
</head>
<body>
<div class="card">

  <div class="brand">
    <img src="http://localhost:8080/img/logo.jpg" alt="Logo ENSPM">
    <div class="name">Centre Médico-Sanitaire — ENSPM</div>
  </div>
  <div class="subtitle">Inscription étudiant</div>

  <?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-error">
      <ul>
        <?php foreach (session()->getFlashdata('errors') as $e): ?>
          <li><?= esc($e) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-error"><?= esc(session()->getFlashdata('error')) ?></div>
  <?php endif; ?>

  <form action="<?= base_url('register') ?>" method="post" autocomplete="off">
    <?= csrf_field() ?>

    <!-- IDENTITÉ -->
    <div class="section-label">Identité</div>
    <div class="grid">
      <div class="group">
        <label>Nom <span class="required">*</span></label>
        <input type="text" name="nom"
               value="<?= set_value('nom') ?>"
               required>
      </div>
      <div class="group">
        <label>Prénom <span class="required">*</span></label>
        <input type="text" name="prenom"
               value="<?= set_value('prenom') ?>"
               required>
      </div>
    </div>

    <div class="group">
      <label>Matricule universitaire <span class="required">*</span></label>
      <input type="text" name="matricule"
             value="<?= set_value('matricule') ?>"
             required>
      <div class="hint">Tel qu'il figure sur votre carte étudiante</div>
    </div>

    <div class="divider"></div>

    <!-- PARCOURS -->
    <div class="section-label">Parcours académique</div>
    <div class="grid">
      <div class="group">
        <label>Département <span class="required">*</span></label>
        <select name="departement" id="sel-departement" required>
          <option value="" disabled <?= set_value('departement') ? '' : 'selected' ?>>
            Choisir...
          </option>
          <?php foreach (($departements ?? []) as $d): ?>
            <option value="<?= esc($d) ?>" <?= set_select('departement', $d) ?>>
              <?= esc($d) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="group">
        <label>Filière <span class="required">*</span></label>
        <select name="filiere" id="sel-filiere" required>
          <option value="" disabled selected>Choisir un département d'abord</option>
          <?php
            // Pré-remplir si retour erreur
            $depSel = set_value('departement');
            $filSel = set_value('filiere');
            if ($depSel && isset($filieres[$depSel])):
              foreach ($filieres[$depSel] as $f):
          ?>
            <option value="<?= esc($f) ?>" <?= $filSel === $f ? 'selected' : '' ?>>
              <?= esc($f) ?>
            </option>
          <?php endforeach; endif; ?>
        </select>
      </div>
    </div>

    <div class="divider"></div>

    <!-- COMPTE -->
    <div class="section-label">Accès au compte</div>
    <div class="group">
      <label>Adresse email <span class="required">*</span></label>
      <input type="email" name="email"
             value="<?= set_value('email') ?>"
             placeholder="exemple@gmail.com"
             required>
    </div>

    <div class="grid">
      <div class="group">
        <label>Mot de passe <span class="required">*</span></label>
        <input type="password" name="password"
               required minlength="8">
        <div class="hint">Minimum 8 caractères</div>
      </div>
      <div class="group">
        <label>Confirmer le mot de passe <span class="required">*</span></label>
        <input type="password" name="confirm_password"
               
               required>
      </div>
    </div>

    <button type="submit" class="btn">Créer mon compte</button>
  </form>

  <div class="link">
    Déjà un compte ? <a href="<?= base_url('login') ?>">Se connecter</a>
  </div>

</div>

<script>
const filieres = <?= json_encode($filieres ?? []) ?>;
const selDep   = document.getElementById('sel-departement');
const selFil   = document.getElementById('sel-filiere');

selDep.addEventListener('change', function () {
  const dep = this.value;
  selFil.innerHTML = '<option value="" disabled selected>Choisir...</option>';
  if (dep && filieres[dep]) {
    filieres[dep].forEach(function (f) {
      const opt = document.createElement('option');
      opt.value       = f;
      opt.textContent = f;
      selFil.appendChild(opt);
    });
    selFil.disabled = false;
  } else {
    selFil.disabled = true;
  }
});

// Désactiver filière au chargement si aucun département sélectionné
if (! selDep.value) selFil.disabled = true;
</script>
</body>
</html>