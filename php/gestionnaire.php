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
    <title>Espace Gestionnaire</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #434343, #000000);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #fff;
        }
        .container {
            background: rgba(255, 255, 255, 0.1);
            padding: 40px 60px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            border-radius: 20px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            text-align: center;
            max-width: 500px;
            width: 100%;
        }
        h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            font-weight: 600;
            color: #fff;
        }
        p {
            font-size: 1.2rem;
            color: #e0e0e0;
            margin: 0;
        }
        .username {
            font-weight: bold;
            color: #00ff88;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bienvenue, Gestionnaire !</h1>
        <p>Vous êtes connecté en tant que <span class="username"><?php echo htmlspecialchars($_SESSION['username']); ?></span>.</p>
    </div>
</body>
</html>