<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Epoka - Paiement</title>
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
    $missons = selectMissionPaiment();
    $lesSalaries = getLesSalaries($_SESSION['user_id']);
    $mis = selectMissionPaiment();


    foreach ($lesSalaries as $unSalarie) {
        if ($unSalarie["Sal_Personnel"] == 0) {
            echo "<p class='impossible' >Vous n'êtes pas autorisé</p>";
        } else {
    ?>
            <h2 class="titre-h2">Paiement des missions</h2>

            <table class="tftable" border="1">
                <tr>
                    <th>Nom du salarié</th>
                    <th>Prénom du salarié</th>
                    <th>Début de la mission</th>
                    <th>Fin de la mission</th>
                    <th>Lieu de la mission</th>
                    <th>Montant</th>
                    <th>Paiment</th>
                </tr>
                <?php
                foreach ($missons as $misson) {
                    echo '<form method="post" action="../controller/paimentController.php">';
                    echo "<tr>";

                    echo "<td>" . htmlspecialchars($misson["Sal_Nom"]) . "</td>";
                    echo "<td>" . htmlspecialchars($misson["Sal_Prenom"]) . "</td>";
                    echo "<td>" . htmlspecialchars($misson["Mis_DateDebut"]) . "</td>";
                    echo "<td>" . htmlspecialchars($misson["Mis_DateFin"]) . "</td>";
                    echo "<td>" . htmlspecialchars($misson["Vil_Nom"]) . "</td>";
                    if (($misson["Montant"]) == 0) {
                        $vil = $misson["Ag_NoVille"];
                        $ville = selectVille($vil);
                        echo "<td>Distance a saisir depuis " . $ville[0]['Vil_Nom'] . "</td>";


                        
                        
                    } else {
                        echo "<td>" . htmlspecialchars($misson["Montant"]) ." €" . "</td>";
                    }


                    echo "<td>";
                    if ($misson["Mis_Remboursee"] == 0) {
                        if ($misson["Montant"] != 0) {
                            echo '<button type="submit" name="rembourse" id="rembourse">Rembourser</button>';
                        } else {
                            echo '<button type="submit" name="rembourse" id="rembourse" disabled>Rembourser</button>';
                        }
                    } else {
                        echo "Remboursé";
                    }
                    echo "</td>";
                    

                    echo '<input type="hidden" name="mission_no" value="' . htmlspecialchars($misson["Mis_No"]) . '">';
                    echo '<input type="hidden" name="mission_ag_nom" value="' . htmlspecialchars($misson["Ag_Nom"]) . '">';

                    echo "</tr>";
                    echo '</form>';
                }
            }
                ?>
            </table>

            

    <?php
        }
    

    ?>
</body>

</html>