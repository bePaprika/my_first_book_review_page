<?php
require("../../sec_info.php");

//Pre登録者一覧確認
echo "Pre登録者一覧<br>";
$sql = 'SELECT * FROM Pre';
$stmt = $pdo->query($sql);
$results = $stmt->fetchAll();
foreach ($results as $row){
  echo $row['id'].' , ';
  echo $row['mead'].' , ';
  echo $row['register_at'].' , ';
  echo $row['flag'].' , ';
  echo $row['urltoken'].'<br>';
}
echo "<hr>";

//Accounts登録者一覧確認
echo "Accounts登録者一覧<br>";
$sql = 'SELECT * FROM Accounts';
$stmt = $pdo->query($sql);
$results = $stmt->fetchAll();
foreach ($results as $row){
  echo $row['id'].' , ';
  echo $row['name'].' , ';
  echo $row['mead'].' , ';
  echo substr($row['pass'],0,10).' , ';
  echo $row['status'].'<br>';
}
echo "<hr>";


//Pre登録者DB削除
$sql = 'DROP TABLE Pre';
$stmt = $pdo->query($sql);

//Accounts登録者DB削除
$sql = 'DROP TABLE Accounts';
$stmt = $pdo->query($sql);


//Pre登録者DB作成
$sql = "CREATE TABLE IF NOT EXISTS Pre"
." ("
. "id INT AUTO_INCREMENT PRIMARY KEY," //ID
. "urltoken char(255)," //URLtoken
. "mead char(128)," //メールアドレス
. "register_at DATETIME," //申込日時
. "flag INT" //フラグ
.");";
$stmt = $pdo->query($sql);

//Accounts登録者DB作成
$sql = "CREATE TABLE IF NOT EXISTS Accounts"
." ("
. "id INT AUTO_INCREMENT PRIMARY KEY," //ID
. "name char(128)," //ユーザー名
. "mead char(128)," //メールアドレス
. "pass char(128)," //パスワード
. "status INT," //1.本会員 2.仮会員
. "created_at DATETIME," //登録日
. "updated_at DATETIME," //更新日
. "intr TEXT"  //自己紹介
.");";
$stmt = $pdo->query($sql);

echo "これらのDBを初期化しました<br>";
?>