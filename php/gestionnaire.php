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
    <link rel="stylesheet" href="../css/style_gestionnaire.css">
    <script src="https://kit.fontawesome.com/298ba219c7.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="header">
        <ul>
            <li><i class="fa-solid fa-house-user"></i></li>
            <li><a href="#">Accueil</a></li>
            <li><a href="#">Gestion jour</a></li>
            <li><a href="#">Gestion emplacement</a></li>
            <li><a href="#">Gestion reservation</a></li>
        </ul>
    </div>
</body>
</html>