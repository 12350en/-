<?php
session_start();

if (
    isset($_SESSION["user_name"]) == true  &&
    isset($_SESSION["user_id"]) == true
) {
    header('Location:registragtion2-page.php');
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
    <style>
        .NameErrMesageNone {
            display: none;
        }
    </style>
</head>

<body>
    <!-- G1-4に対応している画面です -->
    <div class="main">
        <!-- header読み込み -->

        <div class="text-center">
            <p class="text-success"><strong>ご購入手続き</strong></p>
            <!--線と丸の画像-->
            <li><img class="orderImage" src="img/image1.png" /></li>

            <form id="customer_data">
                <p>お名前</p>
                <p style="color:red" id="nameErrMesage" class="NameErrMesage"></p>
                <input type="text" name="onamae" id="inputName" placeholder="Name">

                <p>メールアドレス</p>
                <p id="error" style="color:red"></p>
                <p style="color:red" id="mailErrMesage" class="NameErrMesage"></p>
                <input type="text" name="email" id="inputMail" placeholder="Email">

                <p>パスワード(半角英数6文字以上)</p>
                <p style="color:red" id="passErrMesage" class="NameErrMesage"></p>
                <input type="password" name="passward" id="inputPass" placeholder="Password">
            </form>

            <p>すでにアカウントをお持ちの方はこちらから<a href="login-page.php">ログイン</a>してくださいしてください</p>
            
            <p><button type="button" class="btn btn-secondary" onclick="location.href='menu-list.php'">戻る</button>
                <button type="button" id="nextbtnSubmit" class="btn btn-success">次へ</button>
            </p>
        </div>
    </div>
</body>
<script>
    const NameErrMesage = document.getElementsByClassName('NameErrMesage');
    const NameErrMesageNum = NameErrMesage.length;

    const inputName = document.getElementById("inputName");
    const inputMail = document.getElementById("inputMail");
    const inputPass = document.getElementById("inputPass");

    // mail 先頭に記号を含まない、@と.を含む
    const reg = /^[a-zA-Z0-9_+-]+(.[a-zA-Z0-9_+-]+)*@([a-zA-Z0-9][a-zA-Z0-9-]*[a-zA-Z0-9]*\.)+[a-zA-Z]{2,}$/;
    // passアルファベット小文字、大文字または数値が1文字
    const pass = /^([a-zA-Z0-9]{5,})$/;

    const nextbtnSubmit = document.getElementById("nextbtnSubmit");
    const nameErrMesage = document.getElementById("nameErrMesage");
    const mailErrMesage = document.getElementById("mailErrMesage");
    const passErrMesage = document.getElementById("passErrMesage");


    nextbtnSubmit.addEventListener('click', () => {
        // errがなければ画面遷移
        changeInput()
    })


    const changeInput = () => {
        for (let i = 0; i < NameErrMesageNum; i++) {
            const NameErrMesage = document.getElementsByClassName('NameErrMesage')[i];
            NameErrMesage.classList.add('NameErrMesageNone')
        }

        let errCount = 0;

        //name
        if (inputName.value == "") {
            const NameErrMesage = document.getElementsByClassName('NameErrMesage')[0]
            NameErrMesage.classList.remove('NameErrMesageNone')
            nameErrMesage.innerHTML = "名前が未入力です。"
            errCount++;
        }
        //email
        if (inputMail.value == "") {
            const NameErrMesage = document.getElementsByClassName('NameErrMesage')[1]
            NameErrMesage.classList.remove('NameErrMesageNone')
            mailErrMesage.innerHTML = "メールアドレスが未入力です。"
            errCount++;
        } else if (!reg.test(inputMail.value)) {
            const NameErrMesage = document.getElementsByClassName('NameErrMesage')[1]
            NameErrMesage.classList.remove('NameErrMesageNone')
            mailErrMesage.innerHTML = "メールアドレスの形式が不正です。"
            errCount++;
        }

        // pass
        if (inputPass.value == "") {
            const NameErrMesage = document.getElementsByClassName('NameErrMesage')[2]
            NameErrMesage.classList.remove('NameErrMesageNone')
            passErrMesage.innerHTML = "パスワードが未入力です。"
            errCount++;
        } else if (!inputPass.value.match(/^([a-zA-Z0-9]{5,})$/)) {
            const NameErrMesage = document.getElementsByClassName('NameErrMesage')[2]
            NameErrMesage.classList.remove('NameErrMesageNone')
            passErrMesage.innerHTML = "パスワードの形式が不正です。"
            errCount++;
        }

        if (errCount == 0) {
            const formData = new FormData(document.forms.customer_data);
            var result;
            fetch("accountCreate.php", {
                method: "POST",
                body: formData,
            })
            //レスポンスをtxtで文字列に変換後、該当画面に遷移
            .then((res) => res.json())
            .then((data) => {
                if(data=="success"){
                    location.href = "registragtion2-page.php";
                }else{
                    var error_element = document.getElementById("error");
                    error_element.innerHTML = "このメールアドレスは既に使用されています";
                }
            });
        } else if (errCount > 0) {
            alert("入力に誤りがあります。")
        }

    }
</script>

</html>