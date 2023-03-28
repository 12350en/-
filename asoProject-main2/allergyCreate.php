 <!-- $dbmng->menu_allergy_filter($ary_names); -->
 -->

 <?php

   $post_data_1 = $_POST['data']; // 送ったデータを受け取る（GETで送った場合は、INPUT_GET）
   $return_array = array("PHPに送られたpost_data_1:" . $post_data_1);
   header('Content-type: application/json; charset=utf-8'); // ヘッダ（データ形式、文字コードなど指定）

   foreach ($return_array as $row) {
      echo $row;
   }
   // echo json_encode($return_array); //　echoするとデータを返せる（JSON形式に変換して返す）
