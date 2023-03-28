<?php
    session_start();
    require_once "DBManager.php";
    $dbm = new DBManager();

    try{
        $dbm->passeward_reset($_POST["email"],$_POST["passward"]);
    }catch(Exception $ex){
        echo json_encode("miss");
    }

    echo json_encode("success");
?>