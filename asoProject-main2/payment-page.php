<?php session_start(); echo $_SESSION['delivery_preferred_date']; ?>

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
    <!-- G1-6に対応している画面です -->
</body>
<main class="main">
    <div class="text-center">
        <p class="text-success"><strong>ご購入手続き</strong><br></p>
        <img src="./img/image3.png">
        <form id="order_payment">
                <div style="border: solid 1px black; padding: 10px; border-width: 2px; border-radius: 10px; margin: 10px 30px;">
                <p><div style="border: solid 1px black; padding: 10px; width: 80%; border-width: 2px; border-radius: 10px; margin: 10px 30px;"class="btn btn-success">
                   <label class="container"><div class="simple-box1" style="font-size: 20px;">銀行振込</div>
                   <input type="radio" name="radio" value="00">
                    <span class="checkmark"></span>
                   </label>
                </div>
                </p>
                <p><div style="border: solid 1px black; padding: 10px; width: 80%; border-width: 2px; border-radius: 10px; margin: 10px 30px;"class="btn btn-success">
                        <label class="container"><div class="simple-box1" style="font-size: 20px;">コンビニ支払い</div>
                        <input type="radio" checked="checked" name="radio" value="01">
                        <span class="checkmark"></span>
                        </label>
                     </div>
                </p>
                <p><div style="border: solid 1px black; padding: 10px;width: 80%; border-width: 2px; border-radius: 10px; margin: 10px 30px;" class="btn btn-success">
                        <label class="container"><div class="simple-box1" style="font-size: 20px;">代引</div>
                        <input type="radio" name="radio" value="10">
                        <span class="checkmark"></span>
                        </label>
                    </div>
                </p>
        </form>
        </div>
        <p>
            <button type="button" class="btn btn-secondary"onclick="location.href='registragtion2-page.html'">戻る</button>
            <button type="button" class="btn btn-success" id="nextbtnSubmit">次へ</button>
        </p>
    </div>

    <script>
        nextbtnSubmit.addEventListener('click' ,()=>{
            const paymentData = new FormData(document.forms.order_payment);
            fetch("paymentData.php",{
                method: "POST",
                body: paymentData,
            })
            .then((res) => res.json())
            .then((data) => {
                if(data=="success"){
                    location.href="orderContent-page.php";
                }
            });
        })
    </script>

</div>

</html>