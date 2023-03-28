<?php
    session_start();
    require_once "DBManager.php";
    $dbm = new DBManager();

    $dbm->address_update($_POST["customer_id"],$_POST["PostCode"],
                        $_POST["Prefectures"],$_POST["Towns"],$_POST["address1"],$_POST["address2"],$_POST["number"]);//住所情報更新
    
    $_SESSION['order_name'] = $_POST["order_destination_name"];//届け先名
    $_SESSION['delivery_preferred_date'] = $_POST["delivery_preferred_date"];//お届け希望日
    $_SESSION['order_time_key'] = $_POST["time_key"];//お届け希望時間
    
    echo json_encode("success");
?>