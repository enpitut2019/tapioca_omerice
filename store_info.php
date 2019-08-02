<?php
//idの取得
$store_id = $_GET["store_id"];

// データベースに接続
$url = parse_url(getenv('DATABASE_URL'));
$dsn = sprintf('pgsql:host=%s;dbname=%s', $url['host'], substr($url['path'], 1));
$pdo = new PDO($dsn, $url['user'], $url['pass']);
$stmt = $pdo->query('SELECT store_name FROM sample0801_db WHERE store_id = '.$store_id);
$result = $stmt -> fetch(PDO::FETCH_ASSOC);
 // var_dump($store_name);//store_nameが取れているか確認
 // print_r($store_name);
 $stmt2 = $pdo->query('UPDATE sample0801_db SET vote_open +=1 WHERE store_id = '.$store_id);
 $result2 = $stmt2 -> fetch(PDO::FETCH_ASSOC);


?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>
  <?php
    echo $result['store_name'];
  ?>
</title> <!-- あとで変数 -->
</head>
<body>
  <h1>
    <?php
      echo $result['store_name'];
    ?>
  </h1> <!-- あとで変数 -->

  <?php
  if (isset($_POST["vote"])) {
  $kbn = htmlspecialchars($_POST["vote"], ENT_QUOTES, "UTF-8");
    switch ($kbn) {
        case "営業中": $vote_o++; break;
        case "閉店中": $vote_c++; break;
        default:  echo "エラー"; exit;
    }
  }
 ?><!-- ボタンの実装 -->

  <form method="POST" action="">
<input type="submit" value="営業中" name="vote">　
<input type="submit" value="閉店中" name="vote">　
</form>




<?php
if($vote_o > $vote_c){
  echo '営業中票数:<font color="RED">'.$vote_o.'</font><br />';
  echo '閉店中票数:'.$vote_c;
} else if($vote_o < $vote_c){
  echo '営業中票数:'.$vote_o.'<br />';
  echo '閉店中票数:<font color="RED">'.$vote_c.'</font>';
} else {
  echo '営業中票数:'.$vote_o.'<br />';
  echo '閉店中票数:'.$vote_c;
}

?>

</body>
</html>
