<?php
class DBManager
{
    private function dbconnect()
    { //データベース接続
        //$pdo=new PDO('mysql:host=mysql208.phy.lolipop.lan;dbname=LAA1418151-ateam;charset=utf8','LAA1418151','1018');

        //$pdo = new PDO('mysql:host=localhost;dbname=asoproject;charset=utf8', 'shodai0210', 'Syodai0210');

        $pdo = new PDO('mysql:host=localhost;dbname=ateamsample;charset=utf8','webuser','abccsd2');

        return $pdo;
    }

    function account_registration($customer_name, $customer_email, $customer_password)
    { //アカウント登録処理　動作確認終了
        $pdo = $this->dbconnect();
        $sql = "INSERT INTO customer (customer_name,customer_email,customer_password) VALUES (?,?,?)";
        $ps = $pdo->prepare($sql);
        $ps->bindValue(1, $customer_name, PDO::PARAM_STR); //ユーザー名登録
        $ps->bindValue(2, $customer_email, PDO::PARAM_STR); //メールアドレス登録
        //$ps->bindValue(3,password_hash($customer_password,PASSWORD_DEFAULT),PDO::PARAM_STR);//パスワードのハッシュ化・登録(できたらやる)
        $ps->bindValue(3, $customer_password, PDO::PARAM_STR);
        $ps->execute();
    }

    function address_update($customer_id, $post_code, $prefectures, $town, $address1, $address2, $number)
    { //住所情報登録・更新処理
        $pdo = $this->dbconnect();
        $address = $prefectures . $town . $address1 . $address2;
        $sql = "UPDATE customer SET customer_postalCode = ?,customer_address = ?,customer_number = ? WHERE customer_id = ?";
        $ps = $pdo->prepare($sql);
        $ps->bindValue(1, $post_code, PDO::PARAM_STR);
        $ps->bindValue(2, $address, PDO::PARAM_STR);
        $ps->bindValue(3, $number, PDO::PARAM_STR);
        $ps->bindValue(4, $customer_id, PDO::PARAM_STR);
        $ps->execute();
    }

    function login_check($customer_email, $customer_password)
    { //ログイン情報確認
        $pdo = $this->dbconnect();
        $sql = "SELECT * FROM customer WHERE customer_email = ?";
        $ps = $pdo->prepare($sql);
        $ps->bindValue(1, $customer_email, PDO::PARAM_STR);
        $ps->execute();

        $user_data = $ps->fetchAll();

        if (empty($user_data)) {
            throw new BadMethodCallException("IDが存在しません");
        }

        foreach ($user_data as $row) {
            if ($row["customer_password"] == $customer_password) {
                return $user_data;
            } else {
                throw new LogicException("パスワードが違います。");
            }
        }
    }

    function customer_data_get($customer_id)
    {//顧客情報取得
        $pdo = $this->dbconnect();
        $sql = "SELECT * FROM customer WHERE customer_id = ?";
        $ps = $pdo->prepare($sql);
        $ps->bindValue(1, $customer_id, PDO::PARAM_STR);
        $ps->execute();
        $customer_data = $ps -> fetchAll();
        return $customer_data[0];
    }

    function passeward_reset($customer_email,$reset_password)
    {
        //パスワード再設定
        $pdo = $this->dbconnect();
        $sql = "UPDATE customer SET customer_password = ? WHERE customer_email = ?";
        $ps = $pdo->prepare($sql);
        $ps->bindValue(1, $reset_password, PDO::PARAM_STR);
        $ps->bindValue(2, $customer_email, PDO::PARAM_STR);
        $ps->execute();
    }

    function inventory_check($menu_id,$subtraction_num){
        $pdo = $this->dbconnect();
        $sql = "SELECT inventory FROM menu WHERE menu_id = ?";
        $ps = $pdo->prepare($sql);
        $ps->bindValue(1, $menu_id, PDO::PARAM_INT);
        $ps->execute();
        $inventory = $ps->fetch();
        if($subtraction_num > $inventory[0]){
            throw new Exception("在庫不足です");
        }

    }

    function inventory_subtraction($menu_id, $subtraction_num)
    {//在庫減算処理
        $pdo = $this->dbconnect();
        $sql = "UPDATE menu SET inventory = inventory - ? WHERE menu_id = ?";
        $ps = $pdo->prepare($sql);
        $ps->bindValue(1, $subtraction_num, PDO::PARAM_INT);
        $ps->bindValue(2, $menu_id, PDO::PARAM_INT);
        $ps->execute();
    }

    function order_data_create($menu_1,$menu_2,$menu_3,$menu_4,$menu_5,$menu_6,$menu_7,$destination_name,$delivery_day,$delivery_time_key,$payment_key,$customer_id)
    {//購入情報作成
        $pdo = $this->dbconnect();
        $sql = "INSERT INTO orders (order_menu1,order_menu2,order_menu3,order_menu4,order_menu5,order_menu6,order_menu7,
        order_destination_name,order_date,delivery_preferred_date_start,delivery_preferred_date_last,paymentMethod_id,customer_id) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $ps = $pdo->prepare($sql);
        //メニュー1~7まで
        // foreach($order_menu_list as $index=>$menu){
        //     $ps->bindValue($index+1,$menu,PDO::PARAM_INT);
        // }
        $ps->bindValue(1,$menu_1,PDO::PARAM_INT);
        $ps->bindValue(2,$menu_2,PDO::PARAM_INT);
        $ps->bindValue(3,$menu_3,PDO::PARAM_INT);
        $ps->bindValue(4,$menu_4,PDO::PARAM_INT);
        $ps->bindValue(5,$menu_5,PDO::PARAM_INT);
        $ps->bindValue(6,$menu_6,PDO::PARAM_INT);
        $ps->bindValue(7,$menu_7,PDO::PARAM_INT);
        //届け先名
        $ps->bindValue(8, $destination_name, PDO::PARAM_STR);
        $ps->bindValue(9, date("Y-m-d H:i:s"), PDO::PARAM_STR);
        //届け日・配達希望日
        switch ($delivery_time_key){
            case "1" :
                $ps->bindValue(10, $delivery_day." "."08:00:00", PDO::PARAM_STR);
                $ps->bindValue(11, $delivery_day." "."12:00:00", PDO::PARAM_STR);
                break;
            case "2":
                $ps->bindValue(10, $delivery_day." "."14:00:00", PDO::PARAM_STR);
                $ps->bindValue(11, $delivery_day." "."16:00:00", PDO::PARAM_STR);
                break;
            case "3":
                $ps->bindValue(10, $delivery_day." "."16:00:00", PDO::PARAM_STR);
                $ps->bindValue(11, $delivery_day." "."18:00:00", PDO::PARAM_STR);
                break;
            case "4":
                $ps->bindValue(10, $delivery_day." "."18:00:00", PDO::PARAM_STR);
                $ps->bindValue(11, $delivery_day." "."20:00:00", PDO::PARAM_STR);
                break;
            default:
                $ps->bindValue(10, $delivery_day." "."00:00:00", PDO::PARAM_STR);
                $ps->bindValue(11, $delivery_day." "."23:59:99", PDO::PARAM_STR);
        }
        //支払い方法
        $ps->bindValue(12, $payment_key, PDO::PARAM_STR);

        $ps->bindValue(13, $customer_id, PDO::PARAM_STR);

        $ps->execute();
    }

    function allergen_display()
    { //アレルゲン食材をDBから取得
        $pdo = $this->dbconnect();
        $sql = "SELECT * FROM allergy_ingredient"; //アレルギー食材テーブルのデータを全件取得
        $ps = $pdo->query($sql);

        $allergen_list = $ps->fetchAll();
        echo "let foodArray=[";

        foreach ($allergen_list as $allergen_data) { //配列にDBから取得したアレルゲン食材追加
            echo "\"" . $allergen_data["allergy_IngredientName"] . "\",";
        }

        echo "];";
    }


    function menu_display()
    { //メニュー表示情報全件取得
        $pdo = $this->dbconnect();
        $sql = "SELECT * FROM menu";
        $ps = $pdo->query($sql);
        $menu_list = $ps->fetchAll();


        echo "var menuArray=[";

        foreach ($menu_list as $menu_data) { //配列にオブジェクト追加
            echo "[\"" . $menu_data['menu_name'] . "\"";
            echo ",";
            echo "\"" . $menu_data['menu_picture'] . "\"";
            echo ",";
            echo $menu_data['menu_sugarContent'];
            echo ",";
            echo $menu_data['menu_lipid'];
            echo ",";
            echo $menu_data['menu_foodFiber'];
            echo ",";
            echo $menu_data['menu_solt'];
            echo ",";
            echo $menu_data['menu_calorie'];
            echo ",";
            echo $menu_data['menu_protein'] . "],";
        }

        echo "];";
    }


    function menuCreate()
    {// メニュー要素作成(ヤマツ)
        $pdo = $this->dbconnect();
        $sql = "SELECT * FROM menu";
        $ps = $pdo->query($sql);
        $menu_list = $ps->fetchAll();
        foreach ($menu_list as $index => $menu_data) {
            if($menu_data["inventory"]<=7){
                continue;
            }
            echo '<div class="menuWrapper" value=' .   ($menu_data["menu_id"] - 1) .  '>';
            echo '<p class="menuText">' . $menu_data['menu_name'] . '</p>';
            echo '<img class="menuImage" src=' . 'img/' . $menu_data['menu_picture'] .  '>';
            echo '<div class="menuSugar">糖質は' . $menu_data['menu_sugarContent'] . 'g</div>';
            echo '<div class="btnWrapper">';
            echo '<button class="deleteButtun">削除</button><button class="addButtun" value=' .   ($menu_data["menu_id"] - 1) .  '>追加</button>';
            echo '</div>';
            echo '<div class="menuCountArea">';
            echo '<p class = "selectCount">0食</p>';
            echo '</div>';
            echo '</div>';
        }
    }

    
    function allergyCreate()
    {// アレルギー要素作成(ヤマツ)
        $pdo = $this->dbconnect();
        $sql = "SELECT * FROM allergy_ingredient";
        $ps = $pdo->query($sql);
        $allergy_list = $ps->fetchAll();
        foreach ($allergy_list as  $index => $allergy_data) {
            echo '<div>';
            if ($index < 10) {
                echo '<buttun class="foodContentText name="name1" value=' . "000000" . "$index" . '>' . $allergy_data['allergy_IngredientName'] . '</buttun>';
            } else {
                echo '<buttun class="foodContentText name="name1" value=' . "00000" . "$index" . '>' . $allergy_data['allergy_IngredientName'] . '</buttun>';
            }
            echo '</div>';
        }
    }


    
    function allergyCreateElement($id)
    {// アレルギー要素の作成(ヤマツ)
        $pdo = $this->dbconnect();
        $sql = "SELECT * FROM menu WHERE menu_using_food LIKE ?";
        $ps = $pdo->prepare($sql);
        $searchId = '%' . $id . '%';
        $ps->bindValue(1, $searchId, PDO::PARAM_STR);
        $ps->execute();
        $menu_list = $ps->fetchAll();
        foreach ($menu_list as $index => $menu_data) {
            echo '<div class="menuWrapper">';
            echo '<p class="menuText">' . $menu_data['menu_name'] . '</p>';
            echo '<img class="menuImage" src=' . 'img/' . $menu_data['menu_picture'] .  '>';
            echo '<div class="menuSugar">糖質は' . $menu_data['menu_sugarContent'] . 'g</div>';
            echo '<div class="btnWrapper">';
            echo '<button class="deleteButtun">削除</button><button class="addButtun"value=' .   ($menu_data["menu_id"] - 1) . '>追加</button>';
            echo '</div>';
            echo '<div class="menuCountArea">';
            echo '<p class = "selectCount">0食</p>';
            echo '</div>';
            echo '</div>';
        }
    }



    function menu_sort($sort_key)
    { //引数で並べ替えのキー指定
        $pdo = $this->dbconnect();
        if ($sort_key == "1") {
            $sql = "SELECT * FROM menu ORDER BY menu_sugarContent DESC";
        } else if ($sort_key == "2") {
            $sql = "SELECT * FROM menu ORDER BY menu_solt DESC";
        } else if ($sort_key == "3") {
            $sql = "SELECT * FROM menu ORDER BY menu_foodFiber DESC";
        } else if ($sort_key == "4") {
            $sql = "SELECT * FROM menu ORDER BY menu_calorie DESC";
        } else if ($sort_key == "5") {
            $sql = "SELECT * FROM menu ORDER BY menu_protein DESC";
        } else if ($sort_key == "6") {
            $sql = "SELECT * FROM menu ORDER BY menu_lipid DESC";
        }
        $ps = $pdo->query($sql);
        $menu_list = $ps->fetchAll();
        foreach ($menu_list as $index => $menu_data) { //配列の再描写
            if($menu_data["inventory"]<=7){
                continue;
            }
            echo '<div class="menuWrapper">';
            echo '<p class="menuText">' . $menu_data['menu_name'] . '</p>';
            echo '<img class="menuImage" src=' . 'img/' . $menu_data['menu_picture'] .  '>';

            if ($sort_key == "1") {
                echo '<div class="menuSugar">糖質は' . $menu_data['menu_sugarContent'] . 'g</div>';
            } else if ($sort_key == "2") {
                echo '<div class="menuSugar">塩分は' . $menu_data['menu_solt'] . 'g</div>';
            } else if ($sort_key == "3") {
                echo '<div class="menuSugar">食物繊維は' . $menu_data['menu_foodFiber'] . 'g</div>';
            } else if ($sort_key == "4") {
                echo '<div class="menuSugar">カロリーは' . $menu_data['menu_calorie'] . 'g</div>';
            } else if ($sort_key == "5") {
                echo '<div class="menuSugar">タンパク質は' . $menu_data['menu_protein'] . 'g</div>';
            } else if ($sort_key == "6") {
                echo '<div class="menuSugar">脂質は' . $menu_data['menu_lipid'] . 'g</div>';
            }

            echo '<div class="btnWrapper">';
            echo '<button class="deleteButtun">削除</button><button class="addButtun" value=' . "$index" . '>追加</button>';
            echo '</div>';
            echo '<div class="menuCountArea">';
            echo '<p class = "selectCount">0食</p>';
            echo '</div>';
            echo '</div>';
        }
    }


    //糖質で並び替え(後程削除)
    function menuSortSugar()
    {
        $pdo = $this->dbconnect();
        $sql = "SELECT * FROM menu ORDER BY menu_sugarContent DESC";
        $ps = $pdo->query($sql);
        $menu_list = $ps->fetchAll();
        foreach ($menu_list as $index => $menu_data) {

            echo '<div class="menuWrapper">';
            echo '<p class="menuText">' . $menu_data['menu_name'] . '</p>';
            echo '<img class="menuImage" src=' . 'img/' . $menu_data['menu_picture'] .  '>';
            echo '<div class="menuSugar">糖質は' . $menu_data['menu_sugarContent'] . 'g</div>';
            echo '<div class="btnWrapper">';
            echo '<button class="deleteButtun">削除</button><button class="addButtun" value=' . "$index" . '>追加</button>';
            echo '</div>';
            echo '<div class="menuCountArea">';
            echo '<p class = "selectCount">0食</p>';
            echo '</div>';
            echo '</div>';
        }
    }
    // 糖質(0)
    // 塩分(1)
    // カロリー(2)
    // タンパク質(3)
    // 脂質(4)

    function inclusion_allergy_get($id){
        $pdo = $this->dbconnect();
        $sql = "SELECT allergy_id FROM inclusion_allergy WHERE menu_id = ?";
        $ps = $pdo->prepare($sql);
        $ps->bindValue(1, $id, PDO::PARAM_STR);
        $ps->execute();

        $allergy_list = $ps->fetchAll();
        $result="";

        foreach($allergy_list as $allergen => $index){
            if($index == 0){
                $result=$allergen;
            }
            $result=$result."・".$allergen;
        }

        return $result;
        
    }

    function menu_detail_display($id)
    {
        $pdo = $this->dbconnect();
        $sql = "SELECT * FROM menu WHERE menu_id = ?";
        $ps = $pdo->prepare($sql);
        $ps->bindValue(1, $id, PDO::PARAM_STR);
        $ps->execute();

        $menu = $ps->fetchAll();

        $sql = "SELECT allergy_IngredientName FROM allergy_ingredient WHERE allergy_id IN(
            SELECT allergy_id FROM inclusion_allergy WHERE menu_id = ?)";
            $ps2 = $pdo->prepare($sql);
            $ps2->bindValue(1, $id, PDO::PARAM_STR);
            $ps2->execute();
    
            $allergy_list = $ps2->fetchAll();
            $result="";
    
            foreach($allergy_list as $index => $allergen){
                if($index == 0){
                    $result=$allergen["allergy_IngredientName"];
                    continue;
                }
                $result=$result."・".$allergen["allergy_IngredientName"];
            }

        foreach ($menu as $menu_data) {
            echo "<div id=\"menuWrapper\">";
            echo    "<p class=\"menuTitle\">" . $menu_data["menu_name"] . "</p>";
            echo    "<img src=\"./img/" . $menu_data["menu_picture"] . "\" class=\"menuDetailImage\">";
            echo    "<h2>メニューについて</h2>";
            echo    "<p>" . $menu_data["menu_explanation"] . "</p>";
            echo    "<div class=\"nutrientWrapper\">";
            echo        "<div class=\"nutrientDiv\">";
            echo            "<p>カロリー</p><p>" . $menu_data["menu_calorie"] . "kcal</p>";
            echo        "</div>";
            echo        "<div class=\"nutrientDiv\">";
            echo            "<p>タンパク質</p><p>" . $menu_data["menu_protein"] . "g</p>";
            echo        "</div>";
            echo        "<div class=\"nutrientDiv\">";
            echo            "<p>脂質</p><p>" . $menu_data["menu_lipid"] . "g</p>";
            echo        "</div>";
            echo        "<div class=\"nutrientDiv\">";
            echo            "<p>糖質</p><p>" . $menu_data["menu_sugarContent"] . "g</p>";
            echo        "</div>";
            echo        "<div class=\"nutrientDiv\">";
            echo            "<p>食物繊維</p><p>" . $menu_data["menu_foodFiber"] . "g</p>";
            echo        "</div>";
            echo        "<div class=\"nutrientDiv\">";
            echo            "<p>塩分</p><p>" . $menu_data["menu_solt"] . "g</p>";
            echo        "</div>";
            echo    "</div>";
            echo    "<h2>メニュー詳細</h2>";
            echo    "<div>";
            echo        "<div>";
            echo            "<p>" . $menu_data["menu_detail"] . "</p>";
            echo        "</div>";
            echo    "</div>";
            echo    "<h2>メニュー原材料</h2>";
            echo    "<div>";
            echo        "<div>";
            echo            "<p>" . $menu_data["menu_using_food"] . "</p>";
            echo        "</div>";
            echo    "</div>";

            echo    "<h2>アレルギー(特定原材料)</h2>";
            echo    "<div>";
            echo        "<div>";
            echo            "<p>" . $result . "</p>";
            echo        "</div>";
            echo    "</div>";

            echo    "<div class=\"closeWrapper\">";
            echo        "<buttun  id=\"closeMenuButton\" class=\"closeMenuButton\">閉じる</buttun>";
            echo    "</div>";
            echo "</div>";
        }
    }

    function menu_allergy_filter($filtering_allergy_key,$sort_key) 
    {//アレルギーフィルター
        $pdo = $this->dbconnect();
        //副問い合わせ　指定したアレルギーを含むメニューのIDを検索し、NOT INでメニュー情報指定アレルゲンを含まないメニュー情報取得
        $sql = "SELECT * FROM menu WHERE menu_id NOT IN (SELECT DISTINCT menu_id FROM inclusion_allergy WHERE ";
        $ps = $pdo->prepare($sql);
        //配列の要素数取得
        $allergy_num = count($filtering_allergy_key);
        //要素の数だけORで条件を追加
        for ($i = 0; $i < $allergy_num; $i++) {
            if ($i == 0) {
                $sql = $sql . "allergy_id = ? ";
                continue;
            }
            $sql = $sql . "OR allergy_id = ? ";
        }

        $sql = $sql . ")";

        if ($sort_key == "1") {
            $sql = $sql . "ORDER BY menu_sugarContent DESC";
        } else if ($sort_key == "2") {
            $sql = $sql . "ORDER BY menu_lipid DESC";
        } else if ($sort_key == "3") {
            $sql = $sql . "ORDER BY menu_foodFiber DESC";
        } else if ($sort_key == "4") {
            $sql = $sql . "ORDER BY menu_solt DESC";
        } else if ($sort_key == "5") {
            $sql = $sql . "ORDER BY menu_calorie DESC";
        } else if ($sort_key == "6") {
            $sql = $sql . "ORDER BY menu_protein DESC";
        }

        $ps = $pdo->prepare($sql);
        //値をバインド
        for ($i = 0; $i < $allergy_num; $i++) {
            $ps->bindValue($i + 1, $filtering_allergy_key[$i], PDO::PARAM_STR);
        }

        $ps->execute();

        $menu = $ps->fetchAll();

        if (!isset($menu)) {
            return 0;
        }

        foreach ($menu as $index => $menu_data) {

            if($menu_data["inventory"]<=7){
                continue;
            }

            echo '<div class="menuWrapper">';
            echo '<p class="menuText">' . $menu_data['menu_name'] . '</p>';
            echo '<img class="menuImage" src=' . 'img/' . $menu_data['menu_picture'] .  '>';

            if ($sort_key == "1") {
                echo '<div class="menuSugar">糖質は' . $menu_data['menu_sugarContent'] . 'g</div>';
            } else if ($sort_key == "2") {
                echo '<div class="menuSugar">塩分は' . $menu_data['menu_solt'] . 'g</div>';
            } else if ($sort_key == "3") {
                echo '<div class="menuSugar">食物繊維は' . $menu_data['menu_foodFiber'] . 'g</div>';
            } else if ($sort_key == "4") {
                echo '<div class="menuSugar">カロリーは' . $menu_data['menu_calorie'] . 'g</div>';
            } else if ($sort_key == "5") {
                echo '<div class="menuSugar">タンパク質は' . $menu_data['menu_protein'] . 'g</div>';
            } else if ($sort_key == "6") {
                echo '<div class="menuSugar">脂質は' . $menu_data['menu_lipid'] . 'g</div>';
            }else{
                echo '<div class="menuSugar">糖質は' . $menu_data['menu_sugarContent'] . 'g</div>';
            }

            echo '<div class="btnWrapper">';
            echo '<button class="deleteButtun">削除</button><button class="addButtun" value=' . "$index" . '>追加</button>';
            echo '</div>';
            echo '<div class="menuCountArea">';
            echo '<p class = "selectCount">0食</p>';
            echo '</div>';
            echo '</div>';
        }
    }
    function menuheader()
    {
        echo '<style>
            .headerWrappr{
                padding: 2% 0;
                border: 1px solid #9b9b9b;
                margin-bottom: 20px;
            }
        </style>';
        echo '<p class="text-success"><strong>ご購入手続き</strong></p>';
    }
}
