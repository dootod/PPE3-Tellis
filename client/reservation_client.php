<?php
try {
    // Connexion à la base de données
    $bdd = new PDO('mysql:host=localhost;dbname=marché;charset=utf8', 'root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Active le mode erreur
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

// Vérifier que le paramètre 'username' est présent dans l'URL
if (!isset($_GET['username']) || empty($_GET['username'])) {
    die('Erreur : Identifiant manquant.');
}

$username = $_GET['username'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Réservation</title>
    <link rel="stylesheet" href="../css/style_reservation_client.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script>
        function confirmDelete(event){
            if (!confirm("Voulez-vous vraiment supprimer cette réservation ?")) {
                event.preventDefault();
            }
        }
    </script>
</head>
<body>
    <div class="content-wrap">
        <div class="wrapper">
            <h1> Vos réservations</h1>
            <table>
                <thead>
                    <tr>
                        <th>Jour de marché</th>
                        <th>Numéro d'emplacement</th>
                        <th>Modification</th>
                        <th>Suppression</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Préparer et exécuter la requête pour récupérer les réservations avec jointure
                    $query = $bdd->prepare("
                        SELECT j.jours_marche, s.id_emplacement, j.jours_marche
                        FROM reservation r
                        JOIN selectionner s ON r.id_reservation = s.id_reservation
                        JOIN jours_marche j ON r.id_jours_marche = j.id_jours_marche
                        JOIN commercant c ON r.id_commercant = c.id_commercant
                        WHERE c.login_profil = :username
                    ");
                    $query->execute(['username' => $username]);
                    $reservations = $query->fetchAll(PDO::FETCH_ASSOC);

                    // Afficher les réservations
                    if ($reservations) {
                        foreach ($reservations as $reservation) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($reservation['jours_marche']) . "</td>";
                            echo "<td>" . htmlspecialchars($reservation['id_emplacement']) . "</td>";
                            echo '<td><a href="modifier_reservation.php?id=' . htmlspecialchars($reservation['id_reservation']) . '" title="modifier la réservation"><img src="img/Modifier.png" alt="Modifier" /></a></td>';
                            echo '<td><a href="supprimer_reservation.php?id=' . htmlspecialchars($reservation['id_reservation']) . '" title="supprimer la réservation" onclick="confirmDelete(event)><img src="img/supprimer.png" alt="Supprimer" /></a></td>';
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>Aucune réservation trouvée</td></tr>";   
                    }
                    ?>
                </tbody>
            </table>
            <div style="text-align: center; margin-top: 20px;">
                 <a href="prendre_reservation.php" class="btn"> Prendre des réservations </a>
                 
            </div>       
        </div>
    </div>
</body>
</html>