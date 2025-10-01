<?php if (session_status() == PHP_SESSION_NONE) {
  session_start();
} ?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Accueil</title>
  <link rel="stylesheet" href="style.css"> <!-- optionnel si tu as un CSS -->
</head>

<body>
  <h1>Bienvenue sur notre site !</h1>
  <?php if (isset($_SESSION['login']))
    echo "Bonjour " . $_SESSION['login']; ?>
  <nav>
    <a href="index.php">Accueil</a>
    <a href="inscription.php">S’inscrire</a>
    <a href="connexion.php">Se connecter</a>
    <?php if (isset($_SESSION['login']))
      echo '<a href="deconnexion.php">Se deconnecter</a>'; ?>
  </nav>
</body>

</html>