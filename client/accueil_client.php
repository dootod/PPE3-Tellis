<?php
try {
    // Connexion à la base de données
    $bdd = new PDO('mysql:host=localhost;dbname=marché;charset=utf8', 'root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Active le mode erreur
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

// Récupérer les jours de marché disponibles et les trier par ordre croissant
$query = $bdd->prepare("SELECT jours_marche FROM jours_marche ORDER BY jours_marche ASC");
$query->execute();
$jours_marche = $query->fetchAll(PDO::FETCH_ASSOC);

// Définir la locale en français pour les dates
setlocale(LC_TIME, 'fr_FR.UTF-8');
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="../css/style_accueil_client.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <meta http-equiv="refresh" content="5"> <!-- Actualiser la page toutes les 5 secondes -->
    <script src="https://kit.fontawesome.com/298ba219c7.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
                        <a class="nav-link active" aria-current="page" href="accueil_client.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="gestion_reservation_client.php">Modifier réservation</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../emplacement_client.html">Prendre des réservations</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        <h1>Bienvenue dans votre espace</h1>
        <div class="wrapper">
            <table>
                <thead>
                    <tr>
                        <th>
                            <h1>Jours de marché disponibles</h1>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($jours_marche)) : ?>
                        <tr>
                            <td>Aucun jour de marché disponible pour le moment.</td>
                        </tr>
                    <?php else : ?>
                        <?php
                        $formatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::NONE, 'Europe/Paris', IntlDateFormatter::GREGORIAN, 'd MMMM yyyy');
                        foreach ($jours_marche as $jour) : ?>
                            <tr class="date">
                                <td>
                                    <?php
                                    $date = new DateTime($jour['jours_marche']);
                                    echo $formatter->format($date);
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            <div style="text-align: center; margin-top: 20px;" class="btn">
                <a href="../emplacement_client.html" style="text-decoration: none; color: black;">Prendre des réservations</a>
            </div>
            <div style="text-align: center; margin-top: 50px;" class="btn">
                <a href="gestion_reservation_client.php" style="text-decoration: none; color: black;">Modifier mes réservations</a>
            </div>
        </div>
    </main>
</body>

</html>