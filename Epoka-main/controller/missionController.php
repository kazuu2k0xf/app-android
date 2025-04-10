<?php 
    require_once("../model/model.php");

    if (isset($_POST["valider"])) {
    $mission = $_POST["mission_no"];
    setValider($mission);

    header("location: ../vue/mission.php");
    exit;
}