<?php
     session_start();
     echo $_SESSION["user_id"]."<br>";
     echo $_SESSION["user_name"]."<br>";
     echo $_SESSION['order_payment']."<br>";
     echo $_SESSION['order_name']."<br>";//届け先名
     echo $_SESSION['delivery_preferred_date']."<br>";//お届け希望日
     echo $_SESSION['order_time_key']."<br>";//お届け希望時間

     if(isset($_SESSION["user_name"]) == true  &&
     isset($_SESSION["user_id"]) == true ){
        echo "セッションを受け取れています ";
     }

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/reset.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>食べ食べプラン</title>
</head>

<body>
    <!-- G1-9に対応している画面です -->
    <main class="main">
        <script>
            localStorage.clear();
            <?php unset($_SESSION['order_payment']); ?>
            <?php unset($_SESSION['order_name']); ?>
            <?php unset($_SESSION['delivery_preferred_date']); ?>
            <?php unset($_SESSION['order_time_key']); ?>
        </script>
        
        <div class="text-center">
            <p class="text-success">
                <strong>ご購入手続き</strong><br>
            <img src="./img/orderComplete.png" style="width: 40%;">
        <div>
            <div class="orderComplete">
                <h2>ありがとうございます。<br>購入が確定されました。</h2>
            </div>
            <p>
                <button type="button" class="btn btn-success" button onclick="location.href='front.php'">ホーム画面に戻る</button>
            </p>

        </div>
    </main>
</body>

</html>