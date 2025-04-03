<?php
try {
    //Connexion à la base de données
    $bdd = new PDO('mysql:host=localhost;dbname=marché;charset=utf8', 'root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Active le mode erreur
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

// Variables pour afficher les messages
$success = "";
$error = "";

// Vérifier si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Récupérer le login du formulaire
    $username = $_POST["username"];

    // Vérifier que le login n'est pas vide
    if (!empty($username)) {
        // Échapper les valeurs pour éviter les injections SQL
        $username = $bdd->quote($username);

        // Vérifier si le login existe
        $checkSql = "SELECT COUNT(*) FROM profil WHERE login_profil = $username";
        $stmt = $bdd->query($checkSql);
        $count = $stmt->fetchColumn();

        if ($count == 1) {
            // Rediriger vers la page de gestion des réservations
            header('Location: reservation_client.php?username=' . $username);
            exit();
        } else {
            $error = "Erreur : Identifiant incorrect.";
        }
    } else {
        $error = "Erreur : Veuillez entrer un identifiant.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Réservation</title>
    <link rel="stylesheet" href="../css/style_gestion_reservation_client.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/298ba219c7.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" href="accueil_client.php">
                <i class="fa-solid fa-house-user logo"></i> <!-- Logo avec classe "logo" -->
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="accueil_client.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="gestion_reservation_client.php">Modifier réservation</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../emplacement_client.php">Prendre des réservations</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <main>
        <div class="content-wrap">
            <div class="wrapper">
                <?php if ($success): ?>
                    <p style="color: rgb(167, 223, 167);"><?php echo $success; ?></p>
                <?php endif; ?>
                <?php if ($error): ?>
                    <p style="color: red;"><?php echo $error; ?></p>
                <?php endif; ?>
                <h1> Accéder à vos réservations</h1>
                <p>Entrez votre identifiant pour accéder à vos réservations.</p>
                <form action="" method="post">
                    <div class="input-box">
                        <label for="text">Entrer login : </label>
                        <input type="text" name="username" id="username" placeholder="Identifiant" required />
                    </div>

                    <button type="submit" class="btn" name="submit">Entrer</button>

                </form>
            </div>
    </main>
</body>

</html>