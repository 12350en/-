<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/reset.css" />
  <link rel="stylesheet" href="css/style.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
  <title>食べ食べプラン</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>

  <script type="text/javascript">
    $(document).ready(function() {
      $('.slider').bxSlider({
        auto: true,
        pause: 5000,
      });
    });
  </script>
  <style>
            .button_solid006 a {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto;
            max-width: 240px;
            padding: 6px 25px;
            background: #4ff665;
            color: #FFF;
            transition: 0.3s ease-in-out;
            font-weight: 600;
            border-radius: 100px;
            box-shadow: 0 5px 0px #4ff665, 0 10px 100px #4ff665;
        }
        .button_solid006 a:hover{
          background:#95ff82;
          box-shadow: 0 5px 0px #00ff00,0 7px 30px #7fff00;
        }

        .button_solid006 a:active{
          background:#95ff82;
          box-shadow: 0 0px 10px #95ff82;
          box-shadow: 0 5px 0px #00ff7f,0 4px 10px #00fa9a;
        }
    </style>
</head>

<body>
  <!-- G1-1に対応しているページです。  -->
  <header>
    <nav>
      <ul class="nav-list">
        <li><a href="menu-list.php"><img src="img/menu-logo.png" /></a></li>
        
        <li><a href="login-page.php"><img src="img/login-logo.png" /></a></li>
      </ul>
    </nav>
  </header>
  <main>
    <div class="slider">
      <img src="img/menu1.png" width="500" height="300" alt="">
      <img src="img/menu2.png" width="500" height="300" alt="">
      <img src="img/menu3.png" width="500" height="300" alt="">
      <img src="img/menu4.png" width="500" height="300" alt="">
    </div>
    <div class="button_solid006">
      <a onclick= "location.href='menu-list.php'">今すぐ始める</a>
      <p></p>
    </div>
    <div class="text-center">
      <p><strong>栄養価基準</strong></p>
        <p></p>
      <p><strong>全てのメニューが糖質30g・塩分2.5g以下。<br>
        専属シェフと管理栄養士が開発しています。</strong></p>
        <img src="img/image.png" width="300" height="300" alt="">
        <p></p>
      </div>
    </div>
  </main>
</body>

</html>