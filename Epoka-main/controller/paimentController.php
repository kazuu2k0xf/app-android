<?php
require_once("../model/model.php");

if (isset($_POST["rembourse"])) {
    $mission = $_POST["mission_no"];
    setRembourser($mission);

    header("location: ../vue/paiment.php");
    exit;
}
