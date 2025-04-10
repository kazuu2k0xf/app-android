<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Epoka - Paramétrage</title>
    <link rel="stylesheet" href="../style/style.css">
</head>

<body>
    <div class="navbar">
        <a href="../index.php">Déconnexion</a>
        <a href="mission.php">Validation des missions</a>
        <a href="paiment.php">Paiement des frais</a>
        <a href="param.php">Paramétrage</a>
        <a href="#" style="float:right;">Copyright 2024-2025 BADIS</a>
    </div>

    <?php
    require_once("../model/model.php");
    session_start();
    $villesDepart = selectVilleDepart();
    $villesArrivee = selectVilleArrive();
    $parametre = getParam();
    $lesSalaries = getLesSalaries($_SESSION['user_id']);
    foreach ($lesSalaries as $unSalarie) {
        if ($unSalarie["Sal_Personnel"] == 0) {
            echo "<p class='impossible' >Vous n'êtes pas autorisé</p>";
        } else {
    ?>
            <div class="container">
                <h2 class="titre-h2">Paramétrage de l'application</h2>
                <h3>Montant du remboursement au km</h3>


                <form action="../controller/paramController.php" method="post">
                    <label for="remboursement">Remboursement au Km :</label>
                    <input type="text" id="remboursement" name="remboursement" value="<?php echo $parametre[0]['Par_IndemniteKm'] ?>">

                    <label for="indemnite">Indemnité d'hébergement :</label>
                    <input type="text" id="indemnite" name="indemnite" value="<?php echo $parametre[0]['Par_IndemniteJour']  ?>">

                    <input type="submit" name="validerParam" id="validerParam">
                </form>
            </div>


            <div class="container">
                <h2 class="titre-h2">Les distances entre villes</h2>
                <form action="../controller/paramController.php" method="post">
                    <label for="de">De :</label>
                    <select id="de" name="de">
                        <option value="">Sélectionnez une ville de départ</option>
                        <?php foreach ($villesDepart as $ville): ?>
                            <option value="<?php echo htmlspecialchars($ville['Vil_No']); ?>">
                                <?php echo htmlspecialchars($ville['Vil_Nom']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <br>
                    <label for="a">à :</label>
                    <select id="a" name="a">
                        <option value="">Sélectionnez une ville d'arrivée</option>
                        <?php foreach ($villesArrivee as $ville): ?>
                            <option value="<?php echo htmlspecialchars($ville['Vil_No']); ?>">
                                <?php echo htmlspecialchars($ville['Vil_Nom']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <br>
                    <br>
                    <label for="distance">Distance en km :</label>
                    <input type="text" id="distance" name="distance">
                    <input type="submit" name="validerDistance">
                </form>
            </div>




    <?php
        }
    }
    ?>

</body>

</html>