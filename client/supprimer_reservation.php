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


// Supprimer la réservation de la base de données
$query = $bdd->prepare("DELETE FROM reservation WHERE id_reservation = :id_reservation");
$query->execute(['id_reservation' => $id_reservation]);

// Rediriger vers la page de gestion des réservations
header('Location: reservation_client.php?username=' . urlencode($_GET['username']));
exit();
?>