<?php

if (!isset($_GET["numero"]) || !isset($_GET["mdp"])) {
    die("Connexion impossible");
}

try {
    $numero = $_GET["numero"];
    $mdp = $_GET["mdp"];

    $pdo = new PDO("mysql:host=localhost;dbname=epoka_missions;charset=utf8", "root", "", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    $stmt = $pdo->prepare("SELECT Sal_Prenom FROM salarie WHERE Sal_No = :numero AND Sal_MotDePasse = :mdp");
    $stmt->bindParam(':numero', $numero, PDO::PARAM_INT);
    $stmt->bindParam(':mdp', $mdp, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    

    if($result) {
        echo $result['Sal_Prenom'];
    }
    
    //$results = json_encode($result);
    
} catch (Exception $e) {
    echo "Une erreur s'est produite : " . $e->getMessage();
}
