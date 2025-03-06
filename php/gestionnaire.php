<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['type_profil'] !== 'gestionnaire') {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace gestionnaire</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style_gestionnaire.css">
    <script src="https://kit.fontawesome.com/298ba219c7.js" crossorigin="anonymous"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fa-solid fa-house-user logo"></i> <!-- Logo avec classe "logo" -->
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Gestion jour</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Gestion emplacement</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Gestion reservation</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="row justify-content-center">
            <div class="col-md-8 content-1 text-center">
                <h1 class="titre">
                    Bienvenue dans l'espace gestionnaire <?php echo htmlspecialchars($_SESSION['username']); ?> !
                </h1>
                <p class="p-content-1">Vous êtes maintenant connecté sur votre compte gestionnaire et 
                    donc vous pouvez gérer les jours, les emplacements et les reservations.
                </p>
            </div>
        </div>
    </div>

    <footer>
        © 2025 Tellis. Tous droits réservés.
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>