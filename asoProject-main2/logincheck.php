<?php
    session_start();
    require_once "DBManager.php";
    $dbm = new DBManager();

    try{
        $searchArray=$dbm->login_check($_POST["email"],$_POST["passward"]);

        foreach($searchArray as $row){
            $_SESSION['user_id'] = $row['customer_id'];
            $_SESSION['user_name'] = $row['customer_name'];
        }

    }catch(BadMethodCallException $bce){
        //メールアドレスが存在しなかった場合
        echo json_encode("id_miss");
        return 0;
    }catch(LogicException $le){
        //パスワードが違った場合
        echo json_encode("pass_miss");
        return 0;
    }

    echo json_encode("success");
?>