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
    <!-- G1-7に対応している画面です -->
    <?php
    $pushArrayVal = [];
    $pushArrayKey = [];
    // 入力された変数分だけ取得する
    for ($i = 1; $i <= 7; $i++) {
        // 存在しない場合処理を終了
        if (!isset($_POST['value' . $i])) {
            break;
        } else {
            echo '<p>' . 'test' . '</p>';
            array_push($pushArrayVal, $_POST['value' . $i]);
            array_push($pushArrayKey, $_POST['key' . $i]);
        }
    }
    echo $_POST["value1"];
    // print_r($pushArrayKey);
    // echo '<br>';
    // print_r($pushArrayVal);
    // echo '<p>' . 'test' . '</p>';


    ?>
</body>

</html>