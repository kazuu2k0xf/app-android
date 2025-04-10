<?php

try {
    require_once("../model/model.php");
    session_start();

    $id = $_POST["numero"];
    $pwd = $_POST["mdp"];

    $lesSalaries = getLesSalaries($id);

    foreach ($lesSalaries as $unSalarie) {

        if ($id == $unSalarie["Sal_No"] && $pwd == $unSalarie["Sal_MotDePasse"]) {
            if (isset($_SESSION["erreurLogin"])) {
                echo '<center><p>' . $_SESSION["erreurLogin"] . '</p></center>';
                unset($_SESSION["erreurLogin"]);
            }
            $_SESSION['user_id'] = $unSalarie["Sal_No"];
            header("Location: ../vue/menu.php");
            exit;
        } else {
            $_SESSION["erreurLogin"] = "Le numéro ou le mot de passe est incorrect";
            header("Location:../");
        }
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
