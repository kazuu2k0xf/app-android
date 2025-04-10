<?php

function getPdo()
{
    $pdo = new PDO("mysql:host=localhost;dbname=epoka_missions;charset=utf8", "root", "", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    return $pdo;
}

function getLesSalaries($no)
{
    $pdo = getPdo();
    $stmt = $pdo->query("SELECT * FROM salarie WHERE Sal_No = $no");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getlesMissions($no)
{
    $pdo = getPdo();
    $stmt = $pdo->query("SELECT * FROM mission, salarie WHERE Sal_No = $no AND Sal_No = Mis_NoSalarie");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getLesVilles($no)
{
    $pdo = getPdo();
    $stmt = $pdo->query("SELECT * FROM ville WHERE Vil_No = $no");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getMissions($no)
{
    $pdo = getPdo();
    $stmt = $pdo->query("SELECT Mis_No, Sal_Nom, Sal_Prenom, Mis_DateDebut, Mis_DateFin, Vil_Nom, Mis_Validee, Mis_Remboursee
              FROM salarie
              JOIN mission ON salarie.Sal_No = mission.Mis_NoSalarie
              JOIN ville ON mission.Mis_NoVille = ville.Vil_No
              WHERE salarie.Sal_NoResponsable = $no");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function setValider($no)
{
    $pdo = getPdo();
    $stmt = $pdo->prepare("UPDATE mission SET mis_validee = 1 WHERE Mis_No = :no");
    $stmt->bindParam(':no', $no, PDO::PARAM_INT);
    $result = $stmt->execute();
    return $result;
}

function getMissionsPersonnel($no)
{
    $pdo = getPdo();
    $stmt = $pdo->query("SELECT Mis_No, Sal_Nom, Sal_Prenom, Mis_DateDebut, Mis_DateFin, Vil_Nom, Mis_Validee, Mis_Remboursee
              FROM salarie
              JOIN mission ON salarie.Sal_No = mission.Mis_NoSalarie
              JOIN ville ON mission.Mis_NoVille = ville.Vil_No
              WHERE salarie.Sal_NoResponsable = $no");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function updateParam($km, $indemnite)
{
    $pdo = getPdo();
    $stmt = $pdo->prepare("UPDATE parametrage SET Par_IndemniteKm = :km, Par_IndemniteJour = :indemnite");
    $stmt->bindParam(':km', $km, PDO::PARAM_STR);
    $stmt->bindParam(':indemnite', $indemnite, PDO::PARAM_STR);
    $result = $stmt->execute();
    return $result;
}


function selectVilleArrive()
{
    $pdo = getPdo();
    $stmt = $pdo->query("SELECT DISTINCT ville.Vil_Nom, Vil_No
                         FROM mission 
                         JOIN ville ON mission.Mis_NoVille = ville.Vil_No 
                         ORDER BY ville.Vil_Nom");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function selectVilleDepart()
{
    $pdo = getPdo();
    $stmt = $pdo->query("SELECT DISTINCT ville.Vil_Nom, Vil_No
                         FROM agence 
                         JOIN ville ON agence.Ag_NoVille = ville.Vil_No 
                         ORDER BY ville.Vil_Nom");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getParam()
{
    $pdo = getPdo();
    $stmt = $pdo->query("SELECT Par_IndemniteKm, Par_IndemniteJour FROM parametrage");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function insertDistance($de, $a, $distance)
{
    $pdo = getPdo();
    $stmt = $pdo->prepare("INSERT INTO distance (Dist_NoVille1, Dist_NoVille2, Dist_Km) VALUES (:de, :a, :distance)");
    $stmt->bindParam(':de', $de, PDO::PARAM_STR);
    $stmt->bindParam(':a', $a, PDO::PARAM_STR);
    $stmt->bindParam(':distance', $distance, PDO::PARAM_INT);
    $result = $stmt->execute();
    return $result;
}

function selectMissionPaiment()
{
    $pdo = getPdo();
    $stmt = $pdo->query("SELECT 
    Mis_No, 
    Sal_Nom, 
    Sal_Prenom, 
    Mis_DateDebut, 
    Mis_DateFin, 
    Vil_Nom, 
    Ag_Nom,
    Ag_NoVille,
    CASE 
        WHEN distance.Dist_Km IS NULL THEN NULL
        ELSE (distance.Dist_Km * parametrage.Par_IndemniteKm + 
              DATEDIFF(mission.Mis_DateFin, mission.Mis_DateDebut) * parametrage.Par_IndemniteJour)
    END AS Montant,
    Mis_Remboursee
FROM salarie
INNER JOIN mission ON salarie.Sal_No = mission.Mis_NoSalarie
INNER JOIN ville ON mission.Mis_NoVille = ville.Vil_No
INNER JOIN agence ON agence.Ag_No = salarie.Sal_NoAgence
LEFT JOIN distance ON distance.Dist_NoVille1 = agence.Ag_NoVille 
                   AND distance.Dist_NoVille2 = ville.Vil_No
CROSS JOIN parametrage
WHERE mission.Mis_Validee = 1;
");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



function setRembourser($no)
{
    $pdo = getPdo();
    $stmt = $pdo->prepare("UPDATE mission SET mis_remboursee = 1 WHERE Mis_No = :no");
    $stmt->bindParam(':no', $no, PDO::PARAM_INT);
    $result = $stmt->execute();
    return $result;
}

function selectVille($no) {
    $pdo = getPdo();
    $stmt = $pdo->query("SELECT * FROM ville WHERE Vil_No = $no");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
