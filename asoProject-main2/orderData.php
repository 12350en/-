<?php
    session_start();
    require_once "DBManager.php";
    $dbm = new DBManager();
    try{
        $menu_list=[$_POST["order_menu_1"],$_POST["order_menu_2"],$_POST["order_menu_3"],$_POST["order_menu_4"],$_POST["order_menu_5"],
                    $_POST["order_menu_6"],$_POST["order_menu_7"]];
        $subtraction_menu_list=array_count_values($menu_list);
        //在庫数チェック
        foreach($subtraction_menu_list as $key => $value){
            $dbm->inventory_check($key,$value);
        }
        //在庫減算処理
        foreach($subtraction_menu_list as $key => $value){
            $dbm->inventory_subtraction($key, $value);
        }

        //購入情報生成
        $dbm->order_data_create($_POST["order_menu_1"],$_POST["order_menu_2"],$_POST["order_menu_3"],$_POST["order_menu_4"],$_POST["order_menu_5"],
                            $_POST["order_menu_6"],$_POST["order_menu_7"],$_POST["destination_name"],$_POST["delivery_preferred_date"],
                            $_POST["delivery_time_key"],$_POST["payment_key"],$_POST["customer_id"]);

    }catch(Exception $ex){
        echo json_encode("false");
        return 0;
    }

    echo json_encode("success");
?>