<?php
// Connexion à la base de données
if (file_exists("connexion-plesk.php")){
    include("connexion-plesk.php");
    $mysqli = new mysqli($server, $username,$password , $database);
}
    else
        $mysqli = new mysqli("localhost", "root", "", "moduleconnexion");

if ($mysqli->connect_error) {
    die("Erreur de connexion : " . $mysqli->connect_error);
}

$message = "";

// Si le formulaire est soumis
if (isset($_POST['submit'])) {
    $login = $_POST['login'];
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Vérification que les deux mots de passe sont identiques
    if ($password === $confirm_password) {
        // Hachage du mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Requête d'insertion
        $stmt = $mysqli->prepare("INSERT INTO utilisateurs (login, prenom, nom, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $login, $prenom, $nom, $hashedPassword);

        if ($stmt->execute()) {
            // Redirection vers la page de connexion
            header("Location: connexion.php");
            exit();
        } else {
            $message = "Erreur lors de l'inscription.";
        }

        $stmt->close();
    } else {
        $message = "Les mots de passe ne correspondent pas.";
    }
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
</head>
<body>
    <h2>Formulaire d'inscription</h2>
    <form method="POST" action="">
        <label>Login :</label><br>
        <input type="text" name="login" required><br><br>

        <label>Prénom :</label><br>
        <input type="text" name="prenom" required><br><br>

        <label>Nom :</label><br>
        <input type="text" name="nom" required><br><br>

        <label>Mot de passe :</label><br>
        <input type="password" name="password" required><br><br>

        <label>Confirmation du mot de passe :</label><br>
        <input type="password" name="confirm_password" required><br><br>

        <input type="submit" name="submit" value="S'inscrire">
    </form>

    <p style="color:red;"><?php echo $message; ?></p>
</body>
</html>
