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
           .card {
  background: #fff;
  border-radius: 12px;
  padding: 34px 30px;
  width: 100%;
  max-width: 420px;
  box-shadow: 0 2px 12px rgba(0,0,0,.08);
  display: flex;
  flex-direction: column;
}
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
    input { width: 100%; padding: 10px 12px; border: 1.5px solid #e0e0e0;
            border-radius: 8px; font-size: 13px; outline: none;
            transition: border-color .15s; background: #fff; color: #1a1917; }
    input:focus { border-color: #0F6E56;
                  box-shadow: 0 0 0 3px rgba(15,110,86,0.08); }
    .group { margin-bottom: 13px; }
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
    .footer {
  text-align: center;
  margin-top: auto;
  padding-top: 16px;
  border-top: 1px solid #f0f0f0;
  font-size: 11px;
  color: #bbb;
}
  </style>
</head>
<body>
<div class="card">

  <div class="brand">
    <img src="<?= base_url('img/logo.jpg') ?>" alt="Logo ENSPM">
    <div class="name">Centre Médico-Sanitaire — ENSPM</div>
  </div>
  <div class="subtitle">Connexion à votre espace</div>

  <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-error"><?= esc(session()->getFlashdata('error')) ?></div>
  <?php endif; ?>

  <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
  <?php endif; ?>

  <?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-error">
      <ul>
        <?php foreach (session()->getFlashdata('errors') as $e): ?>
          <li><?= esc($e) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form action="<?= base_url('login') ?>" method="post" autocomplete="off">
    <?= csrf_field() ?>

    <div class="section-label">Identifiants</div>

    <div class="group">
      <label for="email">Adresse email</label>
      <input type="email"
             id="email"
             name="email"
             value="<?= set_value('email') ?>"
             placeholder="exemple@gmail.com"
             required
             autofocus>
    </div>

    <div class="group">
      <label for="password">Mot de passe</label>
      <input type="password"
             id="password"
             name="password"
             required>
    </div>

    <button type="submit" class="btn">Se connecter</button>
  </form>

  <div class="divider"></div>

  <div class="link">
    Pas encore de compte ?
    <a href="<?= base_url('register') ?>">S'inscrire</a>
  </div>

</div>

<div class="footer">
  &copy; <?= date('Y') ?> CMS-ENSPM — UMA
</div>

</body>
</html>