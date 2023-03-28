<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/reset.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
  <title>食べ食べプラン</title>
</head>

<body>
  <!-- G1-3-2に対応している画面です -->
  <div id="menuWrapper"></div>
  <script type="text/javascript">
    const menuWrapper = document.getElementById("menuWrapper");

    const menuTitle = document.createElement("p");
    menuTitle.innerHTML = "ハンバーグ";
    menuTitle.classList.add("menuTitle");
    menuWrapper.appendChild(menuTitle);

    const menuImage = document.createElement("img");
    menuImage.src = "./img/pasta.jpg";
    menuImage.classList.add("menuDetailImage");
    menuWrapper.appendChild(menuImage);

    // メニュー一覧遷移ボタン
    const buttonArea = document.createElement("div");
    buttonArea.classList.add("buttonArea");
    const closeButtun = document.createElement("button");
    closeButtun.innerHTML = "閉じる";
    closeButtun.setAttribute("class", "closeButtun");
    closeButtun.classList.add = "closeButtun";

    // メニュー追加ボタン
    const addMenuButtun = document.createElement("button");
    addMenuButtun.innerHTML = "+メニューに追加する";
    addMenuButtun.setAttribute("class", "addMenuButtun");
    addMenuButtun.classList.add = "addMenuButtun";

    buttonArea.appendChild(closeButtun);
    buttonArea.appendChild(addMenuButtun);
    menuWrapper.appendChild(buttonArea);

    const introductionText = document.createElement("p");
    const menuTextTaitle = document.createElement("h2");
    menuTextTaitle.innerHTML = "メニューについて";
    menuWrapper.appendChild(menuTextTaitle);
    introductionText.innerHTML =
      "noshメニューの中でも大人気のチリハンバーグステーキです。肉汁をギュッと閉じ込めたジューシーなハンバーグは、噛むほどに肉の旨味が広がり絶品です。辛さ控えめのチリソースが、さらに美味しさを引き立てています。O副菜は、彩り野菜、なすのバジルソース、そら豆のポテトサラダです。";
    menuWrapper.appendChild(introductionText);

    //--------------栄養値要素--------------------
    const nutrientWrapper = document.createElement("div");
    nutrientWrapper.classList.add("nutrientWrapper");
    //   栄養値タイトルの配列
    const nutrientArray = [
      "カロリー",
      "タンパク質",
      "脂質",
      "糖質",
      "食物繊維",
      "塩分",
    ];

    //   栄養値の値の配列
    const nutrientValueArray = [10, 20, 30, 30, 30, 10];

    for (let i = 0; i < nutrientValueArray.length; i++) {
      // 栄養要素のdiv
      const nutrientDiv = document.createElement("div");
      nutrientDiv.classList.add("nutrientDiv");
      // 栄養名
      const nutrientName = document.createElement("p");
      // 栄養値
      const nutrientValue = document.createElement("p");
      nutrientName.innerHTML = nutrientArray[i];

      // カロリーのみkcal表示
      if (i == 0) {
        nutrientValue.innerHTML = nutrientValueArray[i] + "kcal";
      } else {
        nutrientValue.innerHTML = nutrientValueArray[i] + "g";
      }
      nutrientDiv.appendChild(nutrientName);
      nutrientDiv.appendChild(nutrientValue);
      nutrientWrapper.appendChild(nutrientDiv);

      menuWrapper.appendChild(nutrientWrapper);
    }
    //--------------栄養値要素--------------------

    // -------------メニュー詳細------------
    const menuDetailArray = [
      "チリハンバーグステーキ",
      "そら豆のポテトサラダ",
      "チリソース",
      "なすのバジルソース",
      "そら豆のポテトサラダ",
    ];

    const menuDetailWrapper = document.createElement("div");
    const menuDetailDiv = document.createElement("div");
    const menuDetailText = document.createElement("p");
    let menuText = "";
    for (let i = 0; i < menuDetailArray.length; i++) {
      menuText = menuText + " " + menuDetailArray[i];
    }
    const menuDetailTaitle = document.createElement("h2");
    menuDetailTaitle.innerHTML = "メニュー詳細";
    menuWrapper.appendChild(menuDetailTaitle);
    menuDetailText.innerHTML = menuText;
    menuDetailDiv.appendChild(menuDetailText);
    menuDetailWrapper.appendChild(menuDetailDiv);
    menuWrapper.appendChild(menuDetailWrapper);

    // -------------メニュー詳細------------

    // -------------原材料------------
    const menuMaterialArray = [
      "さかな",
      "はまち",
      "まつたけ",
      "わさび",
      "しいたけ",
    ];
    const menuMaterialWrapper = document.createElement("div");
    const menuMaterialDiv = document.createElement("div");
    const menuMaterialText = document.createElement("p");
    let menuMaterial = "";
    for (let i = 0; i < menuMaterialArray.length; i++) {
      menuMaterial = menuMaterial + " " + menuMaterialArray[i];
    }
    menuMaterialText.innerHTML = menuMaterial;
    menuMaterialDiv.appendChild(menuMaterialText);

    const menuMaterialaitle = document.createElement("h2");
    menuMaterialaitle.innerHTML = "メニュー原材料";
    menuWrapper.appendChild(menuMaterialaitle);
    menuMaterialWrapper.appendChild(menuMaterialDiv);
    menuWrapper.appendChild(menuMaterialWrapper);
    // -------------原材料------------

    // -------------閉じる------------
    const closeWrapper = document.createElement("div");
    closeWrapper.classList.add("closeWrapper");
    const closeMenuButton = document.createElement("buttun");
    closeMenuButton.innerHTML = "閉じる";
    closeMenuButton.classList.add("closeMenuButton");
    closeWrapper.appendChild(closeMenuButton);
    menuWrapper.appendChild(closeWrapper);

    closeWrapper.addEventListener("click", () => {
      location.href = "menu-list.php";
    });
    // -------------閉じる------------
  </script>
</body>

</html>