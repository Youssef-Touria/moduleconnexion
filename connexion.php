<?php
session_start();

// Connexion à la base de données
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
    $password = $_POST['password'];

    // Vérifie si l'utilisateur existe
    $stmt = $mysqli->prepare("SELECT * FROM utilisateurs WHERE login = ?");
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $result = $stmt->get_result();

    // Si un utilisateur est trouvé
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Vérifie le mot de passe
        if (password_verify($password, $user['password'])) {
            // Crée des variables de session
            $_SESSION['id'] = $user['id'];
            $_SESSION['login'] = $user['login'];
            $_SESSION['prenom'] = $user['prenom'];
            $_SESSION['nom'] = $user['nom'];

            // Redirection vers la page d’accueil
            header("Location: index.php");
            exit();
        } else {
            $message = "Mot de passe incorrect.";
        }
    } else {
        $message = "Login introuvable.";
    }

    $stmt->close();
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
</head>
<body>
    <h2>Connexion</h2>
    <form method="POST" action="">
        <label>Login :</label><br>
        <input type="text" name="login" required><br><br>

        <label>Mot de passe :</label><br>
        <input type="password" name="password" required><br><br>

        <input type="submit" name="submit" value="Se connecter">
    </form>

    <p style="color:red;"><?php echo $message; ?></p>
</body>
</html>
