<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Epoka</title>
    <link rel="stylesheet" href="./style/style.css">
</head>

<body>
<div class="navbar">
        <a  href="#">Connexion</a>
        <a class="indisponible" href="#">Validation des missions</a>
        <a class="indisponible" href="#">Paiement des frais</a>
        <a  class="indisponible" href="#">Paramétrage</a>
        <a href="#" style="float:right;">Copyright 2024-2025 BADIS</a>
    </div>
    <div class="container">
        <h2>Identifiez-vous</h2>
        <form action="./controller/loginController.php" method="post">
            <input type="text" name="numero" placeholder="Utilisateur" required>
            <input type="password" name="mdp" placeholder="Mot de passe" required>
            <input type="submit" value="Valider">
            <?php
            session_start();
            if (isset($_SESSION["erreurLogin"])) {
                echo '<center><p>' . $_SESSION["erreurLogin"] . '</p></center>';
                unset($_SESSION["erreurLogin"]);
            }
            ?>

        </form>
    </div>
</body>

</html>