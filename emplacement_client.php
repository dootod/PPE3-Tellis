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

// Vérifier si le formulaire est soumis pour l'ajout
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_date'])) {
    // Récupérer la date du formulaire
    $date = $_POST["date_marche"];  // Format: YYYY-MM-DD

    // Vérifier que la date n'est pas vide et qu'elle est valide
    if (!empty($date) || strtotime($date)) {
        $timestamp = strtotime($date);
        $semaine = date("W", $timestamp);  // "W" : numéro de la semaine
        $emplacement = $_POST["emplacement"];
        $commercant = $_POST["commercant"];
        // Échapper les valeurs pour éviter les injections SQL
        $date = $bdd->quote($date);
        $semaine = $bdd->quote($semaine);

        // Vérifier si la date existe déjà
        $checkSql = "SELECT COUNT(*) FROM jours_marche WHERE jours_marche = $date";
        $stmt = $bdd->query($checkSql);
        $count = $stmt->fetchColumn();
        // Permet de verifie si l'emplacement est deja pris
        $mult_emplacement = "SELECT COUNT(*) FROM selectionner WHERE id_emplacement = $emplacement";
        $intermediaire = $bdd->query($mult_emplacement);
        $suprim_emplacement = $intermediaire->fetchColumn();

        if ($suprim_emplacement != 0){
            $errora = "Erreur, Cette emplacement n'est pas disponible ce jour.";
        }

        if ($count == 0) {
            $errora = "Cette date n'existe pas.";
        } else {
            $reservation = "INSERT INTO reservation (id_jours_marche, id_commercant) VALUES ($date, $commercant)";
            $sql = "INSERT INTO selectionner (id_emplacement, id_commercant) VALUES ($emplacement, $commercant)";
        }
    } else {
        $errora = "Erreur : Veillez rentrer une date.";
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
    <title>Réservation des Places de Marché</title>
    <link rel="stylesheet" href="emplacement.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/298ba219c7.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" href="client/accueil_client.php">
                <i class="fa-solid fa-house-user logo"></i> <!-- Logo avec classe "logo" -->
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="client/accueil_client.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="emplacement_client.php">Prendre des réservations</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    </header>
    <main>
        <h2>Réserver votre place de marché en cliquant sur les emplacements ci-dessous</h2>
        <div class="market-map">
            <div class="place very-long-rectangle" data-place="1">1</div>
            <div class="place very-long-rectangle" data-place="2">2</div>
            <div class="place very-long-rectangle" data-place="3">3</div>
            <div class="place rectangle-haut" data-place="4">4</div>
            <div class="place rectangle-haut" data-place="5">5</div>
            <div class="place long-rectangle" data-place="6">6</div>
            <div class="place rectangle" data-place="7">7</div>
            <div class="place rectangle-haut" data-place="8">8</div>
            <div class="place rectangle-haut" data-place="9">9</div>
            <div class="place circle" data-place="10">10</div>
            <div class="place square" data-place="11">11</div>
            <div class="place square" data-place="12">12</div>
            <div class="place circle" data-place="13">13</div>
            <div class="place long-rectangle" data-place="14">14</div>
            <div class="place very-long-rectangle" data-place="15">15</div>
        </div>
        <div class="reserve-button-container">
            <button id="reserve-btn">Réserver les places sélectionnées</button>
        </div>

        <!-- Fenêtre modale pour sélectionner la date -->
        <div id="date-modal" style="display: none;">
            <label for="reservation-date">Sélectionnez la date de votre visite:</label>
            <input type="date" id="reservation-date" name="date_marche">
            <button id="confirm-date-btn">Confirmer la date</button>
        </div>
    </main>
    <script>
        // Attendre que le DOM soit complètement chargé
        document.addEventListener('DOMContentLoaded', function() {
            let selectedPlaces = [];
            const reserveBtn = document.getElementById('reserve-btn');
            const places = document.querySelectorAll('.place');
        
            // Cacher le bouton de réservation initialement
            reserveBtn.style.display = 'none';
        
            // Ajouter un événement click à chaque emplacement
            places.forEach(place => {
                place.addEventListener('click', function() {
                    const placeId = this.getAttribute('data-place');
                
                    // Vérifier si l'emplacement est déjà sélectionné
                    if (this.classList.contains('selected')) {
                        // Désélectionner
                        this.classList.remove('selected');
                        selectedPlaces = selectedPlaces.filter(id => id !== placeId);
                    } else {
                        // Vérifier qu'on ne dépasse pas la limite de 2 emplacements
                        if (selectedPlaces.length < 2) {
                            // Sélectionner
                            this.classList.add('selected');
                            selectedPlaces.push(placeId);
                        } else {
                            alert('Vous ne pouvez sélectionner que 2 emplacements maximum.');
                            return;
                        }
                    }
                
                    // Afficher ou cacher le bouton de réservation
                    reserveBtn.style.display = selectedPlaces.length > 0 ? 'block' : 'none';
                
                    console.log('Emplacements sélectionnés:', selectedPlaces);
                });
            });
        
            // Gérer le clic sur le bouton de réservation
            reserveBtn.addEventListener('click', function() {
                document.getElementById('date-modal').style.display = 'block';
            });
        
            // Gérer la confirmation de date
            document.getElementById('confirm-date-btn').addEventListener('click', function() {
                const date = document.getElementById('reservation-date').value;
            
                if (!date) {
                    alert('Veuillez sélectionner une date.');
                    return;
                }
            
                // Ici vous pouvez ajouter le code pour envoyer la réservation au serveur
                console.log(`Réservation confirmée pour le ${date} sur les emplacements: ${selectedPlaces.join(', ')}`);
            
                // Réinitialiser l'interface
                document.getElementById('date-modal').style.display = 'none';
                document.querySelectorAll('.place').forEach(p => p.classList.remove('selected'));
                selectedPlaces = [];
                reserveBtn.style.display = 'none';
                document.getElementById('reservation-date').value = '';
            
                alert(`Réservation confirmée pour le ${date}!`);
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>