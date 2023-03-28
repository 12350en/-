<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/reset.css" />
    <script src="http://code.jquery.com/jquery.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>食べ食べプラン</title>
    <style>
        .orderState img {
            width: 100%;
        }

        .block {
            display: block;
            margin: 20px auto;
        }

        .myForm {
            text-align: center;
        }

        .myForm input {
            text-align: center;
        }

        .nameNumInput {
            width: 30px
        }
    </style>
</head>

<body>
    <script>
        <?php require 'DBManager.php';
        $dbmng = new DBManager();
        $dbmng->menu_display()
        ?>

        // function send() {
        //     setTimeout(() => {
        //         const test = () => {
        //             const orderForm = document.getElementById('orderForm');
        //             orderForm.action = "orderConfirmation-page.php"
        //             orderForm.method = "post"
        //             orderForm.encoding = "application/x-www-form-urlencoded";
        //         }
        //     }, 2000);
        // }
    </script>
    <!-- G1-7に対応している画面です -->
    <div class="orderContentWrapper">
        <div class="orderState">
            <img src="./img/orderContentImage.png">
        </div>
        <div class="orderFormWrapper">
            <form id="orderForm" name="myForm" class="myForm" method="post" action="./orderConfirmation-page.php">
            </form>
            <!-- <form id="orderForm" onsubmit="send();">
            </form> -->
        </div>
    </div>
</body>

</html>

<script>
    window.onload = function() {
        const orderForm = document.getElementById('orderForm')
        let json = localStorage.getItem('key');
        let menuCountArrayStorage = JSON.parse(json)
        console.log(menuCountArrayStorage)

        Object.values(menuCountArrayStorage).forEach((value, index) => {
            Object.keys(value).forEach(key => {
                keyValue = key;
                console.log(keyValue)
            })
            Object.values(value).forEach(detailValue => {
                vallValue = detailValue

                // 要要素を作成
                const divForm = document.createElement('div')
                const nameNumInput = document.createElement('input')
                nameNumInput.classList.add('class', 'nameNumInput')
                nameNumInput.setAttribute('value', keyValue)
                nameNumInput.setAttribute('name', 'key' + (index + 1))
                nameNumInput.setAttribute('type', 'text')
                nameNumInput.readOnly = true;
                const label = document.createElement('label')
                label.innerHTML = menuArray[keyValue][0]
                divForm.appendChild(nameNumInput)
                divForm.appendChild(label)
                orderForm.appendChild(divForm)

                const input = document.createElement('input');
                // formで渡してあげる情報を連想配列にしてあげる
                input.setAttribute('value', vallValue)
                // console.log(vallValue + "vallValue")
                input.readOnly = true;
                input.setAttribute('name', 'value' + (index + 1))
                input.setAttribute('type', 'text')
                input.classList.add('block')
                orderForm.appendChild(input)
            })
        })

        // データが渡せていない理由はdomが完了する前に関数を定義している(// 12/04に作成)
        const formSubmit = () => {
            // おそらく今の状態はデータが格納されていない状態なので取得できない
            // だけどinputがある状態でも取得ができていない

            const formdata = new FormData(document.forms[0]);
            // formdata.append('id', '000021')
            fetch("request.php", {
                method: "POST",
                body: formdata,
            });
            setTimeout(() => {
                console.log(formdata.get('test'));
                alert('success')
                // location.href = "orderConfirmation-page.php"
            }, 100);
        }



        const submit = document.createElement('input');
        orderForm.appendChild(submit)
        submit.setAttribute('type', 'submit')
        submit.setAttribute('value', '送信')


        // submit.addEventListener('click', e => {
        //     e.preventDefault()
        //     formSubmit();
        //     // 12/04に作成

        //     // ajaxは値渡しでデコレートして使うときに利用
        //     // $.ajax({
        //     //     type: "POST", //　GETでも可
        //     //     url: "request.php", //　送り先
        //     //     data: {
        //     //         id: "10000"
        //     //     }, //　渡したいデータをオブジェクトで渡す
        //     //     dataType: "json", //　データ形式を指定
        //     //     scriptCharset: 'utf-8' //　文字コードを指定
        //     // }).done(function(response, textStatus, xhr) {
        //     //     console.log("ajax通信に成功しました");
        //     //     console.log(response);
        //     // }).fail(function(xhr, textStatus, errorThrown) {
        //     //     console.log("ajax通信に失敗しました");
        //     // })
        // })



    }

    // 12/04に作成
    // const myFormElm = document.forms.myForm;
    // myFormElm.addEventListener('submit', (e) => { // 送信ボタンが押されたら実行
    //     e.preventDefault();
    //     const formData = new FormData(myFormElm); // フォームオブジェクト作成

    //     setTimeout(() => {
    //         fetch('./orderConfirmation-page.php', { // 第1引数に送り先
    //                 method: 'POST', // メソッド指定
    //                 // Content-Typeは指定しない
    //                 body: formData // bodyにそのまま添付
    //             })
    //             .then(res => {
    //                 if (res.ok) {
    //                     console.log(formData)
    //                     console.log("oke")
    //                     throw new Error(`${res.status} ${res.statusText}`);
    //                 }
    //                 return res.blob();
    //             })
    //             .then((blob) => {
    //                 // blob にレスポンスデータが入る
    //             })
    //             .catch((reason) => {
    //                 console.log(reason);
    //             });
    //         // location.href = "orderConfirmation-page.php"
    //     }, 2000);
    // });
</script>