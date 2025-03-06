<!-- Cette page nous sert uniquement pour créer des comptes gestionnaires et seulement les administrateurs 
(donc Thomas, Maxen, Rayan et Gaëlle pourrons l'utiliser) -->

<?php
session_start();

try {
    // Connexion à la base de données
    $bdd = new PDO('mysql:host=localhost;dbname=marché;charset=utf8', 'root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Vérification si l'utilisateur existe déjà
    $query = $bdd->prepare("SELECT * FROM profil WHERE login_profil = :username");
    $query->execute(['username' => $username]);
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $error_message = "Cet identifiant est déjà utilisé.";
    } else {
        // Hachage du mot de passe
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insertion du nouvel utilisateur dans la base de données
        $query = $bdd->prepare("INSERT INTO profil (login_profil, password_profil, typeprofil_profil) 
                                VALUES (:username, :password, :profile_type)");
        $query->execute([
            'username' => $username,
            'password' => $hashed_password,
            'profile_type' => 'gestionnaire'
        ]);

        // Redirection vers la page de connexion
        header('Location: index.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Marché de Nantes</title>
    <link rel="stylesheet" href="../css/style_inscription.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="page-container">
        <div class="content-wrap">
            <div class="wrapper">
                <form action="" method="POST">
                    <h1>Inscription pour les gestionnaires</h1>
                    <?php if (!empty($error_message)): ?>
                        <p style="color: red; text-align: center;"><?php echo $error_message; ?></p>
                    <?php endif; ?>
                    <div class="input-box">
                        <input type="text" name="username" placeholder="Identifiant" required>
                        <i class='bx bxs-user'></i>
                    </div>
                    <div class="input-box">
                        <input type="email" placeholder="Mail">
                        <i class='bx bxs-envelope'></i>
                    </div>
                    <div class="input-box">
                        <input type="password" name="password" placeholder="Mot de passe" required>
                        <i class='bx bxs-lock-alt'></i>
                    </div>
                    <button type="submit" class="btn">S'inscrire</button>
                    <div class="register-link">
                        <p>Déjà inscrit ? <a href="index.php">Retour au login !</a></p>
                    </div>
                </form>
            </div>
        </div>
        <footer>
            © 2025 Tellis. Tous droits réservés.
        </footer>
    </div>
</body>
</html>