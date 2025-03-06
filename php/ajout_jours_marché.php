<?php
try {
    // Connexion à la base de données
    $bdd = new PDO('mysql:host=localhost;dbname=marché;charset=utf8', 'root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Active le mode erreur
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

// Variables pour afficher les messages
$success = "";
$error = "";

// Vérifier si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
                $success = "Le jour de marché a bien été ajouté.";
            } else {
                $error = "Erreur : " . implode(" ", $bdd->errorInfo());
            }
        } else {
            $error = "Erreur : Cette date existe déjà.";
        }
    } else {
        $error = "Erreur : Veillez rentrer une date.";
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
    <title>Ajout de jour de marché</title>
    <link rel="stylesheet" href="css/style_ajout_marche.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="content-wrap">
        <div class="wrapper">
            <h1> Ajout de jour de marché</h1>
            <?php if ($success): ?>
                <p style="color: green;"><?php echo $success; ?></p>
            <?php endif; ?>

            <?php if ($error): ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php endif; ?>
                <form action="" method="post" >
                    <div class="input-box">
                        <label for="date">Date :</label>
                        <input type="date" id="date" name="date_marche" />
                    </div>
                    
                    <button type="submit" class="btn">Valider</button>
                    
                </form>
        </div>
    </div>
    
    <footer>
            © 2025 Tellis. Tous droits réservés.
    </footer>
</body>
</html>