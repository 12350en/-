<?php
session_start();
require_once "DBManager.php";
$dbm = new DBManager();

echo $_SESSION["user_id"] . "<br>";
echo $_SESSION["user_name"] . "<br>";

if (
  isset($_SESSION["user_name"]) == true  &&
  isset($_SESSION["user_id"]) == true
) {
  echo "セッションを受け取れています ";
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/style.css" />
  <script src="https://cdn.jsdelivr.net/npm/fetch-jsonp@1.1.3/build/fetch-jsonp.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
  <style>
    .NameErrMesageNone {
      display: none;
    }

    p {
      margin: 0;
      font-size: 16px;
    }

    .postCodeSearch {
      margin: 10px auto;
      background: black;
      color: white;
      width: 20%;
    }
  </style>
  <title>食べ食べプラン</title>
</head>

<body>
  <!-- G1-5に対応している画面です -->
  <div class="main">
    <div class="text-center">
      <p class="text-success"><strong>ご購入手続き</strong></p>
      <!--線と丸の画像-->
      <img class="orderImage" src="img/image2.png" />
      <p>お届け先名　[必須]</p>
      <form id="order_data">
        <p style="color:red" id="NameErrMesage" class="NameErrMesage"></p>
        <input class="inputBottom" type="text" name="Name" id="Name" placeholder="Name" value=
          <?php
            if(isset($_SESSION["user_name"])){
            echo "\"".$_SESSION["user_name"]."\"";} 
          ?>
        />
        <p>郵便番号　[必須]</p>
        <div id="postCodeSearch" class="postCodeSearch">住所検索</div>
        <p id="errInput"></p>
        <p style="color:red" id="postcodeErrMesage" class="NameErrMesage"></p>
        <input class="inputBottom" type="text" name="PostCode" id="inputpostcode" placeholder="Post Code[-]無し" value=
          <?php 
            $data=$dbm->customer_data_get($_SESSION["user_id"]);
            echo "\"".$data[4]."\"";
          ?>
        />
        <p>都道府県　[必須]</p>
        <p style="color:red" id="PrefecturesErrMesage" class="NameErrMesage"></p>
        <input class="inputBottom" type="text" name="Prefectures" id="Prefectures" placeholder="Prefectures" />
        <p>地区町村　[必須]</p>
        <p style="color:red" id="TownsErrMesage" class="NameErrMesage"></p>
        <input class="inputBottom" type="text" name="Towns" id="Towns" placeholder="Town" />
        <p>住所１ [必須]</p>
        <p style="color:red" id="address1ErrMesage" class="NameErrMesage"></p>
        <input class="inputBottom" type="text" name="address1" id="address1" placeholder="address1" />
        <p>住所２</p>
        <input class="inputBottom" type="text" name="address2" placeholder="address2" />
        <p>電話番号　[必須]</p>
        <p style="color:red" id="telErrMesage" class="NameErrMesage"></p>
        <input class="inputBottom" type="text" id="inputtel" name="number" placeholder="number" value=
        <?php 
            $data=$dbm->customer_data_get($_SESSION["user_id"]);
            echo "\"".$data[6]."\"";
          ?>
        />
        <p>お届け日</p>
        <input class="inputBottom" type="date" name="num01" id="num01" value="date" min="2022-11-11" max="2025-12-31" step="1" />
        <p>お届け時間</p>
        <p><select name="time" id="time">
            <option value="">-</option>
            <option value="1">8:00~12:00</option>
            <option value="2">14:00~16:00</option>
            <option value="3">16:00~18:00</option>
            <option value="4">18:00~20:00</option>
          </select></p>
      </form>
      <p><button type="button" class="btn btn-secondary" onclick="location.href='menu-list.php'">
          戻る
        </button>
        <button type="button" id="nextbtnSubmit" class="btn btn-success">
          次へ
        </button>
      </p>
    </div>
  </div>
</body>

</html>

<script>
  // 入力が止まったタイミングで処理を実行
  const AddressSearch = () => {
    let errInput = document.getElementById('errInput') //入力値のエラー項目の検出
    const AddressNomber = document.getElementById('inputpostcode') //郵便番号
    const Prefectures = document.getElementById('Prefectures'); //県の取得
    const Towns = document.getElementById('Towns') // 地区町村
    const address1 = document.getElementById('address1')

    let param = AddressNomber.value
    let api = 'https://zipcloud.ibsnet.co.jp/api/search?zipcode=';
    let url = api + param;

    fetchJsonp(url, {
        timeout: 10000, //タイムアウト時間
      })
      .then((response) => {
        errInput.textContent = ''; //HTML側のエラーメッセージ初期化
        return response.json();
      })
      .then((data) => {
        if (data.status === 400) { //エラー時
          errInput.textContent = data.message;
        } else if (data.results === null) {
          error.textContent = '郵便番号から住所が見つかりませんでした。';
        } else {
          Prefectures.value = data.results[0].address1;
          Towns.value = data.results[0].address2;
          address1.value = data.results[0].address3;
        }
      })
      .catch((ex) => { //例外処理
        console.log(ex);
      });
  }

  // 郵便番号から住所検索
  const postCodeSearch = document.getElementById('postCodeSearch')
  postCodeSearch.addEventListener('click', () => {
    AddressSearch()
  })


  var today = new Date();
  today.getFullYear();
  today.getMonth() + 1;
  today.getDate() + 1;
  var todayNum =
    today.getFullYear() +
    "-" +
    (today.getMonth() + 1) +
    "-" +
    (today.getDate() + 1);

  const inputCal = document.getElementById("num01");
  inputCal.min = todayNum;
  console.log(todayNum);
</script>
<script>
  const Name = document.getElementById("Name");
  const inputpostcode = document.getElementById("inputpostcode");
  const Prefectures = document.getElementById("Prefectures");
  const Towns = document.getElementById("Towns");
  const address1 = document.getElementById("address1");
  const inputtel = document.getElementById("inputtel");


  // postcode 7 桁の数字
  const post = /\d{7}/;
  // telアルファベット小文字、大文字または数値が1文字
  const tel = /^0\d{9,10}$/;

  const nextbtnSubmit = document.getElementById("nextbtnSubmit");
  constNameErrMesage = document.getElementById("NameErrMesage");
  const postcodeErrMesage = document.getElementById("postcodeErrMesage");
  const PrefecturesErrMesage = document.getElementById("PrefecturesErrMesage");
  const TownsErrMesage = document.getElementById("TownsErrMesage");
  const address1ErrMesage = document.getElementById("address1ErrMesage");
  const telErrMesage = document.getElementById("telErrMesage");




  const inputValue = document.getElementsByClassName('NameErrMesage')
  inputValueNum = inputValue.length;


  const changeInput = () => {
    for (let i = 0; i < inputValueNum; i++) {
      const NameErrMesage = document.getElementsByClassName('NameErrMesage')[i];
      NameErrMesage.classList.add('NameErrMesageNone')
    }

    let errCount = 0;
    //Name
    if (Name.value == "") {
      const NameErrMesage = document.getElementsByClassName('NameErrMesage')[0]
      NameErrMesage.classList.remove('NameErrMesageNone')
      NameErrMesage.innerHTML = "お届け先名が未入力です。"
      errCount++;
    }

    //postcode
    if (inputpostcode.value == "") {
      const NameErrMesage = document.getElementsByClassName('NameErrMesage')[1]
      NameErrMesage.classList.remove('NameErrMesageNone')
      postcodeErrMesage.innerHTML = "郵便番号が未入力です。"
      errCount++;
    } else if (!post.test(inputpostcode.value)) {
      const NameErrMesage = document.getElementsByClassName('NameErrMesage')[1]
      NameErrMesage.classList.remove('NameErrMesageNone')
      postcodeErrMesage.innerHTML = "郵便番号の形式が不正です。"
      errCount++;
    }
    //Prefectures
    if (Prefectures.value == "") {
      const NameErrMesage = document.getElementsByClassName('NameErrMesage')[2]
      NameErrMesage.classList.remove('NameErrMesageNone')
      PrefecturesErrMesage.innerHTML = "都道府県が未入力です。"
      errCount++;
    }

    //Towns
    if (Towns.value == "") {
      const NameErrMesage = document.getElementsByClassName('NameErrMesage')[3]
      NameErrMesage.classList.remove('NameErrMesageNone')
      TownsErrMesage.innerHTML = "地区町村が未入力です。"
      errCount++;
    }
    //address1
    if (address1.value == "") {
      const NameErrMesage = document.getElementsByClassName('NameErrMesage')[4]
      NameErrMesage.classList.remove('NameErrMesageNone')
      address1ErrMesage.innerHTML = "住所１が未入力です。"
      errCount++;
    }
    // tel
    if (inputtel.value == "") {
      const NameErrMesage = document.getElementsByClassName('NameErrMesage')[5]
      NameErrMesage.classList.remove('NameErrMesageNone')
      telErrMesage.innerHTML = "電話番号が未入力です。"
      errCount++;
    } else if (!inputtel.value.match(/^0\d{9,10}$/)) {
      const NameErrMesage = document.getElementsByClassName('NameErrMesage')[5]
      NameErrMesage.classList.remove('NameErrMesageNone')
      telErrMesage.innerHTML = "電話番号の形式が不正です。"
      errCount++;
    }

    if (errCount == 0) {
      const formData = new FormData(document.forms.order_data);
      formData.append("customer_id", <?php echo "\"" . $_SESSION["user_id"] . "\"" ?>);
      formData.append("order_destination_name", document.getElementById("Name").value); //お届け先名
      formData.append("delivery_preferred_date", document.getElementById("num01").value); //希望日
      formData.append("time_key", document.getElementById("time").value); //お届け時間

      fetch("addressUpdate.php", {
        method: "POST",
        body: formData,
      })
      .then((res) => res.json())
      .then((data) => {
        if(data=="success"){
          location.href = "payment-page.php";
        }
      });

    } else if (errCount > 0) {
      alert("入力に誤りがあります。")
    }
  }


  nextbtnSubmit.addEventListener('click', () => {
    // errがなければ画面遷移

    changeInput()
  })
</script>

</html>