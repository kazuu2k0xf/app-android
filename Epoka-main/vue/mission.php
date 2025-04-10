<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Epoka - Missions</title>
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
    $missons = getMissions($_SESSION['user_id']);
    $lesSalaries = getLesSalaries($_SESSION['user_id']);

    foreach ($lesSalaries as $unSalarie) {
        if ($unSalarie["Sal_Responsable"] == 0) {
            echo "<p class='impossible' >Vous n'êtes pas autorisé</p>";
        } else {
    ?>
            <h2 class="titre-h2">Validation des missions de vos subordonnées</h2>

            <table class="tftable" border="1">
                <tr>
                    <th>Nom du salarié</th>
                    <th>Prénom du salarié</th>
                    <th>Début de la mission</th>
                    <th>Fin de la mission</th>
                    <th>Lieu de la mission</th>
                    <th>Validation</th>
                    <th>Remboursé</th>
                </tr>
                <?php
                foreach ($missons as $misson) {
                    echo '<form method="post" action="../controller/missionController.php">';
                    echo "<tr>";

                    echo "<td>" . htmlspecialchars($misson["Sal_Nom"]) . "</td>";
                    echo "<td>" . htmlspecialchars($misson["Sal_Prenom"]) . "</td>";
                    echo "<td>" . htmlspecialchars($misson["Mis_DateDebut"]) . "</td>";
                    echo "<td>" . htmlspecialchars($misson["Mis_DateFin"]) . "</td>";
                    echo "<td>" . htmlspecialchars($misson["Vil_Nom"]) . "</td>";

                    echo "<td>";
                    if ($misson["Mis_Validee"] == 0) {
                        echo '<button type="submit" name="valider" id="valider">Valider</button>';
                    } else {
                        echo "Validé";
                    }
                    echo "</td>";

                    echo "<td>";
                    if ($misson["Mis_Remboursee"] == 0) {
                        echo '';
                    } else {
                        echo "Remboursé";
                    }
                    echo "</td>";
                    
                    echo '<input type="hidden" name="mission_no" value="' . htmlspecialchars($misson["Mis_No"]) . '">';

                    echo "</tr>";
                    echo '</form>';
                }


                ?>
            </table>

    <?php
        }
    }
    ?>
</body>

</html>