<?php
session_start();
try {
    // Connexion à la base de données
    $bdd = new PDO('mysql:host=localhost;dbname=marché;charset=utf8', 'root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Active le mode erreur
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

// Variables pour afficher les messages
$successa = "";
$errora = "";
$successb = "";
$errorb = "";

// Vérifier si le formulaire est soumis pour l'ajout
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_date'])) {
    // Récupérer la date du formulaire
    $date = $_POST["date_marche"];  // Format: YYYY-MM-DD

    // Vérifier que la date n'est pas vide et qu'elle est valide
    if (!empty($date) && strtotime($date)) {
        $timestamp = strtotime($date);
        $semaine = date("W", $timestamp);  // "W" : numéro de la semaine

        // Échapper les valeurs pour éviter les injections SQL
        $date = $bdd->quote($date);
        $semaine = $bdd->quote($semaine);

        // Vérifier si la date existe déjà
        $checkSql = "SELECT COUNT(*) FROM jours_marche WHERE jours_marche = $date";
        $stmt = $bdd->query($checkSql);
        $count = $stmt->fetchColumn();

        if ($count == 0) {
            // Requête avec query()
            $sql = "INSERT INTO jours_marche (jours_marche, semaines_jours_marche) VALUES ($date, $semaine)";

            // Exécuter la requête
            if ($bdd->query($sql)) {
                $successa = "Le jour de marché a bien été ajouté.";
            } else {
                $errora = "Erreur : " . implode(" ", $bdd->errorInfo());
            }
        } else {
            $errora = "Erreur : Cette date existe déjà.";
        }
    } else {
        $errora = "Erreur : Veillez rentrer une date.";
    }
}

// Vérifier si le formulaire est soumis pour la suppression
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_date'])) {
    // Récupérer la date du formulaire
    $date = $_POST["date_marche"];  // Format: YYYY-MM-DD

    // Vérifier que la date n'est pas vide et qu'elle est valide
    if (!empty($date) && strtotime($date)) {
        $timestamp = strtotime($date);
        $semaine = date("W", $timestamp);  // "W" : numéro de la semaine

        // Échapper les valeurs pour éviter les injections SQL
        $date = $bdd->quote($date);
        $semaine = $bdd->quote($semaine);

        // Vérifier si la date existe déjà
        $checkSql = "SELECT COUNT(*) FROM jours_marche WHERE jours_marche = $date";
        $stmt = $bdd->query($checkSql);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            // Requête avec query()
            $sql = "DELETE FROM jours_marche WHERE jours_marche = $date";

            // Exécuter la requête
            if ($bdd->query($sql)) {
                $successb = "Le jour de marché a bien été supprimé.";
            } else {
                $errorb = "Erreur : " . implode(" ", $bdd->errorInfo());
            }
        } else {
            $errorb = "Erreur : Cette date n'existe pas.";
        }
    } else {
        $errorb = "Erreur : Veillez rentrer une date.";
    }
}

// Fermeture de la connexion PDO
$bdd = null;
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout et Suppression de jour de marché</title>
    <link rel="stylesheet" href="../css/style_gestion_jours_marche.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/298ba219c7.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" href="../php/gestionnaire.php">
                <i class="fa-solid fa-house-user logo"></i> <!-- Logo avec classe "logo" -->
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="../php/gestionnaire.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Gestion jour</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <main>
        <div class="content-wrap">
            <div class="wrapper">
                <h1> Ajouter des jour de marché</h1>
                <?php if ($successa): ?>
                    <p style="color: rgb(167, 223, 167);"><?php echo $successa; ?></p>
                <?php endif; ?>

                <?php if ($errora): ?>
                    <p style="color: red;"><?php echo $errora; ?></p>
                <?php endif; ?>
                <form action="" method="post">
                    <div class="input-box">
                        <label for="date">Date :</label>
                        <input type="date" id="date" name="date_marche" />
                    </div>

                    <button type="submit" class="btn" name="add_date">Ajouter</button>

                </form>
            </div>
        </div>

        <div class="content-wrap">
            <div class="wrapper">
                <h1> Supprimer un jour de marché</h1>
                <?php if ($successb): ?>
                    <p style="color: rgb(167, 223, 167);"><?php echo $successb; ?></p>
                <?php endif; ?>

                <?php if ($errorb): ?>
                    <p style="color: red;"><?php echo $errorb; ?></p>
                <?php endif; ?>
                <form action="" method="post">
                    <div class="input-box">
                        <label for="date">Date :</label>
                        <input type="date" id="date" name="date_marche" />
                    </div>

                    <button type="submit" class="btn" name="delete_date">Supprimer</button>

                </form>
            </div>
        </div>

        <footer>
            © 2025 Tellis. Tous droits réservés.
        </footer>
    </main>
</body>

</html>