<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
} 

// Redirection si l'utilisateur n'est pas connecté
if (!isset($_SESSION['id'])) {
    header("Location: connexion.php");
    exit();
}


// Connexion à la base de données
if (file_exists("connexion-plesk.php")) {
    include("connexion-plesk.php");
    $mysqli = new mysqli($server, $username, $password, $database);
} else
    $mysqli = new mysqli("localhost", "root", "", "moduleconnexion");
if ($mysqli->connect_error) {
    die("Erreur de connexion : " . $mysqli->connect_error);
}

$message = "";

// Récupérer les infos actuelles depuis la BDD
$stmt = $mysqli->prepare("SELECT login, prenom, nom FROM utilisateurs WHERE id = ?");
$stmt->bind_param("i", $_SESSION['id']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Si formulaire soumis
if (isset($_POST['submit'])) {
    $login = $_POST['login'];
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];

    // Met à jour la BDD
    $stmt = $mysqli->prepare("UPDATE utilisateurs SET login = ?, prenom = ?, nom = ? WHERE id = ?");
    $stmt->bind_param("sssi", $login, $prenom, $nom, $_SESSION['id']);

    if ($stmt->execute()) {
        // Met à jour les infos de session
        $_SESSION['login'] = $login;
        $_SESSION['prenom'] = $prenom;
        $_SESSION['nom'] = $nom;
        $message = "Profil mis à jour avec succès.";
    } else {
        $message = "Erreur lors de la mise à jour.";
    }

    $stmt->close();
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Modifier le profil</title>
</head>

<body>
    <h2>Modifier mon profil</h2>

    <form method="POST" action="profil.php">
        <label>Login :</label><br>
        <input type="text" name="login" value="<?php echo htmlspecialchars($user['login']); ?>" required><br><br>

        <label>Prénom :</label><br>
        <input type="text" name="prenom" value="<?php echo htmlspecialchars($user['prenom']); ?>" required><br><br>

        <label>Nom :</label><br>
        <input type="text" name="nom" value="<?php echo htmlspecialchars($user['nom']); ?>" required><br><br>

        <input type="submit" name="submit" value="Mettre à jour">
    </form>

    <p style="color:green;"><?php echo $message; ?></p>

    <p><a href="index.php">Retour à l’accueil</a></p>
</body>

</html>