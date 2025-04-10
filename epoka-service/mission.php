<?php

if (!isset($_GET["numero"]) || !isset($_GET["ville"]) || !isset($_GET["debut"]) || !isset($_GET["fin"])) {
    die("Connexion impossible");
}

try {
    $numero = $_GET["numero"];
    $ville = $_GET["ville"];
    $debut = $_GET["debut"];
    $fin = $_GET["fin"];

    $debut_date = DateTime::createFromFormat('d/m/Y', $debut);
    $fin_date = DateTime::createFromFormat('d/m/Y', $fin);

    if (!$debut_date || !$fin_date) {
        throw new Exception("Format de date invalide");
    }

    $pdo = new PDO("mysql:host=localhost;dbname=epoka_missions;charset=utf8", "root", "", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    $stmt = $pdo->prepare("INSERT INTO mission (Mis_NoSalarie, Mis_NoVille, Mis_DateDebut, Mis_DateFin) VALUES (:num, :ville, :debut, :fin)");
    $stmt->bindParam(':num', $numero, PDO::PARAM_INT);
    $stmt->bindParam(':ville', $ville, PDO::PARAM_INT);
    $stmt->bindParam(':debut', $debut_date->format('Y-m-d'), PDO::PARAM_STR);
    $stmt->bindParam(':fin', $fin_date->format('Y-m-d'), PDO::PARAM_STR);
    $stmt->execute();

    echo "Insertion réussie";

} catch (Exception $e) {
    echo "Une erreur s'est produite : " . $e->getMessage();
}
