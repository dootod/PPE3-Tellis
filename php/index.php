<?php
session_start();

try {
    $bdd = new PDO('mysql:host=localhost;dbname=marché', 'root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = $bdd->prepare("SELECT * FROM profil WHERE login_profil = :username AND password_profil = :password");
    $query->execute([
        'username' => $username,
        'password' => $password 
    ]);
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['username'] = $user['login_profil'];
        $_SESSION['type_profil'] = $user['typeprofil_profil'];

        if ($user['typeprofil_profil'] === 'commerçant') {
            header('Location: commercant.php');
            exit();
        } elseif ($user['typeprofil_profil'] === 'gestionnaire') {
            header('Location: gestionnaire.php');
            exit();
        }
    } else {
        $error_message = "Identifiant ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Marché de Nantes</title>
    <link rel="stylesheet" href="../css/style_index.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="page-container">
        <div class="content-wrap">
            <div class="container">
                <div class="left-content">
                    <h2>Bienvenue sur le site du marché de Nantes</h2>
                    <p>Découvrez notre plateforme et connectez-vous pour accéder à toutes nos fonctionnalités.</p>
                </div>
                <div class="wrapper">
                    <form action="" method="POST">
                        <h1>Login</h1>
                        <?php if (!empty($error_message)): ?>
                        <p style="color: red; text-align: center; padding-top: 20px;">
                            <?php echo $error_message; ?>
                        </p>
                        <?php endif; ?>
                        <div class="input-box">
                            <input type="text" name="username" id="username" placeholder="Identifiant" required>
                            <i class='bx bxs-user'></i>
                        </div>
                        <div class="input-box">
                            <input type="password" name="password" id="password" placeholder="Mot de passe" required>
                            <i class='bx bxs-lock-alt'></i>
                        </div>
                        <button type="submit" class="btn">Se connecter</button>
                        <div class="register-link">
                            <p>Pas de compte ? <a href="inscription.php">Inscrivez-vous !</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <footer>
            © 2025 Tellis. Tous droits réservés.
        </footer>
    </div>
</body>
</html>