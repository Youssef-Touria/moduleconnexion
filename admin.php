<?php
session_start();

// Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['login'])) {
    header("Location: connexion.php");
    exit();
}

// Vérifie que l'utilisateur est bien "admin"
if ($_SESSION['login'] !== 'admin') {
    echo " Accès réservé à l'administrateur.";
    exit();
}

// Connexion à la base de données
if (file_exists("connexion-plesk.php")){
    include("connexion-plesk.php");
    $mysqli = new mysqli($server, $username, $password , $database);
}
    else
        $mysqli = new mysqli("localhost", "root", "", "moduleconnexion");

if ($mysqli->connect_error) {
    die("Erreur de connexion : " . $mysqli->connect_error);
}

// Récupère tous les utilisateurs
$result = $mysqli->query("SELECT * FROM utilisateurs");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Administration</title>
    <link rel="stylesheet" href="style.css"> <!-- tu peux personnaliser ce fichier CSS -->
</head>
<body>
    <h2>Espace Admin - Liste des utilisateurs</h2>
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Login</th>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Mot de passe (haché)</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($user = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo $user['login']; ?></td>
                    <td><?php echo $user['prenom']; ?></td>
                    <td><?php echo $user['nom']; ?></td>
                    <td><?php echo $user['password']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <p><a href="index.php">Retour à l'accueil</a></p>
</body>
</html>

<?php
$mysqli->close();
?>
