<?php
require("../../sec_info.php");
  
//作成されているテーブルを確認
$sql ='SHOW TABLES';
$result = $pdo -> query($sql);
foreach ($result as $row){
  echo $row[0];
  echo '<br>';
}
echo "<hr>";

//Pre登録者一覧
echo "Pre登録者一覧<br>";
echo "id /メアド /登録日時 /0:未登録 1:登録済 /URLトークン<br>";
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

//Accounts登録者一覧
echo "Accounts登録者一覧<br>";
echo "id /ユーザーネーム /メアド /パスハッシュ<br>";
$sql = 'SELECT * FROM Accounts';
$stmt = $pdo->query($sql);
$results = $stmt->fetchAll();
foreach ($results as $row){
  echo $row['id'].' , ';
  echo $row['name'].' , ';
  echo $row['mead'].' , ';
  echo substr($row['pass'],0,10).'<br>';
}
echo "<hr>";
?>