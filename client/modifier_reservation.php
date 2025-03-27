<?php
try {
    // Connexion à la base de données
    $bdd = new PDO('mysql:host=localhost;dbname=marché;charset=utf8', 'root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Active le mode erreur
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

// Vérifier que le paramètre 'id' est présent dans l'URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('Erreur : Identifiant de réservation manquant.');
}

$id_reservation = $_GET['id'];

// Récupérer les informations de la réservation
$query = $bdd->prepare("SELECT * FROM reservation WHERE id_reservation = :id_reservation");
$query->execute(['id_reservation' => $id_reservation]);
$reservation = $query->fetch(PDO::FETCH_ASSOC);

if (!$reservation) {
    die('Erreur : Réservation non trouvée.');
}

// Mettre à jour la réservation si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jours_marche = $_POST['jours_marche'];
    $id_emplacement = $_POST['id_emplacement'];

    $query = $bdd->prepare("
        UPDATE reservation
        SET jours_marche = :jours_marche, id_emplacement = :id_emplacement
        WHERE id_reservation = :id_reservation
    ");
    $query->execute([
        'jours_marche' => $jours_marche,
        'id_emplacement' => $id_emplacement,
        'id_reservation' => $id_reservation
    ]);

    // Rediriger vers la page de gestion des réservations
    header('Location: reservation_client.php?username=' . urlencode($_GET['username']));
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Réservation</title>
    <link rel="stylesheet" href="../css/style_reservation_client.css">
</head>
<body>
    <div class="content-wrap">
        <div class="wrapper">
            <h1>Modifier Réservation</h1>
            <form method="post">
                <div>
                    <label for="jours_marche">Jour de marché :</label>
                    <input type="text" id="jours_marche" name="jours_marche" value="<?php echo htmlspecialchars($reservation['jours_marche']); ?>" required>
                </div>
                <div>
                    <label for="id_emplacement">Numéro d'emplacement :</label>
                    <input type="text" id="id_emplacement" name="id_emplacement" value="<?php echo htmlspecialchars($reservation['id_emplacement']); ?>" required>
                </div>
                <div>
                    <button type="submit" class="btn">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>