<?php
if (!isset($_GET["ville"]))  {
    die("Connexion impossible");
}


try {

    $ville = $_GET["ville"];
    $pdo = new PDO("mysql:host=localhost;dbname=epoka_missions;charset=utf8", "root", "", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    $stmt = $pdo->prepare("SELECT Vil_No FROM ville WHERE Vil_Nom LIKE :ville");
    $stmt->bindValue(':ville', $ville, PDO::PARAM_STR);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($results) {
        foreach ($results as $result) {
            echo $result['Vil_No'];
        }
    } 

} catch (Exception $e) {
    echo "Une erreur s'est produite : " . $e->getMessage();
}
