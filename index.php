<?php
// Toujours démarrer la session AVANT tout HTML
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Indique si l'utilisateur est connecté
$isAuth = !empty($_SESSION['login']);
$login  = $isAuth ? htmlspecialchars($_SESSION['login'], ENT_QUOTES, 'UTF-8') : null;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Accueil</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>Bienvenue sur notre site !</h1>

  <?php if ($isAuth): ?>
    <p>Bonjour <?= $login; ?> 👋</p>
  <?php endif; ?>

  <nav>
    <a href="index.php">Accueil</a>

    <?php if (!$isAuth): ?>
      <a href="inscription.php">S'inscrire</a>
      <a href="connexion.php">Se connecter</a>
    <?php else: ?>
      <a href="profil.php">Mon profil</a>
      <a href="deconnexion.php">Se déconnecter</a>
    <?php endif; ?>
  </nav>
</body>
</html>
