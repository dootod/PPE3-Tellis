<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="styless.css" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/298ba219c7.js" crossorigin="anonymous"></script>
    <title>Mesure Stand</title>
    <style>
        /* Style supplémentaire pour le nouveau champ */
        .magic-form .input-group {
            margin-bottom: 20px;
        }
        
        .magic-form .input-label {
            display: block;
            margin-bottom: 8px;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
            text-align: left;
            padding-left: 15px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" href="php/gestionnaire.php">
                <i class="fa-solid fa-house-user logo"></i>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="php/gestionnaire.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="essai.php">Taille emplacement</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="main">
        <div class="form">
            <form method="post" action="" class="magic-form">
                <h3>Mesures du Stand</h3>
                
                <!-- Nouveau champ pour le numéro de jour marché -->
                <div class="input-group">
                    <label for="id_jour" class="input-label">Numéro du jour marché</label>
                    <input type="number" name="id_jour" id="id_jour" class="magic-input" placeholder="ID du jour marché" required/>
                </div>
                
                <div class="input-group">
                    <label for="length" class="input-label">Longueur</label>
                    <input type="number" step="0.01" name="length" id="length" class="magic-input" placeholder="Longueur (mètres)" required/>
                </div>
                
                <div class="input-group">
                    <label for="width" class="input-label">Largeur</label>
                    <input type="number" step="0.01" name="width" id="width" class="magic-input" placeholder="Largeur (mètres)" required/>
                </div>
                
                <button type="submit" class="magic-btn">Calculer la Surface</button>
                
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["length"]) && isset($_POST["width"]) && isset($_POST["id_jour"])) {
                    $longueur = $_POST["length"];
                    $largeur = $_POST["width"];
                    $id_jour = $_POST["id_jour"];
                    $taille = $longueur * $largeur;
                    
                    if ($taille > 25) {
                        echo '<div class="result-message error">';
                        echo '<i class="fas fa-exclamation-circle"></i> Votre stand est trop grand ('.$taille.'m²). La taille maximale est de 25m².';
                        echo '</div>';
                    } else {
                        echo '<div class="result-message success">';
                        echo '<i class="fas fa-check-circle"></i> Félicitations! Votre stand de '.$taille.'m² a été enregistré.';
                        echo '</div>';
                        
                        try {
                            $connexion = new PDO('mysql:host=localhost;dbname=marché', 'root', '');
                            $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            
                            $query = $connexion->prepare("INSERT INTO emplacement (id_emplacement, longueur_emplacement, largeur_emplacement, taille_emplacement) VALUES (:id_jour, :longueur, :largeur, :taille)");
                            $query->execute([
                                ':id_jour' => $id_jour,
                                ':longueur' => $longueur,
                                ':largeur' => $largeur,
                                ':taille' => $taille
                            ]);
                        } catch (Exception $e) {
                            echo '<div class="result-message error">';
                            echo '<i class="fas fa-times-circle"></i> Erreur: '.$e->getMessage();
                            echo '</div>';
                        }
                    }
                }
                ?>
            </form>
        </div>
    </div>
    
    <footer>
        © 2025 Tellis. Tous droits réservés.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>