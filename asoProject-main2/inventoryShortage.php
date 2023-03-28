<?php session_start(); ?>

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
        </script>
        
        <div class="text-center">
            <p class="text-success">
                <strong>ご購入手続き</strong><br>
            <img src="./img/orderComplete.png" style="width: 40%;">
        <div>
            <div class="orderComplete">
                <p><h2>申し訳ございません。ご注文の商品の中に在庫切れのものがございました。</h2></p>
                <p><h2>お手数をおかけしますが、もう一度メニューをお選びください。</h2></p>
            </div>
            <p>
                <button type="button" class="btn btn-success" button onclick="location.href='menu-list.php'">メニュー選択画面に戻る</button>
            </p>

        </div>
    </main>
</body>

</html>