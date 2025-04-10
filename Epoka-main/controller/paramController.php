<?php
    require_once("../model/model.php");

    if (isset($_POST["validerParam"]) && !empty($_POST["remboursement"]) && !empty($_POST["indemnite"])) {
    $km = $_POST["remboursement"];
    $indemnite = $_POST["indemnite"];
    updateParam($km, $indemnite);

    header("location: ../vue/param.php");
    exit;

    }

    if (isset($_POST["validerDistance"]) && !empty($_POST["de"]) && !empty($_POST["a"]) && !empty($_POST["distance"])) {
        $depart = $_POST["de"];
        $arrive = $_POST["a"];
        $distance = $_POST["distance"];
        insertDistance($depart, $arrive, $distance);
    
        header("location: ../vue/param.php");
        exit;
        
        }


