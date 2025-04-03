<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['type_profil'] !== 'gestionnaire') {
    header('Location: index.php');
    exit();
}

// Connexion à la base de données
try {
    $bdd = new PDO('mysql:host=localhost;dbname=marché;charset=utf8', 'root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

// Récupération des jours de marché
$req = $bdd->query('SELECT * FROM jours_marche ORDER BY jours_marche ASC');
$jours_marche = $req->fetchAll();
$req->closeCursor();
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
                <i class="fa-solid fa-house-user logo"></i>
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
                        <a class="nav-link" href="../gestionnaire/gestion_jours_marché.php">Gestion jour</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-10 content-1">
                <h1 class="titre text-center mb-4">
                    Bienvenue dans l'espace gestionnaire <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong> !
                </h1>
                
                <div class="table-responsive">
                    <table class="table table-dark table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Semaine</th>
                                <th scope="col">Jour de marché</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($jours_marche as $jour): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($jour['id_jours_marche']); ?></td>
                                <td><?php echo htmlspecialchars($jour['semaines_jours_marche']); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($jour['jours_marche'])); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="text-center mt-4">
                    <a href="../gestionnaire/gestion_jours_marché.php" class="btn btn-success">
                        <i class="fas fa-plus"></i> Ajouter un jour de marché
                    </a>
                </div>
                
                <p class="p-content-1 mt-4 text-center">
                    Vous êtes maintenant connecté sur votre compte gestionnaire et 
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